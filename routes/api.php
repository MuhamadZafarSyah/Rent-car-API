<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\PenaltiesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\TenantsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Auth
Route::post('/auth/login', [AuthController::class, 'lo+gin']);
Route::get('/auth/logout', [AuthController::class, 'logout']);

Route::middleware([])->group(function () {

    Route::get('/auth/logout', [AuthController::class, 'logout']);
    Route::delete('/register/{id}', [TenantsController::class, 'destroy']);
    Route::get('/register', [TenantsController::class, 'index']);
    Route::get('/register/{id}', [TenantsController::class, 'show']);
    Route::post('/register', [TenantsController::class, 'store']);
    Route::put('/register/{id}', [TenantsController::class, 'update']);

    // 1. CARS
    Route::get('/cars', [CarsController::class, 'index']);
    Route::get('/cars/{id}', [CarsController::class, 'show']);
    Route::post('/cars', [CarsController::class, 'store']);
    Route::put('/cars/{id}', [CarsController::class, 'update']);
    Route::delete('/cars/{id}', [CarsController::class, 'destroy']);

    // 2. PENALTIES
    Route::get('/penalties', [PenaltiesController::class, 'index']);
    Route::get('/penalties/{id}', [PenaltiesController::class, 'show']);
    Route::post('/penalties', [PenaltiesController::class, 'store']);
    Route::put('/penalties/{id}', [PenaltiesController::class, 'update']);
    Route::delete('/penalties/{id}', [PenaltiesController::class, 'destroy']);


    // 3. RENT
    Route::get('/rent', [RentController::class, 'index']);
    Route::get('/rent/{id}', [RentController::class, 'show']);
    Route::post('/rent', [RentController::class, 'store']);
    Route::put('/rent/{id}', [RentController::class, 'update']);
    Route::delete('/rent/{id}', [RentController::class, 'destroy']);

    // 4. Return
    Route::get('/return', [ReturnController::class, 'index']);
    Route::get('/return/{id}', [ReturnController::class, 'show']);
    Route::post('/return/{id}', [ReturnController::class, 'ubahStatusPeminjaman']);
    Route::put('/return/{id}', [ReturnController::class, 'update']);
    Route::delete('/return/{id}', [ReturnController::class, 'destroy']);
});






// GET => UNTUK MENGAMBIL DATA
// POST => UNTUK MEMBUAT / CREATE DATA BARU
// PUT => UNTUK MENGEDIT / MENGUPDATE DATA YANG SUDAH ADA
// DELETE => UNTUK MENGHAPUS DATA YAMG SUDAH ADA
