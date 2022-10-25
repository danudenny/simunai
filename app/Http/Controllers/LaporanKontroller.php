<?php

namespace App\Http\Controllers;

use App\Http\Requests\JalanRequest;
use App\Jalan;
use App\LaporanWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LaporanKontroller extends Controller
{
    public function index() {
        $laporan = LaporanWarga::all();
        return view('pages.laporan.index', compact('laporan'));
    }

    public function create($id) {
        $data = Jalan::find($id);
        return view('pages.laporan.create', compact('data'));
    }

    public function show($id) {
        $data = LaporanWarga::find($id);
        return view('pages.laporan.show', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'phone' => 'required|numeric',
            'subject' => 'string',
            'description' => 'required',
            'foto' => 'required',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000'
        ]);

        if ($request->hasFile('foto')) {
            $request->file('foto')->move(public_path('foto/laporan/'), $request->file('foto')->getClientOriginalName());
        }

        $tambahLaporan = LaporanWarga::create([
            'nama' => $request->nama,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'description' => $request->description,
            'jalan_id' => $request->input('jalan_id') ? $request->input('jalan_id') : null,
            'foto' => 'foto/laporan/' . $request->file('foto')->getClientOriginalName(),
        ]);

        $notification = array(
            'message' => 'Sukses Menambah Laporan!',
            'alert-type' => 'success'
        );
        return Redirect::to('jalan')
            ->with($notification);
    }

    public function store_landing(Request $request)
    {
        if ($request->hasFile('foto')) {
            $request->file('foto')->move(public_path('foto/laporan/'), $request->file('foto')->getClientOriginalName());
        }
            
        $tambahLaporan = new LaporanWarga();
        $tambahLaporan->nama = $request->nama;
        $tambahLaporan->phone = $request->phone;
        $tambahLaporan->subject = $request->subject;
        $tambahLaporan->description = $request->description;
        $tambahLaporan->jalan_id = null;
        $tambahLaporan->foto = 'foto/laporan/' . $request->file('foto')->getClientOriginalName();

        try {
            if ($tambahLaporan->save()) {
                $notification = array(
                    'message' => 'Sukses Menambah Laporan!',
                    'alert-type' => 'success'
                );
                return redirect()->back()
                    ->with($notification);
            }

        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
