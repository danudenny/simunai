<?php

namespace App\Http\Controllers;

use App\PageVisitor;
use App\User;
use App\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index(Request $request) {
        $visitorsToday = PageVisitor::count();
        $visitorsTotal = PageVisitor::whereDate('visited_at', today())->count();

        return view('pages.main', compact('visitorsToday', 'visitorsTotal'));
    }
}