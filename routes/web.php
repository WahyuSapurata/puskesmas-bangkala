<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::get('/', [DashboardController::class, 'welcome']);


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'activation'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('pengajuan', PengajuanController::class);
    Route::get('pengajuan-cetak', [PengajuanController::class, 'cetak'])->name('pengajuan.cetak');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'is_admin']], function () {
    Route::get('bendahara', [UserController::class, 'bendahara'])->name('bendahara.index');
    Route::get('bendahara/{user}/approve', [UserController::class, 'bendaharaApprove'])->name('bendahara.approve');
    Route::delete('bendahara/{user}', [UserController::class, 'bendaharaDestroy'])->name('bendahara.destroy');
});

Route::group(['prefix' => 'bendahara', 'middleware' => ['auth', 'is_bendahara', 'activation']], function () {
    Route::get('staf', [UserController::class, 'staf'])->name('staf.index');
    Route::get('staf/{user}/approve', [UserController::class, 'stafApprove'])->name('staf.approve');
    Route::delete('staf/{user}', [UserController::class, 'stafDestroy'])->name('staf.destroy');
    Route::resource('jenis', JenisController::class);
    Route::resource('alat', AlatController::class);
    Route::resource('bahan', BahanController::class);
    Route::get('pengajuan-data', [PengajuanController::class, 'data'])->name('pengajuan.data');
    Route::get('pengajuan/{pengajuan}/kelola', [PengajuanController::class, 'kelola'])->name('pengajuan.kelola');
    Route::get('pengajuan-item/{pengajuan}/{pengajuanItem}/tolak', [PengajuanController::class, 'tolak'])->name('pengajuan-item.tolak');
    Route::get('pengajuan-item/{pengajuan}/{pengajuanItem}/terima', [PengajuanController::class, 'terima'])->name('pengajuan-item.terima');
    Route::get('pengajuan/{pengajuan}/tolak', [PengajuanController::class, 'tolakPengajuan'])->name('pengajuan.tolak');
    Route::get('pengajuan/{pengajuan}/terima', [PengajuanController::class, 'terimaPengajuan'])->name('pengajuan.terima');
});

Route::group(['prefix' => 'staf', 'middleware' => ['auth', 'is_staf', 'activation']], function () {
    Route::get('apoteker', [UserController::class, 'apoteker'])->name('apoteker.index');
    Route::get('apoteker/{user}/approve', [UserController::class, 'apotekerApprove'])->name('apoteker.approve');
    Route::delete('apoteker/{user}', [UserController::class, 'apotekerDestroy'])->name('apoteker.destroy');
    Route::get('pengajuan/{pengajuan}/send', [PengajuanController::class, 'send'])->name('pengajuan.send');
    Route::get('pengajuan-item/create', [PengajuanController::class, 'item'])->name('pengajuan-item.create');
    Route::post('pengajuan-item', [PengajuanController::class, 'storeItem'])->name('pengajuan-item.store');
    Route::delete('pengajuan-item/{pengajuanItem}', [PengajuanController::class, 'destroyItem'])->name('pengajuan-item.destroy');
});

Route::group(['prefix' => 'apoteker', 'middleware' => ['auth', 'is_apoteker', 'activation']], function () {
    Route::get('pengajuan/{pengajuan}/approve-apoteker', [PengajuanController::class, 'approveApoteker'])->name('pengajuan.approve-apoteker');
});

Route::get('waiting', function () {
    return view('waiting');
})->name('waiting');

require __DIR__ . '/auth.php';
