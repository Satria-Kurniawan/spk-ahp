<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PerbandinganKriteriaController;
use App\Http\Controllers\PerbandinganAlternatifController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AtletController;
use App\Http\Controllers\DataAtletController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MatriksBerpasanganController;
use App\Http\Controllers\MatriksBerpasanganSubkriteriaController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\SubKriteriaController;
use App\Models\PerbandinganKriteria;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/kriteria/data', [KriteriaController::class, 'getDataKriteria'])->name('kriteria.data');
Route::get('/kriteria/create', [KriteriaController::class, 'createKriteria'])->name('kriteria.create');
Route::post('/kriteria/store', [KriteriaController::class, 'storeKriteria'])->name('kriteria.store');
Route::get('/kriteria/edit/{id}', [KriteriaController::class, 'editKriteria'])->name('kriteria.edit');
Route::post('/kriteria/update/{id}', [KriteriaController::class, 'updateKriteria'])->name('kriteria.update');
Route::get('/kriteria/delete/{id}', [KriteriaController::class, 'deleteKriteria'])->name('kriteria.delete');

Route::post('/matriks-berpasangan/store', [MatriksBerpasanganController::class, 'storeMatriksBerpasangan'])->name('matriksBerpasangan.store');

Route::get('/kategori/data', [KategoriController::class, 'getDataKategori'])->name('kategori.data');
Route::get('/kategori/create', [KategoriController::class, 'createKategori'])->name('kategori.create');
Route::post('/kategori/store', [KategoriController::class, 'storeKategori'])->name('kategori.store');
Route::get('/kategori/edit/{id}', [KategoriController::class, 'editKategori'])->name('kategori.edit');
Route::post('/kategori/update/{id}', [KategoriController::class, 'updateKategori'])->name('kategori.update');
Route::get('/kategori/delete/{id}', [KategoriController::class, 'deleteKategori'])->name('kategori.delete');


Route::get('/subkriteria/data', [SubKriteriaController::class, 'getDataSubkriteria'])->name('subkriteria.data');
Route::get('/subkriteria/create/{idKriteria}', [SubKriteriaController::class, 'createSubkriteria'])->name('subkriteria.create');
Route::post('/subkriteria/store', [SubKriteriaController::class, 'storeSubkriteria'])->name('subkriteria.store');
Route::get('/subkriteria/edit/{id}', [SubKriteriaController::class, 'editSubkriteria'])->name('subkriteria.edit');
Route::post('/subkriteria/update/{id}', [SubKriteriaController::class, 'updateSubkriteria'])->name('subkriteria.update');
Route::get('/subkriteria/delete/{id}', [SubKriteriaController::class, 'deleteSubkriteria'])->name('subkriteria.delete');

Route::post('/matriks-berpasangan-subkriteria/store/{id_kriteria}', [MatriksBerpasanganSubkriteriaController::class, 'storeMatriksBerpasanganSubkriteria'])->name('matriksBerpasanganSubkriteria.store');

Route::get('/alternatif/data', [AlternatifController::class, 'getDataAlternatif'])->name('alternatif.data');
Route::get('/alternatif/create', [AlternatifController::class, 'createAlternatif'])->name('alternatif.create');
Route::post('/alternatif/store', [AlternatifController::class, 'storeAlternatif'])->name('alternatif.store');
Route::get('/alternatif/edit/{id}', [AlternatifController::class, 'editAlternatif'])->name('alternatif.edit');
Route::post('/alternatif/update/{id}', [AlternatifController::class, 'updateAlternatif'])->name('alternatif.update');
Route::get('/alternatif/delete/{id}', [AlternatifController::class, 'deleteAlternatif'])->name('alternatif.delete');

Route::get('/perhitungan/data', [PerhitunganController::class, 'getDataPerhitungan'])->name('perhitungan.data');
