<?php

namespace App\Http\Controllers;

use App\Jalan;
use App\Kecamatan;
use App\Lampiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapsController extends Controller
{
    public function index(Request $request) {
        $data = Jalan::with('kecamatan')
            ->when($request->has('kecamatan_id'), function($query) use ($request) {
                $query->where('kecamatan_id', '=', $request->kecamatan_id);
            })
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
                            'nama', jalan.nama_ruas,
                            'kecamatan_id', jalan.kecamatan_id
                        )
                    )
                )
            ) as feature_layer"))
            ->leftJoin('kecamatan', 'kecamatan.id', 'jalan.kecamatan_id')
            ->groupBy('jalan.id', 'kecamatan.nama', 'jalan.nama_ruas', 'jalan.kondisi_jalan','jalan.status_jalan','jalan.panjang','jalan.lebar','jalan.jenis_perkerasan','jalan.kelas_jalan','jalan.geojson','jalan.style','jalan.kecamatan_id','jalan.created_at','jalan.updated_at','jalan.th_data','jalan.mendukung','jalan.uraian_dukungan','jalan.titik_pengenal_awal','jalan.titik_pengenal_akhir','jalan.kode_patok','jalan.baik','jalan.sedang','jalan.rusak_ringan','jalan.rusak_berat','jalan.mantap','jalan.tidak_mantap','jalan.geom')
            ->get();
        $kecamatan = Kecamatan::all();
        return view('pages.maps.index', compact('data', 'kecamatan'));
    }
}
