<?php

namespace App\Http\Controllers;

use App\Kontraktor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class KontraktorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kontraktor = Kontraktor::all();
        return view('pages.kontraktor.index', compact('kontraktor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.kontraktor.create');
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
            'nama' => 'required',
            'telepon' => 'required|numeric',
            'email' => 'required',
            'alamat' => 'required',
        ]);

        $tambahKontraktor = Kontraktor::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'is_active' => $request->is_active,
        ]);

        $notification = array(
            'message' => 'Sukses Menambah Data Kontraktor!',
            'alert-type' => 'success'
        );
        return Redirect::to('kontraktor')
            ->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $where = array('id' => $id);
        $data = Kontraktor::where($where)->first();
        return view('pages.kontraktor.show', compact('data'));
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
        $data = Kontraktor::where($where)->first();
        return view('pages.kontraktor.edit', compact('data'));
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
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required|numeric',
            'email' => 'required',
        ]);
        $update = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'is_active' => $request->is_active,
        ];

        $update['nama'] = $request->get('nama');
        $update['alamat'] = $request->get('alamat');
        $update['telepon'] = $request->get('telepon');
        $update['email'] = $request->get('email');
        $update['is_active'] = $request->get('is_active');

        $notification = array(
            'message' => 'Sukses Memperbarui Data Kontraktor!',
            'alert-type' => 'success'
        );

        Kontraktor::where('id', $id)->update($update);
        return Redirect::to('kontraktor')
            ->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kontraktor::find($id)->delete();
        $notification = array(
            'message' => 'Sukses Menghapus Data Kontraktor!',
            'alert-type' => 'success'
        );
        return Redirect::back()->with($notification);
    }
}
