<?php

namespace App\Http\Controllers;

use App\Exports\JalanExport;
use App\Kondisi;
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

            $hasil = [];
            $jalan = Jalan::orderBy('id', 'ASC')->get();

            if($request->kecamatan != null){
                $jalan = $jalan->where('kecamatan_id', $request->kecamatan);
            }

            if($request->kelas_jalan != null){
                $jalan = $jalan->where('kelas_jalan', $request->kelas_jalan);
            }

            if($request->status_jalan != null){
                $jalan = $jalan->where('status_jalan', $request->status_jalan);
            }

            if($request->jenis_perkerasan != null){
                $jalan = $jalan->where('jenis_perkerasan', $request->jenis_perkerasan);
            }

            foreach($jalan as $data){
                $hasil[] = $data;
            }

            return Datatables::of($hasil)
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
                ->editColumn('panjang', function($jalan) {
                    return $jalan->panjang;
                })
                ->addColumn('kecamatan', function (Jalan $jalan) {
                    return $jalan->kecamatan->nama;
                })
                ->editColumn('jenis_perkerasan', function($jalan) {
                    if ($jalan->jenis_perkerasan == null) {
                        return "-";
                    } else {
                        return ucfirst($jalan->jenis_perkerasan);
                    }
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
        $kecamatan = Kecamatan::all();
        $jalan = Jalan::all();
        return view('pages.jalan.index', compact('jalan','kecamatan'));
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
        $lampiran = Lampiran::where(['jalan_id' => $id])->first();
        return view('pages.jalan.edit', compact('data', 'kecamatan', 'lampiran'));
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
            'jenis_perkerasan' => $request->jenis_perkerasan,
            'kelas_jalan' => $request->kelas_jalan,
            'th_data' => $request->th_data,
            'mendukung' => $request->mendukung,
            'uraian_dukungan' => $request->uraian_dukungan,
            'titik_pengenal_awal' => $request->titik_pengenal_awal,
            'titik_pengenal_akhir' => $request->titik_pengenal_akhir,
            'kode_patok' => $request->kode_patok,
            'baik' => $request->baik,
            'sedang' => $request->sedang,
            'rusak_ringan' => $request->rusak_ringan,
            'rusak_berat' => $request->rusak_berat,
            'mantap' => $request->mantap,
            'tidak_mantap' => $request->tidak_mantap,
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
        $update['jenis_perkerasan'] = $request->get('jenis_perkerasan');
        $update['kelas_jalan'] = $request->get('kelas_jalan');
        $update['th_data'] = $request->get('th_data');
        $update['mendukung'] = $request->get('mendukung');
        $update['uraian_dukungan'] = $request->get('uraian_dukungan');
        $update['titik_pengenal_awal'] = $request->get('titik_pengenal_awal');
        $update['titik_pengenal_akhir'] = $request->get('titik_pengenal_akhir');
        $update['kode_patok'] = $request->get('kode_patok');
        $update['baik'] = $request->get('baik');
        $update['sedang'] = $request->get('sedang');
        $update['rusak_ringan'] = $request->get('rusak_ringan');
        $update['rusak_berat'] = $request->get('rusak_berat');
        $update['mantap'] = $request->get('mantap');
        $update['tidak_mantap'] = $request->get('tidak_mantap');

        if($request->hasfile('images')) {
            foreach($request->file('images') as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path('foto/jalan/'), $name);
                $dataimg[] = $name;
            }


            $update_lampiran['file_name'] = json_encode($dataimg);
            $update_lampiran['is_video'] = ($request->url) ? true : false;
            $update_lampiran['url'] = ($request->url) ? json_encode($request->url) : '';
            $upload_images = Lampiran::where('jalan_id', $id)->update($update_lampiran);
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
            'jenis_perkerasan' => $request->jenis_perkerasan,
            'kelas_jalan' => $request->kelas_jalan,
            'th_data' => $request->th_data,
            'mendukung' => $request->mendukung,
            'uraian_dukungan' => $request->uraian_dukungan,
            'titik_pengenal_awal' => $request->titik_pengenal_awal,
            'titik_pengenal_akhir' => $request->titik_pengenal_akhir,
            'kode_patok' => $request->kode_patok,
            'baik' => $request->baik,
            'sedang' => $request->sedang,
            'rusak_ringan' => $request->rusak_ringan,
            'rusak_berat' => $request->rusak_berat,
            'mantap' => $request->mantap,
            'tidak_mantap' => $request->tidak_mantap,
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

    public function generateDetailsPdf(Request $request, $id) {
        $data = Jalan::find($id);
        $riwayat = Riwayat::where('jalan_id', '=', $id)->orderBy('tahun', 'desc')->get();
        $laporan = LaporanWarga::where('jalan_id', '=', $id)->get();

        $img_type = 'png';
        $image = base64_encode(file_get_contents('https://res.cloudinary.com/killtdj/image/upload/q_40/v1621363029/Lambang_Kabupaten_Banyuasin_frvjhm.png'));
        $img_src = "data:image/".$img_type.";base64,".str_replace ("\n", "", $image);

        $map_image = $request->input('mapimg');
        // dd($map_image);

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('pdf.jalan-details-pdf', compact('data', 'riwayat', 'laporan', 'img_src', 'map_image'))
            ->setPaper('a4', 'landscape');
        return $pdf->stream('Data Ruas Jalan Kabupaten Banyuasin.pdf');
    }

    public function export_excel(){
		return Excel::download(new JalanExport, 'Data Ruas Jalan Kabupaten Banyuasin.xlsx');
	}
}
