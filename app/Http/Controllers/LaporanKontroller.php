<?php

namespace App\Http\Controllers;

use App\Jalan;
use App\LaporanWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LaporanKontroller extends Controller
{
    public function index() {
        return view('pages.laporan.index');
    }

    public function create($id) {
        $data = Jalan::find($id);
        return view('pages.laporan.create', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'description' => 'required',
            'foto' => 'required',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000'
        ]);

        if ($request->hasFile('foto')) {
            $request->file('foto')->move(public_path('foto/laporan/'), $request->file('foto')->getClientOriginalName());
        }

        $tambahLaporan = LaporanWarga::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->description,
            'jalan_id' => $request->input('jalan_id'),
            'foto' => 'foto/laporan/' . $request->file('foto')->getClientOriginalName(),
        ]);

        $notification = array(
            'message' => 'Sukses Menambah Laporan!',
            'alert-type' => 'success'
        );
        return Redirect::to('jalan')
            ->with($notification);
    }
}
