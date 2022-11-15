<?php

namespace App\Http\Controllers;

use App\Faskes;
use App\Kecamatan;
use App\Jalan;
use App\Jembatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Shapefile\ShapefileReader;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade as PDF;
use ZipArchive;

class FaskesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Faskes::orderBy('id', 'ASC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('nama_faskes', function($faskes) {
                    $faskes = "<strong><a class='text-success' href='faskes/details/$faskes->id'>$faskes->nama_faskes <i class='ik ik-arrow-up-right' title='Details'></i> <a></strong>";
                    return $faskes;
                })
                ->addColumn('kecamatan', function (Faskes $faskes) {
                    return $faskes->kecamatan->nama;
                })
                ->addColumn('status', function ($faskes) {
                    if ($faskes->status == 'memenuhi') {
                        $span = "<span class='badge badge-success'>Memenuhi</span>";
                    } elseif ($faskes->status == 'tidak_memenuhi') {
                        $span = "<span class='badge badge-warning'>Tidak Memenuhi</span>";
                    }
                    return $span;
                })
                ->addColumn('kemampuan_pelayanan', function ($faskes) {
                    if ($faskes->kemampuan_pelayanan == 'rawat_inap') {
                        $span = "<span class='badge badge-success'>Rawat Inap</span>";
                    } elseif ($faskes->kemampuan_pelayanan == 'non_rawat_inap') {
                        $span = "<span class='badge badge-info'>Non Rawat Inap</span>";
                    }
                    return $span;
                })
                ->addColumn('type', function ($faskes) {
                    if ($faskes->type == 'puskesmas') {
                        $span = "<span>Puskesmas</span>";
                    } elseif ($faskes->type == 'rumah_sakit') {
                        $span = "<span>Rumah Sakit</span>";
                    }
                    return $span;
                })
                ->addColumn('action', function($faskes){
                    if (Auth::guest() ) {
                        return '';
                    } else{
                        return "<div>
                                <form action='faskes/hapus/$faskes->id' id='delete$faskes->id' method='POST'>
                                    " . csrf_field() . "
                                    <input type='hidden' name='_method' value='delete'>
                                    <a class='btn btn-info btn-rounded' href='faskes/edit/$faskes->id'>Edit</a>
                                    <button type='submit' class='btn btn-danger btn-rounded delete-confirm' data-id='$faskes->id'>Hapus</button>
                                </form>
                            </div>";
                    }
                })
                ->rawColumns(['action', 'nama_faskes', 'status', 'kemampuan_pelayanan', 'type'])
                ->make(true);
        }
        $faskes = Faskes::all();
        return view('pages.faskes.index', compact('faskes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kecamatan = Kecamatan::orderBy('nama')->get();
        return view('pages.faskes.create', compact('kecamatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $request->validate([
//            'nama_faskes' => 'required',
//            'kecamatan_id' => 'required',
//            'alamat' => 'required',
//            'status' => 'required',
//            'kemampuan_pelayanan' => 'required',
//            'karakteristik_wilayah' => 'required',
//            'type' => 'required',
//            'dokter' => 'numeric',
//            'dokter_gigi' => 'numeric',
//            'perawat' => 'numeric',
//            'bidan' => 'numeric',
//            'kesehatan_masyarakat' => 'numeric',
//            'lingkungan_kesehatan' => 'numeric',
//            'farmasi' => 'numeric',
//            'gizi' => 'numeric',
//            'atlm' => 'numeric'
//        ]);

        if($request->hasfile('foto')) {
            foreach($request->file('foto') as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path('foto/faskes/'), $name);
                $dataimg[] = $name;
            }
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

            }

        }

        $tambahFaskes = Faskes::create([
            'nama_faskes' => $request->nama_faskes,
            'kecamatan_id' => $request->kecamatan_id,
            'alamat' => $request->alamat,
            'kode' => $request->kode,
            'status' => $request->status,
            'kemampuan_pelayanan' => $request->kemampuan_pelayanan,
            'karakteristik_wilayah' => $request->karakteristik_wilayah,
            'type' => $request->type,
            'dokter' => $request->dokter,
            'dokter_gigi' => $request->dokter_gigi,
            'perawat' => $request->perawat,
            'bidan' => $request->bidan,
            'kesehatan_masyarakat' => $request->kesehatan_masyarakat,
            'lingkungan_kesehatan' => $request->lingkungan_kesehatan,
            'farmasi' => $request->farmasi,
            'gizi' => $request->gizi,
            'atlm' => $request->atlm,
            'foto' => 'foto/faskes/' . ($request->foto) ? json_encode($request->foto) : '',
            'geom' => $convertToGeom[0]
        ]);



        $notification = array(
            'message' => 'Sukses Menambah Data Faskes!',
            'alert-type' => 'success'
        );
        return Redirect::to('faskes')->with($notification);
    }

    public function show($id)
    {
        $where = array('kesehatan.id' => $id);
        $data = DB::table('kesehatan')
            ->select('kesehatan.*', 'kecamatan.nama',DB::raw("json_build_object(
                'type', 'FeatureCollection',
                'crs',  json_build_object(
                    'type',
                    'name',
                    'properties', json_build_object(
                        'name', 'EPSG:4326'
                    )
                ),
                'features', json_agg(
                    json_build_object(
                        'type', 'Feature',
                        'id', kesehatan.id,
                        'geometry', ST_AsGeoJSON(GEOM)::json,
                        'properties', json_build_object(
                            'id', kesehatan.id,
                            'nama', kesehatan.nama_faskes
                        )
                    )
                )
            ) as feature_layer"))
            ->leftJoin('kecamatan', 'kecamatan.id', 'kesehatan.kecamatan_id')
            ->where($where)
            ->groupBy('kesehatan.id', 'kecamatan.nama')
            ->first();
        $kecamatan = Kecamatan::orderBy('nama')->get();

        return view('pages.faskes.show', compact('kecamatan', 'data'));
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $kecamatan = Kecamatan::orderBy('nama')->get();
        $data = Faskes::where($where)->first();
        return view('pages.faskes.edit', compact('data', 'kecamatan'));
    }

    public function update(Request $request, $id)
    {
        $update = [
            'nama_faskes' => $request->nama_faskes,
            'kecamatan_id' => $request->kecamatan_id,
            'alamat' => $request->alamat,
            'kode' => $request->kode,
            'status' => $request->status,
            'kemampuan_pelayanan' => $request->kemampuan_pelayanan,
            'karakteristik_wilayah' => $request->karakteristik_wilayah,
            'type' => $request->type,
            'dokter' => $request->dokter,
            'dokter_gigi' => $request->dokter_gigi,
            'perawat' => $request->perawat,
            'bidan' => $request->bidan,
            'kesehatan_masyarakat' => $request->kesehatan_masyarakat,
            'lingkungan_kesehatan' => $request->lingkungan_kesehatan,
            'farmasi' => $request->farmasi,
            'gizi' => $request->gizi,
            'atlm' => $request->atlm,
        ];

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
            $request->file('shp')->move(public_path('peta/faskes/'), uniqid()."_".$originalName);

        }

        $notification = array(
            'message' => 'Sukses Memperbarui Data Fasilitas Kesehatan!',
            'alert-type' => 'success'
        );

        Faskes::where('id', $id)->update($update);
        return Redirect::to('faskes')
            ->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jembatan  $jembatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Faskes::find($id)->delete();
        $notification = array(
            'message' => 'Sukses Menghapus Data Fasilitas Kesehatan!',
            'alert-type' => 'success'
        );
        return Redirect::back()->with($notification);
    }

    public function getKecamatanById($id) {
        $ruas_jalan = DB::table("jalan")->where("kecamatan_id",$id)->pluck("nama_ruas","id");
        return json_encode($ruas_jalan);
    }

    public function generatePdf() {
        $jembatan = Jembatan::orderBy('id', 'ASC')->get();
        // $jalan = Jalan::where('id', '=', $jembatan->id)->first();

        $img_type = 'png';
        $image = base64_encode(file_get_contents('https://res.cloudinary.com/killtdj/image/upload/q_40/v1621363029/Lambang_Kabupaten_Banyuasin_frvjhm.png'));
        $img_src = "data:image/".$img_type.";base64,".str_replace ("\n", "", $image);

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('pdf.jembatan-pdf', compact('jembatan', 'img_src'))
            ->setPaper('a4', 'landscape');
        return $pdf->stream('Data Jembatan Kabupaten Banyuasin.pdf');
    }
}
