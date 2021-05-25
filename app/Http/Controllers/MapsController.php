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
        return view('pages.maps.index', compact('data', 'kecamatan'));
    }
}
