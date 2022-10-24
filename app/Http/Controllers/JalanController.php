<?php

namespace App\Http\Controllers;

use App\Exports\JalanExport;
use Illuminate\Http\Request;
use App\Jalan;
use App\Kecamatan;
use App\Lampiran;
use App\LaporanWarga;
use App\Riwayat;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Shapefile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;
use ZipArchive;

class JalanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $hasil = [];
            $jalan = Jalan::orderBy('id', 'ASC')->get();

            if($request->kecamatan != null){
                $jalan = $jalan->where('kecamatan_id', $request->kecamatan);
            }

            if($request->kelas_jalan != null){
                $jalan = $jalan->where('kelas_jalan', $request->kelas_jalan);
            }

            if($request->status_jalan != null){
                $jalan = $jalan->where('status_jalan', $request->status_jalan);
            }

            if($request->jenis_perkerasan != null){
                $jalan = $jalan->where('jenis_perkerasan', $request->jenis_perkerasan);
            }

            foreach($jalan as $data){
                $hasil[] = $data;
            }

            return Datatables::of($hasil)
                ->addIndexColumn()
                ->editColumn('nama_ruas', function($jalan) {
                    $ruas = "<strong><a class='text-success' href='jalan/details/$jalan->id'>$jalan->nama_ruas <i class='ik ik-arrow-up-right' title='Details'></i> <a></strong>";
                    return $ruas;
                })
                ->editColumn('status_jalan', function($jalan) {
                    if ($jalan->status_jalan == null) {
                        return "-";
                    } else {
                        return "Jalan " . ucfirst($jalan->status_jalan);
                    }
                })
                ->editColumn('panjang', function($jalan) {
                    return $jalan->panjang;
                })
                ->addColumn('kecamatan', function (Jalan $jalan) {
                    return $jalan->kecamatan->nama;
                })
                ->editColumn('jenis_perkerasan', function($jalan) {
                    if ($jalan->jenis_perkerasan == null) {
                        return "-";
                    } else {
                        return ucfirst($jalan->jenis_perkerasan);
                    }
                })
                ->addColumn('action', function($jalan){
                    if (Auth::guest() ) {
                        return '';
                    } else{
                        return "<div>
                                <form action='jalan/hapus/$jalan->id' id='delete$jalan->id' method='POST'>
                                    " . csrf_field() . "
                                    <input type='hidden' name='_method' value='delete'>
                                    <a class='btn btn-info btn-rounded' href='jalan/edit/$jalan->id'>Edit</a>
                                    <button type='submit' class='btn btn-danger btn-rounded delete-confirm' data-id='$jalan->id'>Del</button>
                                </form>
                            </div>";
                    }
                })
                ->rawColumns(['action', 'kondisi_jalan', 'nama_ruas'])
                ->make(true);
        }
        $kecamatan = Kecamatan::all();
        $jalan = Jalan::all();
        return view('pages.jalan.index', compact('jalan','kecamatan'));
    }

    public function create()
    {
        $kecamatan = Kecamatan::orderBy('nama')->get();
        return view('pages.jalan.create', compact('kecamatan'));
    }

    public function show($id)
    {
        $where = array('jalan.id' => $id);
        $data = DB::table('jalan')
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
            ->where($where)
            ->groupBy('jalan.id', 'kecamatan.nama', 'jalan.nama_ruas', 'jalan.kondisi_jalan','jalan.status_jalan','jalan.panjang','jalan.lebar','jalan.jenis_perkerasan','jalan.kelas_jalan','jalan.geojson','jalan.style','jalan.kecamatan_id','jalan.created_at','jalan.updated_at','jalan.th_data','jalan.mendukung','jalan.uraian_dukungan','jalan.titik_pengenal_awal','jalan.titik_pengenal_akhir','jalan.kode_patok','jalan.baik','jalan.sedang','jalan.rusak_ringan','jalan.rusak_berat','jalan.mantap','jalan.tidak_mantap','jalan.geom')
            ->first();

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
        $mapData = DB::table('jalan')
            ->select(DB::raw("json_build_object(
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
            ->where($where)
            ->first();
        $lampiran = Lampiran::where(['jalan_id' => $id])->first();
        return view('pages.jalan.edit', compact('data', 'kecamatan', 'lampiran', 'mapData'));
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
            'jenis_perkerasan' => $request->jenis_perkerasan,
            'kelas_jalan' => $request->kelas_jalan,
            'th_data' => $request->th_data,
            'mendukung' => $request->mendukung,
            'uraian_dukungan' => $request->uraian_dukungan,
            'titik_pengenal_awal' => $request->titik_pengenal_awal,
            'titik_pengenal_akhir' => $request->titik_pengenal_akhir,
            'kode_patok' => $request->kode_patok,
            'baik' => $request->baik,
            'sedang' => $request->sedang,
            'rusak_ringan' => $request->rusak_ringan,
            'rusak_berat' => $request->rusak_berat,
        ];

        if ($request->hasFile('geojson')) {
            $request->file('geojson')->move(public_path('peta/jalan/'), $request->file('geojson')->getClientOriginalName());
            $update['geojson'] = 'peta/jalan/' . $request->file('geojson')->getClientOriginalName();
        }

        if($request->hasfile('images')) {
            foreach($request->file('images') as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path('foto/jalan/'), $name);
                $dataimg[] = $name;
            }

            $update_lampiran['file_name'] = json_encode($dataimg);
            $update_lampiran['is_video'] = ($request->url) ? true : false;
            $update_lampiran['url'] = ($request->url) ? json_encode($request->url) : '';

            $getLampiranImages = Lampiran::where('jalan_id', $id)->where('is_video', false)->first();
            $getLampiranVideo = Lampiran::where('jalan_id', $id)->where('is_video', true)->first();
            // dd($getLampiranVideo);
            if ($getLampiranImages == null) {
                $createLampiran= Lampiran::create([
                    'jalan_id' => $id,
                    'file_name' => json_encode($dataimg),
                    'is_video' => false,
                    'url' => '',
                ]);

                $createLampiran->save();
            }

            if ($getLampiranVideo == null) {
                $createLampiran= Lampiran::create([
                    'jalan_id' => $id,
                    'file_name' => '',
                    'is_video' => true,
                    'url' => ($request->url) ? json_encode($request->url) : '',
                ]); 
                // dd($createLampiran);
            }
            $upload_images = Lampiran::where('jalan_id', $id)->update($update_lampiran);

        }

        $convertToGeom = [];
        if ($request->hasFile('shp')) {
            $file = $request->file('shp');
            $originalName = $file->getClientOriginalName();
            $zip = new ZipArchive();
            $status = $zip->open($request->file("shp")->getRealPath());
            if ($status) {
                $storageDestinationPath= public_path("tmp/peta/unzip/".uniqid()."_".$originalName."/");
                if (!File::exists( $storageDestinationPath)) {
                    File::makeDirectory($storageDestinationPath, 0755, true);
                }
                $zip->extractTo($storageDestinationPath);
                $getShpFile = File::glob($storageDestinationPath."*.shp");
                $Shapefile = new ShapefileReader($getShpFile[0]);

                while ($Geometry = $Shapefile->fetchRecord()) {
                    $getGeojson = $Geometry->getGeoJSON();
                    $toGeom = DB::raw("ST_GeomFromGeoJSON('$getGeojson')");
                    array_push($convertToGeom, $toGeom);
                }

                $update['geom'] = $toGeom ;

            }
            $request->file('shp')->move(public_path('peta/jalan/'), uniqid()."_".$originalName);

        }

        $update['nama_ruas'] = $request->get('nama_ruas');
        $update['kecamatan_id'] = $request->get('kecamatan_id');
        $update['panjang'] = $request->get('panjang');
        $update['lebar'] = $request->get('lebar');
        $update['status_jalan'] = $request->get('status_jalan');
        $update['jenis_perkerasan'] = $request->get('jenis_perkerasan');
        $update['kelas_jalan'] = $request->get('kelas_jalan');
        $update['th_data'] = $request->get('th_data');
        $update['mendukung'] = $request->get('mendukung');
        $update['uraian_dukungan'] = $request->get('uraian_dukungan');
        $update['titik_pengenal_awal'] = $request->get('titik_pengenal_awal');
        $update['titik_pengenal_akhir'] = $request->get('titik_pengenal_akhir');
        $update['kode_patok'] = $request->get('kode_patok');
        $update['baik'] = $request->get('baik');
        $update['sedang'] = $request->get('sedang');
        $update['rusak_ringan'] = $request->get('rusak_ringan');
        $update['rusak_berat'] = $request->get('rusak_berat');

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

        $tambahJalan = new Jalan();
        $tambahJalan->nama_ruas = $request['nama_ruas'];
        $tambahJalan->kecamatan_id = $request['kecamatan_id'];
        $tambahJalan->panjang = $request['panjang'];
        $tambahJalan->lebar = $request['lebar'];
        $tambahJalan->status_jalan = $request['status_jalan'];
        $tambahJalan->jenis_perkerasan = $request['jenis_perkerasan'];
        $tambahJalan->kelas_jalan = $request['kelas_jalan'];
        $tambahJalan->th_data = $request['th_data'];
        $tambahJalan->mendukung = $request['mendukung'];
        $tambahJalan->uraian_dukungan = $request['uraian_dukungan'];
        $tambahJalan->titik_pengenal_awal = $request['titik_pengenal_awal'];
        $tambahJalan->titik_pengenal_akhir = $request['titik_pengenal_akhir'];
        $tambahJalan->kode_patok = $request['kode_patok'];
        $tambahJalan->baik = $request['baik'];
        $tambahJalan->sedang = $request['sedang'];
        $tambahJalan->rusak_ringan = $request['rusak_ringan'];
        $tambahJalan->rusak_berat = $request['rusak_berat'];
        $tambahJalan->mantap = $request['mantap'];
        $tambahJalan->tidak_mantap = $request['tidak_mantap'];

        if ($request->hasFile('geojson')) {
            $request->file('geojson')->move(public_path('peta/jalan/'), $request->file('geojson')->getClientOriginalName());
        }

        $convertToGeom = [];
        if ($request->hasFile('shp')) {
            $file = $request->file('shp');
            $originalName = $file->getClientOriginalName();
            $zip = new ZipArchive();
            $status = $zip->open($request->file("shp")->getRealPath());
            if ($status) {
                $storageDestinationPath= public_path("tmp/peta/unzip/".uniqid()."_".$originalName."/");
                if (!File::exists( $storageDestinationPath)) {
                    File::makeDirectory($storageDestinationPath, 0755, true);
                }
                $zip->extractTo($storageDestinationPath);
                $getShpFile = File::glob($storageDestinationPath."*.shp");
                $Shapefile = new ShapefileReader($getShpFile[0]);

                while ($Geometry = $Shapefile->fetchRecord()) {
                    $getGeojson = $Geometry->getGeoJSON();
                    $toGeom = DB::raw("ST_GeomFromGeoJSON('$getGeojson')");
                    array_push($convertToGeom, $toGeom);
                    $tambahJalan->geom = $toGeom;
                }
            }

        }

        $tambahJalan->save();

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

    public function generatePdf() {
        $jalan = Jalan::orderBy('id', 'ASC')->get();

        $img_type = 'png';
        $image = base64_encode(file_get_contents('https://res.cloudinary.com/killtdj/image/upload/q_40/v1621363029/Lambang_Kabupaten_Banyuasin_frvjhm.png'));
        $img_src = "data:image/".$img_type.";base64,".str_replace ("\n", "", $image);

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('pdf.jalan-pdf', compact('jalan', 'img_src'))
            ->setPaper('a4', 'landscape');
        return $pdf->stream('Data Ruas Jalan Kabupaten Banyuasin.pdf');
    }

    public function generateDetailsPdf(Request $request, $id) {
        $data = Jalan::find($id);
        $riwayat = Riwayat::where('jalan_id', '=', $id)->orderBy('tahun', 'desc')->get();
        $laporan = LaporanWarga::where('jalan_id', '=', $id)->get();

        $img_type = 'png';
        $image = base64_encode(file_get_contents('https://res.cloudinary.com/killtdj/image/upload/q_40/v1621363029/Lambang_Kabupaten_Banyuasin_frvjhm.png'));
        $img_src = "data:image/".$img_type.";base64,".str_replace ("\n", "", $image);

        $map_image = $request->input('mapimg');
        // dd($map_image);

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('pdf.jalan-details-pdf', compact('data', 'riwayat', 'laporan', 'img_src', 'map_image'))
            ->setPaper('a4', 'landscape');
        return $pdf->stream('Data Ruas Jalan Kabupaten Banyuasin.pdf');
    }

    public function export_excel(){
		return Excel::download(new JalanExport, 'Data Ruas Jalan Kabupaten Banyuasin.xlsx');
	}
}
