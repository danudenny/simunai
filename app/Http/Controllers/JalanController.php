<?php

namespace App\Http\Controllers;

use App\Exports\JalanExport;
use Illuminate\Http\Request;
use App\Jalan;
use App\Kecamatan;
use App\Lampiran;
use App\LaporanWarga;
use App\Riwayat;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class JalanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Jalan::orderBy('id', 'ASC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('nama_ruas', function($jalan) {
                    $ruas = "<strong><a class='text-success' href='jalan/details/$jalan->id'>$jalan->nama_ruas <i class='ik ik-arrow-up-right' title='Details'></i> <a></strong>";
                    return $ruas;
                })
                ->editColumn('status_jalan', function($jalan) {
                    if ($jalan->status_jalan == null) {
                        return "-";
                    } else {
                        return "Jalan " . ucfirst($jalan->status_jalan);
                    }
                })
                ->editColumn('kelas_jalan', function($jalan) {
                    if ($jalan->kelas_jalan == null) {
                        return "-";
                    } else {
                        return $jalan->kelas_jalan;
                    }
                })
                ->editColumn('panjang', function($jalan) {
                    return number_format($jalan->panjang);
                })
                ->addColumn('kecamatan', function (Jalan $jalan) {
                    return $jalan->kecamatan->nama;
                })
                ->addColumn('kondisi_jalan', function ($jalan) {
                    if ($jalan->kondisi_jalan == 'baik') {
                        $span = "<span class='badge badge-success'>" . ucfirst($jalan->kondisi_jalan) . "</span>";
                    } elseif ($jalan->kondisi_jalan == 'sedang') {
                        $span = "<span class='badge badge-primary'>" . ucfirst($jalan->kondisi_jalan) . "</span>";
                    } elseif($jalan->kondisi_jalan == 'rusak') {
                        $span = "<span class='badge badge-info'>" . ucfirst($jalan->kondisi_jalan) . "</span>";
                    } elseif($jalan->kondisi_jalan == 'rusak_ringan') {
                        $span = "<span class='badge badge-warning'>" . ucfirst($jalan->kondisi_jalan) . "</span>";
                    } elseif($jalan->kondisi_jalan == 'rusak_berat') {
                        $span = "<span class='badge badge-danger'>" . ucfirst($jalan->kondisi_jalan) . "</span>";
                    } else {
                        $span = "-";
                    }
                    return $span;
                })
                ->addColumn('action', function($jalan){
                    if (Auth::guest() ) {
                        return '';
                    } else{
                        return "<div>
                                <form action='jalan/hapus/$jalan->id' id='delete$jalan->id' method='POST'>
                                    " . csrf_field() . "
                                    <input type='hidden' name='_method' value='delete'>
                                    <a class='btn btn-info btn-rounded' href='jalan/edit/$jalan->id'>Edit</a>
                                    <button type='submit' class='btn btn-danger btn-rounded delete-confirm' data-id='$jalan->id'>Hapus</button>
                                </form>
                            </div>";
                    }
                })
                ->rawColumns(['action', 'kondisi_jalan', 'nama_ruas'])
                ->make(true);
        }
        $jalan = Jalan::all();
        return view('pages.jalan.index', compact('jalan'));
    }

    public function create()
    {
        $kecamatan = Kecamatan::orderBy('nama')->get();
        return view('pages.jalan.create', compact('kecamatan'));
    }

    public function show($id)
    {
        $where = array('id' => $id);
        $data = Jalan::where($where)->first();
        $kecamatan = Kecamatan::orderBy('nama')->get();
        $lampiran = Lampiran::where('jalan_id', '=', $id)->get();
        $laporan = LaporanWarga::where('jalan_id', '=', $id)->get();
        $riwayat = Riwayat::where('jalan_id', '=', $id)->orderBy('tahun', 'desc')->get();
        return view('pages.jalan.show', compact('data', 'kecamatan', 'lampiran', 'riwayat', 'laporan'));
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $kecamatan = Kecamatan::orderBy('nama')->get();
        $data = Jalan::where($where)->first();
        return view('pages.jalan.edit', compact('data', 'kecamatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ruas' => 'required',
            'kecamatan_id' => 'required',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
        ]);
        $update = [
            'nama_ruas' => $request->nama_ruas,
            'kecamatan_id' => $request->kecamatan_id,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'status_jalan' => $request->status_jalan,
            'kondisi_jalan' => $request->kondisi_jalan,
            'jenis_perkerasan' => $request->jenis_perkerasan,
            'kelas_jalan' => $request->kelas_jalan,
        ];

        if ($request->hasFile('geojson')) {
            $request->file('geojson')->move(public_path('peta/jalan/'), $request->file('geojson')->getClientOriginalName());
            $update['geojson'] = 'peta/jalan/' . $request->file('geojson')->getClientOriginalName();
        }

        $update['nama_ruas'] = $request->get('nama_ruas');
        $update['kecamatan_id'] = $request->get('kecamatan_id');
        $update['panjang'] = $request->get('panjang');
        $update['lebar'] = $request->get('lebar');
        $update['status_jalan'] = $request->get('status_jalan');
        $update['kondisi_jalan'] = $request->get('kondisi_jalan');
        $update['jenis_perkerasan'] = $request->get('jenis_perkerasan');
        $update['kelas_jalan'] = $request->get('kelas_jalan');

        if($request->hasfile('images')) {
            foreach($request->file('images') as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path('foto/jalan/'), $name);
                $dataimg[] = $name;
            }


            $upload_images = Lampiran::where('jalan_id', $id)->update($update);
            $upload_images->file_name = json_encode($dataimg);
            $upload_images->is_video = ($request->url) ? true : false;
            $upload_images->url = ($request->url) ? json_encode($request->url) : '';
            $upload_images->save();
        }

        $notification = array(
            'message' => 'Sukses Memperbarui Data Ruas Jalan!',
            'alert-type' => 'success'
        );

        Jalan::where('id', $id)->update($update);
        return Redirect::to('jalan')
            ->with($notification);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruas' => 'required',
            'kecamatan_id' => 'required',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric'
        ]);

        if ($request->hasFile('geojson')) {
            $request->file('geojson')->move(public_path('peta/jalan/'), $request->file('geojson')->getClientOriginalName());
        }

        $tambahJalan = Jalan::create([
            'nama_ruas' => $request->nama_ruas,
            'kecamatan_id' => $request->kecamatan_id,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'status_jalan' => $request->status_jalan,
            'kondisi_jalan' => $request->kondisi_jalan,
            'jenis_perkerasan' => $request->jenis_perkerasan,
            'kelas_jalan' => $request->kelas_jalan,
            'geojson' => 'peta/jalan/' . $request->file('geojson')->getClientOriginalName(),
        ]);

        if($request->hasfile('images')) {
            foreach($request->file('images') as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path('foto/jalan/'), $name);
                $dataimg[] = $name;
            }


            $upload_images = new Lampiran();
            $upload_images->file_name = json_encode($dataimg);
            $upload_images->jalan_id = $tambahJalan['id'];
            $upload_images->is_video = ($request->url) ? true : false;
            $upload_images->url = ($request->url) ? json_encode($request->url) : '';
            $upload_images->save();
        }

        $notification = array(
            'message' => 'Sukses Menambah Data Ruas Jalan!',
            'alert-type' => 'success'
        );
        return Redirect::to('jalan')
            ->with($notification);
    }

    public function destroy($id)
    {
        Jalan::find($id)->delete();
        $notification = array(
            'message' => 'Sukses Menghapus Data Ruas Jalan!',
            'alert-type' => 'success'
        );
        return Redirect::back()->with($notification);
    }

    public function generatePdf() {
        $jalan = Jalan::orderBy('id', 'ASC')->get();

        $img_type = 'png';
        $image = base64_encode(file_get_contents('https://res.cloudinary.com/killtdj/image/upload/q_40/v1621363029/Lambang_Kabupaten_Banyuasin_frvjhm.png'));
        $img_src = "data:image/".$img_type.";base64,".str_replace ("\n", "", $image);

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('pdf.jalan-pdf', compact('jalan', 'img_src'))
            ->setPaper('a4', 'landscape');
        return $pdf->stream('Data Ruas Jalan Kabupaten Banyuasin.pdf');
    }

    public function export_excel(){
		return Excel::download(new JalanExport, 'Data Ruas Jalan Kabupaten Banyuasin.xlsx');
	}
}
