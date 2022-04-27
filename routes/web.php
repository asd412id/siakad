<?php

use App\Http\Controllers\CommonController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StudyController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
	Route::get('/login', [CommonController::class, 'login'])->name('login');
	Route::post('/login', [CommonController::class, 'loginProcess'])->name('login.process');
});

Route::middleware('auth')->group(function () {
	Route::get('/', [CommonController::class, 'home'])->name('home');
	Route::get('/logout', [CommonController::class, 'logout'])->name('logout');
	Route::post('/logout', [CommonController::class, 'logoutProcess'])->name('logout.process');
	Route::get('/account', [CommonController::class, 'account'])->name('account');
	Route::post('/account', [CommonController::class, 'accountUpdate'])->name('account.update');

	Route::get('/search/prodi', [SearchController::class, 'prodi'])->name('prodi.search');
	Route::get('/search/makul', [SearchController::class, 'mataKuliah'])->name('makul.search');
	Route::get('/search/dosen', [SearchController::class, 'dosen'])->name('dosen.search');

	Route::middleware('role:0,3')->group(function () {
		Route::middleware('role:0')->group(function () {
			Route::resource('prodi', ProdiController::class);
			Route::get('/prodi/{prodi}/delete', [ProdiController::class, 'delete'])->name('prodi.delete');
		});

		Route::resource('matakuliah', MataKuliahController::class);
		Route::get('/matakuliah/{matakuliah}/delete', [MataKuliahController::class, 'delete'])->name('matakuliah.delete');

		Route::resource('operator', OperatorController::class);
		Route::get('/operator/{operator}/delete', [OperatorController::class, 'delete'])->name('operator.delete');

		Route::resource('dosen', DosenController::class);
		Route::get('/dosen/{dosen}/delete', [DosenController::class, 'delete'])->name('dosen.delete');

		Route::resource('mahasiswa', MahasiswaController::class);
		Route::get('/mahasiswa/{mahasiswa}/delete', [MahasiswaController::class, 'delete'])->name('mahasiswa.delete');
		Route::get('/mahasiswa/{mahasiswa}/krs', [MahasiswaController::class, 'krs'])->name('mahasiswa.krs');
		Route::post('/mahasiswa/{mahasiswa}/krs', [MahasiswaController::class, 'krsUpdate'])->name('mahasiswa.krs.update');
		Route::get('/mahasiswa/{mahasiswa}/nilai', [MahasiswaController::class, 'nilai'])->name('mahasiswa.nilai');
		Route::post('/mahasiswa/{mahasiswa}/nilai', [MahasiswaController::class, 'nilaiUpdate'])->name('mahasiswa.nilai.update');
	});

	Route::get('/studi', [StudyController::class, 'index'])->name('study.index');
	Route::post('/query', [StudyController::class, 'query'])->name('study.query');

	Route::get('/transkrip/{uuid}', [StudyController::class, 'transkrip'])->name('study.transkrip');
});
