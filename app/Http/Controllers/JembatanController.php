<?php

namespace App\Http\Controllers;

use App\Kecamatan;
use App\LampiranJembatan;
use App\LaporanWarga;
use App\Riwayat;
use App\Jembatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class JembatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        if ($request->hasFile('geojson')) {
            $request->file('geojson')->move(public_path('peta/jembatan/'), $request->file('geojson')->getClientOriginalName());
        }

        $tambahJembatan = Jembatan::create([
            'nama_jembatan' => $request->nama_jembatan,
            'kecamatan_id' => $request->kecamatan_id,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'status_jembatan' => $request->status_jembatan,
            'kondisi_jembatan' => $request->kondisi_jembatan,
            'jenis_perkerasan' => $request->jenis_perkerasan,
            'kelas_jembatan' => $request->kelas_jembatan,
            'geojson' => 'peta/jembatan/' . $request->file('geojson')->getClientOriginalName(),
        ]);

        if($request->hasfile('images')) {
            foreach($request->file('images') as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path('foto/jembatan/'), $name);
                $dataimg[] = $name;
            }


            $upload_images = new LampiranJembatan();
            $upload_images->file_name = json_encode($dataimg);
            $upload_images->jembatan_id = $tambahJembatan['id'];
            $upload_images->is_video = ($request->url) ? true : false;
            $upload_images->url = ($request->url) ? json_encode($request->url) : '';
            $upload_images->save();
        }

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
        $lampiran = LampiranJembatan::where('jembatan_id', '=', $id)->get();
        // $laporan = LaporanWarga::where('jalan_id', '=', $id)->get();
        // $riwayat = Riwayat::where('jalan_id', '=', $id)->orderBy('tahun', 'desc')->get();
        return view('pages.jembatan.show', compact('data', 'kecamatan', 'lampiran'));
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


            $upload_images = LampiranJembatan::where('jembatan_id', $id)->update($update);
            $upload_images->file_name = json_encode($dataimg);
            $upload_images->is_video = ($request->url) ? true : false;
            $upload_images->url = ($request->url) ? json_encode($request->url) : '';
            $upload_images->save();
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
}
