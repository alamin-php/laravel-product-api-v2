<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// category route
Route::get('category',[CategoryController::class,'index']);
Route::post('category',[CategoryController::class,'store']);
Route::get('category/{id}',[CategoryController::class,'show']);
Route::get('category/{id}/edit',[CategoryController::class,'edit']);
Route::put('category/{id}/update',[CategoryController::class,'update']);
Route::delete('category/{id}/delete',[CategoryController::class,'destroy']);
// brand route
Route::get('brand',[BrandController::class,'index']);
Route::post('brand',[BrandController::class,'store']);
Route::get('brand/{id}',[BrandController::class,'show']);
Route::get('brand/{id}/edit',[BrandController::class,'edit']);
Route::put('brand/{id}/update',[BrandController::class,'update']);
Route::delete('brand/{id}/delete',[BrandController::class,'destroy']);
// product route
Route::get('product',[ProductController::class,'index']);
Route::post('product',[ProductController::class,'store']);
Route::get('product/{id}',[ProductController::class,'show']);
Route::get('product/{id}/edit',[ProductController::class,'edit']);
Route::put('product/{id}/update',[ProductController::class,'update']);
Route::delete('product/{id}/delete',[ProductController::class,'destroy']);
