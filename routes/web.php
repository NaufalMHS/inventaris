<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;

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



Route::get('/', [ItemController::class, 'dashboardStatistics'])->name('item.dashboard');

Route::get('/admin-area', [ItemController::class, 'dashboardStatistics'])->name('item.dashboard');


// Menggunakan resource untuk lokasi
Route::resource('/admin-area/lokasi', LocationController::class);
Route::get('/lokasi/{building}/rooms', [LocationController::class, 'show'])->name('lokasi.rooms');
Route::post('/admin-area/lokasi/{building}/rooms', [LocationController::class, 'storeRoom'])->name('lokasi.rooms.store');

Route::get('/admin-area/transfer/history', [TransferController::class, 'history'])->name('transfer.history');

Route::get('/admin-area/transfer/history/{id}', [TransferController::class, 'showHistory'])->name('transfer.showhistory');

Route::resource('/admin-area/kategori', CategoryController::class);
Route::resource('/admin-area/transfer', TransferController::class);
Route::resource('/admin-area/barang', ItemController::class);
Route::resource('/admin-area/users', UserController::class);


Route::get('/api/item/{itemId}/locations', [TransferController::class, 'getItemLocations']);

Route::get('/api/rooms/{buildingId}', [TransferController::class, 'getRoomsByBuilding']);