<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\DosenMatakuliahController;
use App\Http\Controllers\FormAccount;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenPembimbingController;
use App\Http\Controllers\Matakuliah_MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Middleware\ApiAuthen;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('/login', [FormAccount::class, 'login']);
Route::post('/register', [FormAccount::class, 'register']);

Route::middleware([ApiAuthen::class])->group(function () {
    Route::get('/dosen', [DosenController::class, 'index']);
});
Route::get('/dosen/{id}', [DosenController::class, 'show']);
Route::post('/dosen', [DosenController::class, 'store']);
Route::put('/dosen/{id}', [DosenController::class, 'update']);
Route::patch('/dosen/{id}', [DosenController::class, 'update']);
Route::delete('/dosen/{id}', [DosenController::class, 'destroy']);

Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show']);
Route::post('/mahasiswa', [MahasiswaController::class, 'store']);
Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update']);
Route::patch('/mahasiswa/{id}', [MahasiswaController::class, 'update']);
Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy']);

Route::get('/dosen-pembimbing', [DosenPembimbingController::class, 'index']);
Route::get('/dosen-pembimbing/{id}', [DosenPembimbingController::class, 'show']);
Route::post('/dosen-pembimbing', [DosenPembimbingController::class, 'store']);
Route::put('/dosen-pembimbing/{id}', [DosenPembimbingController::class, 'update']);
Route::delete('/dosen-pembimbing/{id}', [DosenPembimbingController::class, 'destroy']);

Route::get('/matakuliah-mahasiswa', [Matakuliah_MahasiswaController::class, 'index']);
Route::post('/matakuliah-mahasiswa', [Matakuliah_MahasiswaController::class, 'store']);
Route::put('/matakuliah-mahasiswa/{id}', [Matakuliah_MahasiswaController::class, 'update']);
Route::delete('/matakuliah-mahasiswa/{id}', [Matakuliah_MahasiswaController::class, 'destroy']);
Route::get('/matakuliah-mahasiswa/{id}', [Matakuliah_MahasiswaController::class, 'show']);


Route::get('/matakuliah', [MatakuliahController::class, 'index']);
Route::get('/matakuliah/{id}', [MatakuliahController::class, 'show']);
Route::post('/matakuliah', [MatakuliahController::class, 'store']);
Route::put('/matakuliah/{id}', [MatakuliahController::class, 'update']);
Route::delete('/matakuliah/{id}', [MatakuliahController::class, 'destroy']);

Route::get('/dosen-matakuliah', [DosenMatakuliahController::class, 'index']);
Route::get('/dosen-matakuliah/{id}', [DosenMatakuliahController::class, 'show']);
Route::post('/dosen-matakuliah', [DosenMatakuliahController::class, 'store']);
Route::put('/dosen-matakuliah/{id}', [DosenMatakuliahController::class, 'update']);
Route::delete('/dosen-matakuliah/{id}', [DosenMatakuliahController::class, 'destroy']);
