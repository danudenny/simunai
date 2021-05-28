<?php

namespace App\Http\Controllers;

use App\Kecamatan;
use App\Jalan;
use App\LaporanWarga;
use App\Riwayat;
use App\Jembatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade as PDF;

class JembatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Jembatan::orderBy('id', 'ASC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('nama_jembatan', function($jembatan) {
                    $ruas = "<strong><a class='text-success' href='jembatan/details/$jembatan->id'>$jembatan->nama_jembatan <i class='ik ik-arrow-up-right' title='Details'></i> <a></strong>";
                    return $ruas;
                })
                ->editColumn('panjang', function($jembatan) {
                    return number_format($jembatan->panjang);
                })
                ->addColumn('kecamatan', function (Jembatan $jembatan) {
                    return $jembatan->kecamatan->nama;
                })
                ->addColumn('jalan', function (Jembatan $jembatan) {
                    $jalan = Jalan::where('id', '=', $jembatan->ruas_jalan_id)->get();
                    return $jalan[0]->nama_ruas;
                })
                ->addColumn('kondisi_jembatan', function ($jembatan) {
                    if ($jembatan->kondisi_jembatan == 'Baik') {
                        $span = "<span class='badge badge-success'>" . $jembatan->kondisi_jembatan . "</span>";
                    } elseif ($jembatan->kondisi_jembatan == 'Rusak Ringan') {
                        $span = "<span class='badge badge-primary'>" . $jembatan->kondisi_jembatan . "</span>";
                    } elseif($jembatan->kondisi_jembatan == 'Rusak Sedang') {
                        $span = "<span class='badge badge-info'>" . $jembatan->kondisi_jembatan . "</span>";
                    } elseif($jembatan->kondisi_jembatan == 'Rusak Berat') {
                        $span = "<span class='badge badge-warning'>" . $jembatan->kondisi_jembatan . "</span>";
                    } else {
                        $span = '-';
                    }
                    return $span;
                })
                ->addColumn('action', function($jembatan){
                    if (Auth::guest() ) {
                        return '';
                    } else{
                        return "<div>
                                <form action='jembatan/hapus/$jembatan->id' id='delete$jembatan->id' method='POST'>
                                    " . csrf_field() . "
                                    <input type='hidden' name='_method' value='delete'>
                                    <a class='btn btn-info btn-rounded' href='jembatan/edit/$jembatan->id'>Edit</a>
                                    <button type='submit' class='btn btn-danger btn-rounded delete-confirm' data-id='$jembatan->id'>Hapus</button>
                                </form>
                            </div>";
                    }
                })
                ->rawColumns(['action', 'kondisi_jembatan', 'nama_jembatan'])
                ->make(true);
        }
        $jembatan = Jembatan::all();
        return view('pages.jembatan.index', compact('jembatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kecamatan = Kecamatan::orderBy('nama')->get();
        return view('pages.jembatan.create', compact('kecamatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jembatan' => 'required',
            'kecamatan_id' => 'required',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric'
        ]);

        if($request->hasfile('images')) {
            foreach($request->file('images') as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path('foto/jembatan/'), $name);
                $dataimg[] = $name;
            }
        }

        $tambahJembatan = Jembatan::create([
            'nama_jembatan' => $request->nama_jembatan,
            'kecamatan_id' => $request->kecamatan_id,
            'ruas_jalan_id' => $request->ruas_jalan_id,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'elevasi' => $request->elevasi,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'tipe_lintasan' => $request->tipe_lintasan,
            'tipe_pondasi' => $request->tipe_pondasi,
            'kondisi_jembatan' => $request->kondisi_jembatan,
            'foto' => 'foto/jembatan/' . ($request->foto) ? json_encode($request->foto) : '',
            'video' => $request->video
        ]);



        $notification = array(
            'message' => 'Sukses Menambah Data Jembatan!',
            'alert-type' => 'success'
        );
        return Redirect::to('jembatan')
            ->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jembatan  $jembatan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $where = array('id' => $id);
        $data = Jembatan::where($where)->first();
        $kecamatan = Kecamatan::orderBy('nama')->get();
        $jalan = Jalan::where('id', '=', $data->ruas_jalan_id)->first();
        return view('pages.jembatan.show', compact('data', 'kecamatan', 'jalan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jembatan  $jembatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $kecamatan = Kecamatan::orderBy('nama')->get();
        $data = Jembatan::where($where)->first();
        return view('pages.jembatan.edit', compact('data', 'kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jembatan  $jembatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jembatan' => 'required',
            'kecamatan_id' => 'required',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
        ]);
        $update = [
            'nama_jembatan' => $request->nama_jembatan,
            'kecamatan_id' => $request->kecamatan_id,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'status_jembatan' => $request->status_jembatan,
            'kondisi_jembatan' => $request->kondisi_jembatan,
            'jenis_perkerasan' => $request->jenis_perkerasan,
            'kelas_jembatan' => $request->kelas_jembatan,
        ];

        if ($request->hasFile('geojson')) {
            $request->file('geojson')->move(public_path('peta/jembatan/'), $request->file('geojson')->getClientOriginalName());
            $update['geojson'] = 'peta/jembatan/' . $request->file('geojson')->getClientOriginalName();
        }

        $update['nama_jembatan'] = $request->get('nama_jembatan');
        $update['kecamatan_id'] = $request->get('kecamatan_id');
        $update['panjang'] = $request->get('panjang');
        $update['lebar'] = $request->get('lebar');
        $update['status_jembatan'] = $request->get('status_jembatan');
        $update['kondisi_jembatan'] = $request->get('kondisi_jembatan');
        $update['jenis_perkerasan'] = $request->get('jenis_perkerasan');
        $update['kelas_jembatan'] = $request->get('kelas_jembatan');

        if($request->hasfile('images')) {
            foreach($request->file('images') as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path('foto/jembatan/'), $name);
                $dataimg[] = $name;
            }
        }

        $notification = array(
            'message' => 'Sukses Memperbarui Data Jembatan!',
            'alert-type' => 'success'
        );

        Jembatan::where('id', $id)->update($update);
        return Redirect::to('jembatan')
            ->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jembatan  $jembatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Jembatan::find($id)->delete();
        $notification = array(
            'message' => 'Sukses Menghapus Data Jembatan!',
            'alert-type' => 'success'
        );
        return Redirect::back()->with($notification);
    }

    public function getKecamatanById($id) {
        $ruas_jalan = DB::table("jalan")->where("kecamatan_id",$id)->pluck("nama_ruas","id");
        return json_encode($ruas_jalan);
    }

    public function generatePdf() {
        $jembatan = Jembatan::orderBy('id', 'ASC')->get();
        // $jalan = Jalan::where('id', '=', $jembatan->id)->first();

        $img_type = 'png';
        $image = base64_encode(file_get_contents('https://res.cloudinary.com/killtdj/image/upload/q_40/v1621363029/Lambang_Kabupaten_Banyuasin_frvjhm.png'));
        $img_src = "data:image/".$img_type.";base64,".str_replace ("\n", "", $image);

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('pdf.jembatan-pdf', compact('jembatan', 'img_src'))
            ->setPaper('a4', 'landscape');
        return $pdf->stream('Data Jembatan Kabupaten Banyuasin.pdf');
    }
}
