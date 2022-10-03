<?php

namespace App\Http\Controllers;

use App\Jalan;
use App\Kecamatan;
use App\Lampiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapsController extends Controller
{
    public function index() {
        $data = Jalan::with('kecamatan')
            ->select('jalan.*', 'kecamatan.nama as kec_name',DB::raw("json_build_object(
                'type', 'FeatureCollection',
                'crs',  json_build_object(
                    'type',      'name', 
                    'properties', json_build_object(
                        'name', 'EPSG:4326'  
                    )
                ), 
                'features', json_agg(
                    json_build_object(
                        'type', 'Feature',
                        'id', jalan.id,
                        'geometry', ST_AsGeoJSON(GEOM)::json,
                        'properties', json_build_object(
                            'id', jalan.id,
                            'nama', jalan.nama_ruas
                        )
                    )
                )
            ) as feature_layer"))
            ->leftJoin('kecamatan', 'kecamatan.id', 'jalan.kecamatan_id')
            ->groupBy('jalan.id', 'kecamatan.nama')
            ->get();
        $kecamatan = Kecamatan::all();
        return view('pages.maps.index', compact('data', 'kecamatan'));
    }
}
