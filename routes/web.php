<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use Illuminate\Auth\Events\Verified;
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

Route::get('/', [GedungController::class, 'index'])->name('home');
// Route::get('/', [GedungController::classfunction () {
//     return view('home');
// })->name('home');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/booking/{id}', [BookingController::class, 'create'])->middleware(['auth', 'verified'])->name('booking');
Route::post('/booking', [BookingController::class,  'store'])->name('booking.store');

Route::get('/fasilitas', [FasilitasController::class, 'show'])->name('fasilitas');
Route::get('/gedung', [GedungController::class, 'show'])->name('gedung');
Route::get('/list', [BookingController::class, 'list'])->name('list');
Route::post('/list/{id}', [BookingController::class, 'hapus'])->name('hapus');
Route::get('/list/edit/{id}', [BookingController::class, 'edit'])->name('edit');
Route::post('/list/cancel/{id}', [BookingController::class, 'cancel'])->name('cancel');
Route::put('/image/{id}', [BookingController::class, 'bukti'])->name('bukti');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
