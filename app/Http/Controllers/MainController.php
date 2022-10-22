<?php

namespace App\Http\Controllers;

use App\User;
use App\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index(Request $request) {
        $visitorsTotal = Visitor::count();
        $visitorsToday = Visitor::select('date', DB::raw('count(*) as total'))->where('date', '>', today()->subMonth())->groupBy('date')->get();

        return view('pages.main', compact('visitorsToday', 'visitorsTotal'));
    }
}