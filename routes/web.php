<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DataMigrationController;
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
Route::get('/run-seeder', [UserController::class, 'runSeeder']);

#Protected Routes for Admin
Route::middleware(['checkUserType:admin'])->group(function () {

#Migrate Data Routes
Route::get('/migrate-users', [DataMigrationController::class, 'migrateUsers'])->name('migrateUsers');

#User List Route
Route::get('/userList', function () {
    $user = \App\Models\User::all();
    return view('pages.userList', ['users'=> $user] );
}) ->name('userlist');

#User Activation Route
Route::get('/userlist/user-activate/{id}', [UserController::class , 'acc_activate']) ->name('acc_activate');

Route::get('/truncateUser', [DataMigrationController::class , 'truncateUsers']) ->name('truncateUsers');

#Upload Route
Route::get('/document', function () {
    $categories = \App\Models\Category::all();
    return view('pages.upload', ['categories'=> $categories] );
}) ->name('upload');

Route::post('/document/upload', [DocumentController::class,'docPost'] )->name('upload.post');
Route::get('/document/truncate', [DocumentController::class, 'truncate'])->name('doc.truncate'); // Clear Document table at once
Route::get('/document/truncate-res', [DocumentController::class, 'truncateRes'])->name('doc.resource'); // Clear Document table at once


#Manage Documents Route
Route::get('/manage', function () { 
    $documents = \App\Models\Document::all();
    return view('pages.manage' , ['documents' => $documents]); 
}) ->name('manage');

Route::get('/manage/update/{id}', [DocumentController::class , 'manageUpdate']) ->name('manage.update');
Route::post('/manage/update-post', [DocumentController::class , 'updatePost']) ->name('edit.post');

Route::get('/manage/view/{id}', [DocumentController::class , 'manageView']) ->name('manage.view');

Route::get('/manage/delete/{id}', [DocumentController::class , 'manageDelete']) ->name('manage.delete');
Route::get('/manage/download/{id}', [DocumentController::class , 'manageDownload']) ->name('manage.download');
Route::get('/manage/search/{id}', [DocumentController::class , 'filter']) ->name('manage.search');

Route::get('/search', function () { 
    $categories = \App\Models\Category::all();
    return view('pages.search', ['categories'=> $categories] ); 
}) ->name('search');

Route::post('/search-post', [DocumentController::class , 'search']) ->name('search.post');



#Category Route
Route::get('/category', function () {
    $categories = \App\Models\Category::all();
    return view('pages.category', ['categories'=> $categories]);
}) ->name('category');

Route::post('/category-post', [CategoryController::class, 'createCat']) ->name('category.post');
Route::get('/category-delete/{id}', [CategoryController::class, 'deleteCat']) ->name('category.delete');
Route::get('/category/truncate', [CategoryController::class, 'truncate'])->name('category.truncate'); // Clear Category table at once
});


#Protected Routes for students
Route::middleware(['checkUserType:student'])->group(function () {
Route::get('/stdManage', [DocumentController::class , 'std_Filter']) ->name('stdManage');
Route::get('/stdManage/view/{id}', [DocumentController::class , 'manageView']) ->name('manage.stdView');

});


#Unprotected Routes
Route::get('/home', function () { return view('pages.home'); }) ->name('home');
Route::get('/manage/viewDoc/{id}', [DocumentController::class , 'manageDocView']) ->name('manage.doc.view');








