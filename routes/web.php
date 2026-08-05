<?php
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\FormatsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstitutionsController;
use App\Http\Controllers\PicsController;
use App\Http\Controllers\SectorsController;
use App\Http\Controllers\StatusesController;
use App\Http\Controllers\SummaryController;
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
Route::get("/", [HomeController::class, "index"])->name("home.index");
Route::get("/categories", [CategoriesController::class, "index"])->name("categories.index");
Route::get("/countries", [CountriesController::class, "index"])->name("countries.index");
Route::get("/documents", [DocumentsController::class, "index"])->name("documents.index");
Route::get("/formats", [FormatsController::class, "index"])->name("formats.index");
Route::get("/institutions", [InstitutionsController::class, "index"])->name("institutions.index");
Route::get("/pics", [PicsController::class, "index"])->name("pics.index");
Route::get("/sectors", [SectorsController::class, "index"])->name("sectors.index");
Route::get("/statuses", [StatusesController::class, "index"])->name("statuses.index");
Route::get("/summary", [SummaryController::class, "index"]);
Route::resource("/categories", CategoriesController::class);
Route::resource("/countries", CountriesController::class);
Route::resource("/documents", DocumentsController::class);
Route::resource("/formats", FormatsController::class);
Route::resource("/institutions", InstitutionsController::class);
Route::resource("/pics", PicsController::class);
Route::resource("/sectors", SectorsController::class);
Route::resource("/statuses", StatusesController::class);