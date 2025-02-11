<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PharIo\Manifest\Author;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;

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

// user
Route::post("register_admin", [AuthController::class,"register"]);
Route::get("/get_user",[AuthController::class,"getUser"]);
Route::get("/get_detail_user/{id}",[AuthController::class,"getDetailUser"]);
Route::put("/update_userz/{id}",[AuthController::class,"updateUser"]);
Route::delete("/hapus_user/{id}",[AuthController::class,"hapus_user"]);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// category
Route::post('/add_category', [CategoryController::class, 'register']);
Route::get('/categories', [CategoryController::class, 'getCategory']);
Route::get('/get_detail_category/{id}', [CategoryController::class, 'getDetailCategory']);
Route::put('/update_category/{id}', [CategoryController::class, 'UpdateCategory']);
Route::delete('/hapus_category/{id}', [CategoryController::class, 'HapusCategory']);
Route::middleware('auth:sanctum')->get('/category', function (Request $request) {
    return $request->category();
});

// Movie 
Route::post('/add_movie', [MovieController::class, 'register']); 
Route::get('/movies', [MovieController::class, 'getMovie']); 
Route::get('/movie/{id}', [MovieController::class, 'getDetailMovie']); 
Route::put('/update_movie/{id}', [MovieController::class, 'update_Movie']); 
Route::delete('/delete_movie/{id}', [MovieController::class, 'hapus_Movie']); 

//login-logout
Route::post("/login",[AuthController::class,"login"]);
Route::get("/logout",[AuthController::class,"logout"]);