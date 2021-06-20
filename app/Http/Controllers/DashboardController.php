<?php

namespace App\Http\Controllers;

use App\Jalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        // Get Data Pekerasan Jalan
        $record = Jalan::select(DB::raw("COUNT(*) as count"), DB::raw("jenis_perkerasan as jenis_perkerasan"))
            ->groupBy('jenis_perkerasan')
            ->get();

        $data = [];
        foreach($record as $row) {
            $data['perkerasan'][] = ($row->jenis_perkerasan != null) ? ucfirst($row->jenis_perkerasan) : 'Belum Terklasifikasi';
            $data['jumlah'][] = (int) $row->count;
        }

        $data['chart_data'] = json_encode($data);

        // Get Data Status Jalan
        $recordStatus = Jalan::select(DB::raw("COUNT(*) as count"), DB::raw("status_jalan as status_jalan"))
            ->groupBy('status_jalan')
            ->get();

        $dataStatus = [];
        foreach($recordStatus as $rs) {
            $dataStatus['status'][] = ($rs->status_jalan != null) ? ucfirst($rs->status_jalan) : 'Belum Terklasifikasi';
            $dataStatus['jumlah'][] = (int) $rs->count;
        }

        $dataStatus['chart_dataStatus'] = json_encode($dataStatus);

        return view('pages.dashboard', $data, $dataStatus);
    }
}
