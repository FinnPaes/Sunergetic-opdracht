<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PageLoader;

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

Route::get("/", [PageLoader::class, "index"]);
Route::get("/view/{customer_id}", [PageLoader::class, "customer"])->name("view");
Route::get("/edit/{customer_id}", [PageLoader::class, "customer"])->name("edit");
Route::get("/create", [PageLoader::class, "create"])->name("create");