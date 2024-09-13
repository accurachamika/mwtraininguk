<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

#Login and Registration Routes
Route::get('/', function () { return view('auth.login'); })->name('login');
Route::get('/register', function () { return view('auth.register'); }) ->name('register');
Route::post('/user-register', [UserController::class, 'regPost'])->name('register.post');
Route::post('/user-login', [UserController::class, 'logIn'])->name('login.post');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

#Protected Routes
Route::middleware(['checkUserType:admin'])->group(function () {

#Upload Route
Route::get('/upload', function () {
    $categories = \App\Models\Category::all();
    return view('pages.upload', ['categories'=> $categories] );
}) ->name('upload');

Route::post('/upload', [DocumentController::class,'docPost'] )->name('upload.post');


Route::get('/manage', function () { return view('pages.manage'); }) ->name('manage');
Route::get('/search', function () { return view('pages.search'); }) ->name('search');

Route::get('/category', function () {
    $categories = \App\Models\Category::all();
    return view('pages.category', ['categories'=> $categories]);
}) ->name('category');

Route::post('/category-post', [CategoryController::class, 'createCat']) ->name('category.post');
Route::get('/category-delete/{id}', [CategoryController::class, 'deleteCat']) ->name('category.delete');
Route::get('/category/truncate', [CategoryController::class, 'truncate'])->name('category.truncate');
});

Route::get('/home', function () { return view('pages.home'); }) ->name('home');










