<?php

namespace App\Http\Controllers;

use App\Jalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request) {

        // Get Data Pekerasan Jalan
        $baik = Jalan::select(DB::raw("SUM(baik) as baik"))->get();
        $sedang = Jalan::select(DB::raw("SUM(sedang) as sedang"))->get();
        $rusak_ringan = Jalan::select(DB::raw("SUM(rusak_ringan) as rusak_ringan"))->get();
        $rusak_berat = Jalan::select(DB::raw("SUM(rusak_berat) as rusak_berat"))->get();
        $mantap = Jalan::select(DB::raw("SUM(mantap) as mantap"))->get();
        $tidak_mantap = Jalan::select(DB::raw("SUM(tidak_mantap) as tidak_mantap"))->get();

        $record = Jalan::select(DB::raw("COUNT(*) as count"), DB::raw("jenis_perkerasan as jenis_perkerasan"))
            ->groupBy('jenis_perkerasan')
            ->get();

        $data = [];
        foreach($record as $row) {
            $data['perkerasan'][] = ($row->jenis_perkerasan != null) ? ucfirst($row->jenis_perkerasan) : 'Belum Terklasifikasi';
            $data['jumlah'][] = (int) $row->count;
        }

        // Get Data Status Jalan
        $recordStatus = Jalan::select(DB::raw("COUNT(*) as count"), DB::raw("status_jalan as status_jalan"))
            ->groupBy('status_jalan')
            ->get();

        $dataStatus = [];
        foreach($recordStatus as $rs) {
            $dataStatus['status'][] = ($rs->status_jalan != null) ? ucfirst($rs->status_jalan) : 'Belum Terklasifikasi';
            $dataStatus['jumlah'][] = (int) $rs->count;
        }

        // Get Data Jalan By Kecamatan
        $dataPanjangPerKecamatan = [];
        $recordKec = Jalan::select(DB::raw("SUM(panjang) as panjang"), 'jalan.kecamatan_id')->with('kecamatan')
            ->when($request->has('kecamatan_id'), function($query) use ($request) {
                $query->where('kecamatan_id', $request->kecamatan_id);
            })
            ->groupBy('jalan.kecamatan_id')
            ->orderBy('panjang')
            ->get();
        
        foreach($recordKec as $rk) {
            $dataPanjangPerKecamatan['kecamatan'][] = $rk->kecamatan->nama;
            $dataPanjangPerKecamatan['panjang'][] = sprintf("%.2f", $rk->panjang);
        }

        // dd($dataPanjangPerKecamatan['panjang']);

        return view('pages.dashboard')
            ->with('data',json_encode($data,JSON_NUMERIC_CHECK))
            ->with('dataStatus',json_encode($dataStatus,JSON_NUMERIC_CHECK))
            ->with('baik', $baik)
            ->with('sedang', $sedang)
            ->with('rusak_ringan', $rusak_ringan)
            ->with('rusak_berat', $rusak_berat)
            ->with('mantap', $mantap)
            ->with('tidak_mantap', $tidak_mantap)
            ->with('panjang', $dataPanjangPerKecamatan['panjang'])
            ->with('kecamatan', $dataPanjangPerKecamatan['kecamatan']);
    }
}
