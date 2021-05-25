<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\JalanController;
use App\Http\Controllers\KontraktorController;
use App\Http\Controllers\LaporanKontroller;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\RiwayatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('register', [RegisterController::class,'register']);

Route::get('password/forget',  function () {
	return view('pages.forgot-password');
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');

// Maps
Route::get('/', [MapsController::class,'index'])->name('dashboard');
Route::get('/maps', [MapsController::class,'index'])->name('maps');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Jalan
Route::get('/jalan', [JalanController::class,'index'])->name('jalan');
Route::get('/jalan/tambah', [JalanController::class,'create'])->name('jalan.tambah');
Route::get('/jalan/edit/{id}', [JalanController::class,'edit'])->name('jalan.edit');
Route::get('/jalan/details/{id}', [JalanController::class,'show'])->name('jalan.details');
Route::patch('/jalan/update/{id}', [JalanController::class,'update'])->name('jalan.update');
Route::post('/jalan/store', [JalanController::class,'store'])->name('jalan.store');
Route::delete('/jalan/hapus/{id}', [JalanController::class,'destroy'])->name('jalan.hapus');

// Kontraktor
Route::get('/kontraktor', [KontraktorController::class,'index'])->name('kontraktor');
Route::get('/kontraktor/tambah', [KontraktorController::class,'create'])->name('kontraktor.tambah');
Route::get('/kontraktor/edit/{id}', [KontraktorController::class,'edit'])->name('kontraktor.edit');
Route::get('/kontraktor/details/{id}', [KontraktorController::class,'show'])->name('kontraktor.details');
Route::patch('/kontraktor/update/{id}', [KontraktorController::class,'update'])->name('kontraktor.update');
Route::post('/kontraktor/store', [KontraktorController::class,'store'])->name('kontraktor.store');
Route::delete('/kontraktor/hapus/{id}', [KontraktorController::class,'destroy'])->name('kontraktor.hapus');

// Riwayat
Route::get('/riwayat', [RiwayatController::class,'index'])->name('riwayat');
Route::get('/riwayat/tambah/{id}', [RiwayatController::class,'create'])->name('riwayat.tambah');
Route::get('/riwayat/edit/{id}', [RiwayatController::class,'edit'])->name('riwayat.edit');
Route::get('/riwayat/details/{id}', [RiwayatController::class,'show'])->name('riwayat.details');
Route::patch('/riwayat/update/{id}', [RiwayatController::class,'update'])->name('riwayat.update');
Route::post('/riwayat/store', [RiwayatController::class,'store'])->name('riwayat.store');
Route::delete('/riwayat/hapus/{id}', [RiwayatController::class,'destroy'])->name('riwayat.hapus');

// Laporan
Route::get('/laporan', [LaporanKontroller::class,'index'])->name('laporan');
Route::get('/laporan/tambah/{id}', [LaporanKontroller::class,'create'])->name('laporan.tambah');
Route::get('/laporan/edit/{id}', [LaporanKontroller::class,'edit'])->name('laporan.edit');
Route::get('/laporan/details/{id}', [LaporanKontroller::class,'show'])->name('laporan.details');
Route::patch('/laporan/update/{id}', [LaporanKontroller::class,'update'])->name('laporan.update');
Route::post('/laporan/store', [LaporanKontroller::class,'store'])->name('laporan.store');
Route::delete('/laporan/hapus/{id}', [LaporanKontroller::class,'destroy'])->name('laporan.hapus');

Route::group(['middleware' => 'auth'], function(){
	// logout route
	Route::get('/logout', [LoginController::class,'logout']);
	Route::get('/clear-cache', [HomeController::class,'clearCache']);

	// dashboard route
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route::get('/', function () {
	// 	return view('pages.dashboard');
	// })->name('dashboard');

    // Jalan
    // Route::get('/jalan', [JalanController::class,'index'])->name('jalan');
    // Route::get('/jalan/tambah', [JalanController::class,'create'])->name('jalan.tambah');
    // Route::get('/jalan/edit/{id}', [JalanController::class,'edit'])->name('jalan.edit');
    // Route::get('/jalan/details/{id}', [JalanController::class,'show'])->name('jalan.details');
    // Route::patch('/jalan/update/{id}', [JalanController::class,'update'])->name('jalan.update');
    // Route::post('/jalan/store', [JalanController::class,'store'])->name('jalan.store');
    // Route::delete('/jalan/hapus/{id}', [JalanController::class,'destroy'])->name('jalan.hapus');

    // // Kontraktor
    // Route::get('/kontraktor', [KontraktorController::class,'index'])->name('kontraktor');
    // Route::get('/kontraktor/tambah', [KontraktorController::class,'create'])->name('kontraktor.tambah');
    // Route::get('/kontraktor/edit/{id}', [KontraktorController::class,'edit'])->name('kontraktor.edit');
    // Route::get('/kontraktor/details/{id}', [KontraktorController::class,'show'])->name('kontraktor.details');
    // Route::patch('/kontraktor/update/{id}', [KontraktorController::class,'update'])->name('kontraktor.update');
    // Route::post('/kontraktor/store', [KontraktorController::class,'store'])->name('kontraktor.store');
    // Route::delete('/kontraktor/hapus/{id}', [KontraktorController::class,'destroy'])->name('kontraktor.hapus');

    // // Riwayat
    // Route::get('/riwayat', [RiwayatController::class,'index'])->name('riwayat');
    // Route::get('/riwayat/tambah/{id}', [RiwayatController::class,'create'])->name('riwayat.tambah');
    // Route::get('/riwayat/edit/{id}', [RiwayatController::class,'edit'])->name('riwayat.edit');
    // Route::get('/riwayat/details/{id}', [RiwayatController::class,'show'])->name('riwayat.details');
    // Route::patch('/riwayat/update/{id}', [RiwayatController::class,'update'])->name('riwayat.update');
    // Route::post('/riwayat/store', [RiwayatController::class,'store'])->name('riwayat.store');
    // Route::delete('/riwayat/hapus/{id}', [RiwayatController::class,'destroy'])->name('riwayat.hapus');

    //

	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user'], function(){
	Route::get('/users', [UserController::class,'index']);
	Route::get('/user/get-list', [UserController::class,'getUserList']);
		Route::get('/user/create', [UserController::class,'create']);
		Route::post('/user/create', [UserController::class,'store'])->name('create-user');
		Route::get('/user/{id}', [UserController::class,'edit']);
		Route::post('/user/update', [UserController::class,'update']);
		Route::get('/user/delete/{id}', [UserController::class,'delete']);
	});

	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'index']);
		Route::get('/role/get-list', [RolesController::class,'getRoleList']);
		Route::post('/role/create', [RolesController::class,'create']);
		Route::get('/role/edit/{id}', [RolesController::class,'edit']);
		Route::post('/role/update', [RolesController::class,'update']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	});


	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permission', [PermissionController::class,'index']);
		Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
		Route::post('/permission/create', [PermissionController::class,'create']);
		Route::get('/permission/update', [PermissionController::class,'update']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	// get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);


	// permission examples
    Route::get('/permission-example', function () {
    	return view('permission-example');
    });
    // API Documentation
    Route::get('/rest-api', function () { return view('api'); });
    // Editable Datatable
	Route::get('/table-datatable-edit', function () {
		return view('pages.datatable-editable');
	});

    // Themekit demo pages
	Route::get('/calendar', function () { return view('pages.calendar'); });
	Route::get('/charts-amcharts', function () { return view('pages.charts-amcharts'); });
	Route::get('/charts-chartist', function () { return view('pages.charts-chartist'); });
	Route::get('/charts-flot', function () { return view('pages.charts-flot'); });
	Route::get('/charts-knob', function () { return view('pages.charts-knob'); });
	Route::get('/forgot-password', function () { return view('pages.forgot-password'); });
	Route::get('/form-addon', function () { return view('pages.form-addon'); });
	Route::get('/form-advance', function () { return view('pages.form-advance'); });
	Route::get('/form-components', function () { return view('pages.form-components'); });
	Route::get('/form-picker', function () { return view('pages.form-picker'); });
	Route::get('/invoice', function () { return view('pages.invoice'); });
	Route::get('/layout-edit-item', function () { return view('pages.layout-edit-item'); });
	Route::get('/layouts', function () { return view('pages.layouts'); });

	Route::get('/navbar', function () { return view('pages.navbar'); });
	Route::get('/profile', function () { return view('pages.profile'); });
	Route::get('/project', function () { return view('pages.project'); });
	Route::get('/view', function () { return view('pages.view'); });

	Route::get('/table-bootstrap', function () { return view('pages.table-bootstrap'); });
	Route::get('/table-datatable', function () { return view('pages.table-datatable'); });
	Route::get('/taskboard', function () { return view('pages.taskboard'); });
	Route::get('/widget-chart', function () { return view('pages.widget-chart'); });
	Route::get('/widget-data', function () { return view('pages.widget-data'); });
	Route::get('/widget-statistic', function () { return view('pages.widget-statistic'); });
	Route::get('/widgets', function () { return view('pages.widgets'); });

	// themekit ui pages
	Route::get('/alerts', function () { return view('pages.ui.alerts'); });
	Route::get('/badges', function () { return view('pages.ui.badges'); });
	Route::get('/buttons', function () { return view('pages.ui.buttons'); });
	Route::get('/cards', function () { return view('pages.ui.cards'); });
	Route::get('/carousel', function () { return view('pages.ui.carousel'); });
	Route::get('/icons', function () { return view('pages.ui.icons'); });
	Route::get('/modals', function () { return view('pages.ui.modals'); });
	Route::get('/navigation', function () { return view('pages.ui.navigation'); });
	Route::get('/notifications', function () { return view('pages.ui.notifications'); });
	Route::get('/range-slider', function () { return view('pages.ui.range-slider'); });
	Route::get('/rating', function () { return view('pages.ui.rating'); });
	Route::get('/session-timeout', function () { return view('pages.ui.session-timeout'); });
	Route::get('/pricing', function () { return view('pages.pricing'); });
});


Route::get('/register', function () { return view('pages.register'); });
Route::get('/login-1', function () { return view('pages.login'); });
