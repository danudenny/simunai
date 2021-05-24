<?php

namespace App\Http\Controllers;

use App\Jalan;
use App\Kontraktor;
use App\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $riwayat = Riwayat::all();
        return view('pages.riwayat.create', compact('riwayat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data = Jalan::find($id);
        $kontraktor = Kontraktor::orderBy('nama')->get();
        return view('pages.riwayat.create', compact('data', 'kontraktor'));
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
            'tahun' => 'required',
            'kontraktor_id' => 'required',
            'kegiatan' => 'required',
            'nilai' => 'required|numeric',
            'sumber_dana' => 'required',
            'status' => 'required'
        ]);

        $tambahRiwayat = Riwayat::create([
            'tahun' => $request->tahun,
            'kontraktor_id' => $request->kontraktor_id,
            'kegiatan' => $request->kegiatan,
            'nilai' => $request->nilai,
            'sumber_dana' => $request->sumber_dana,
            'jalan_id' => $request->input('jalan_id'),
            'status' => $request->status,
        ]);

        $notification = array(
            'message' => 'Sukses Menambah Data Riwayat!',
            'alert-type' => 'success'
        );
        return redirect()->route('jalan.details', $request->input('jalan_id'))->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $data = Riwayat::where($where)->first();
        $jalan = Jalan::where('id', '=' , $data->jalan_id)->first();
        $kontraktor = Kontraktor::orderBy('nama')->get();
        return view('pages.riwayat.edit', compact('data', 'kontraktor', 'jalan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required',
            'kontraktor_id' => 'required',
            'kegiatan' => 'required',
            'nilai' => 'required|numeric',
            'sumber_dana' => 'required',
            'status' => 'required'
        ]);

        $update = [
            'tahun' => $request->tahun,
            'kontraktor_id' => $request->kontraktor_id,
            'kegiatan' => $request->kegiatan,
            'nilai' => $request->nilai,
            'sumber_dana' => $request->sumber_dana,
            'jalan_id' => $request->input('jalan_id'),
            'status' => $request->status,
        ];

        $update['tahun'] = $request->get('tahun');
        $update['kontraktor_id'] = $request->get('kontraktor_id');
        $update['kegiatan'] = $request->get('kegiatan');
        $update['nilai'] = $request->get('nilai');
        $update['sumber_dana'] = $request->get('sumber_dana');
        $update['jalan_id'] = $request->input('jalan_id');
        $update['status'] = $request->get('status');

        $notification = array(
            'message' => 'Sukses Memperbarui Data Riwayat!',
            'alert-type' => 'success'
        );

        Riwayat::where('id', $id)->update($update);
        return redirect()->route('jalan.details', $request->input('jalan_id'))->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Riwayat::find($id)->delete();
        $notification = array(
            'message' => 'Sukses Menghapus Data Riwayat!',
            'alert-type' => 'success'
        );
        return Redirect::back()->with($notification);
    }
}
