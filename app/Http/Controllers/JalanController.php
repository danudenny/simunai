<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jalan;
use App\Kecamatan;
use App\Lampiran;
use App\LaporanWarga;
use App\Riwayat;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class JalanController extends Controller
{
    public function index()
    {
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
}
