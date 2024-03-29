<?php

use App\Http\Controllers\FaskesController;
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
use App\Http\Controllers\JembatanController;
use App\Http\Controllers\KontraktorController;
use App\Http\Controllers\LaporanKontroller;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\MainController;

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
Route::get('/clear-cache', [HomeController::class,'clearCache']);
Route::get('password/forget',  function () {
	return view('pages.forgot-password');
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');

// Maps
Route::get('/', [MainController::class,'index'])->middleware('log.page.visit')->name('main');
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
Route::get('/jalan/pdf', [JalanController::class, 'generatePdf'])->name('jalan.pdf');
Route::post('/jalan/pdf/{id}', [JalanController::class, 'generateDetailsPdf'])->name('jalan.details-pdf');
Route::get('/jalan/excel', [JalanController::class, 'export_excel'])->name('jalan.excel');

// Jembatan
Route::get('/jembatan', [JembatanController::class,'index'])->name('jembatan');
Route::get('/jembatan/kecamatan/{id}', [JembatanController::class,'getKecamatanById'])->name('jembatan.kecamatan');
Route::get('/jembatan/tambah', [JembatanController::class,'create'])->name('jembatan.tambah');
Route::get('/jembatan/edit/{id}', [JembatanController::class,'edit'])->name('jembatan.edit');
Route::get('/jembatan/details/{id}', [JembatanController::class,'show'])->name('jembatan.details');
Route::patch('/jembatan/update/{id}', [JembatanController::class,'update'])->name('jembatan.update');
Route::post('/jembatan/store', [JembatanController::class,'store'])->name('jembatan.store');
Route::delete('/jembatan/hapus/{id}', [JembatanController::class,'destroy'])->name('jembatan.hapus');
Route::get('/jembatan/pdf', [JembatanController::class, 'generatePdf'])->name('jembatan.pdf');
Route::get('/jembatan/excel', [JembatanController::class, 'export_excel'])->name('jembatan.excel');

Route::get('/faskes', [FaskesController::class,'index'])->name('faskes');
Route::get('/faskes/kecamatan/{id}', [FaskesController::class,'getKecamatanById'])->name('faskes.kecamatan');
Route::get('/faskes/tambah', [FaskesController::class,'create'])->name('faskes.tambah');
Route::get('/faskes/edit/{id}', [FaskesController::class,'edit'])->name('faskes.edit');
Route::get('/faskes/details/{id}', [FaskesController::class,'show'])->name('faskes.details');
Route::patch('/faskes/update/{id}', [FaskesController::class,'update'])->name('faskes.update');
Route::post('/faskes/store', [FaskesController::class,'store'])->name('faskes.store');
Route::delete('/faskes/hapus/{id}', [FaskesController::class,'destroy'])->name('faskes.hapus');
Route::get('/faskes/pdf', [FaskesController::class, 'generatePdf'])->name('faskes.pdf');
Route::get('/faskes/excel', [FaskesController::class, 'export_excel'])->name('faskes.excel');

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
Route::post('/laporan/store_landing', [LaporanKontroller::class,'store_landing'])->name('laporan.store.landing');
Route::delete('/laporan/hapus/{id}', [LaporanKontroller::class,'destroy'])->name('laporan.hapus');

Route::group(['middleware' => 'auth'], function(){
	// logout route
	Route::get('/logout', [LoginController::class,'logout']);

	// dashboard route
	// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
    Route::get('/users', [UserController::class,'index']);
    Route::get('/user/get-list', [UserController::class,'getUserList']);
    Route::get('/user/create', [UserController::class,'create']);
    Route::post('/user/create', [UserController::class,'store'])->name('create-user');
    Route::get('/user/{id}', [UserController::class,'edit']);
    Route::post('/user/update', [UserController::class,'update']);
    Route::get('/user/delete/{id}', [UserController::class,'delete']);
	Route::group(['middleware' => 'can:manage_user'], function(){
	});

	//only those have manage_role permission will get access
    Route::get('/roles', [RolesController::class,'index']);
    Route::get('/role/get-list', [RolesController::class,'getRoleList']);
    Route::post('/role/create', [RolesController::class,'create']);
    Route::get('/role/edit/{id}', [RolesController::class,'edit']);
    Route::post('/role/update', [RolesController::class,'update']);
    Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
	});


	//only those have manage_permission permission will get access
    Route::get('/permission', [PermissionController::class,'index']);
    Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
    Route::post('/permission/create', [PermissionController::class,'create']);
    Route::get('/permission/update', [PermissionController::class,'update']);
    Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
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
