<?php

namespace App\Http\Controllers;

use App\Jalan;
use App\Kecamatan;
use App\Lampiran;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function index() {
        $data = Jalan::all();
        $kecamatan = Kecamatan::all();
        foreach( $data as $datas) {
            $lampiran = Lampiran::where('jalan_id', '=', $datas->id)->get();
        };
        return view('pages.maps.index', compact('data', 'kecamatan', 'lampiran'));
    }
}
