<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\HeadlineController;

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

// Route yang dapat diakses oleh guest atau tanpa login
Route::get('/', [PostController::class, 'index'])->name('home');
Route::resource('dropdown', DropdownController::class);
Route::get('/post/show/{id}', [PostController::class, 'show']);
Route::get('/search', [PostController::class, 'search'])->name('post.search');
Route::get('/headlines/show/{id}', [HeadlineController::class, 'show'])->name('headline.show');
Route::get('/data/show/{id}', [DataController::class, 'show'])->name('data.show');
Route::get('/document/show/{id}', [DocumentController::class, 'show'])->name('document.show');
Route::get('/file/show/{id}', [FileController::class, 'show']);
Route::get('/file/download/{id}', [FileController::class, 'download'])->name('file.download');

// Route untuk halaman welcome, login, register
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Route untuk dashboard yang hanya dapat diakses jika login dan terverifikasi
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk profile yang hanya dapat diakses oleh user setelah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route CRUD yang hanya dapat diakses setelah login
Route::middleware('auth')->group(function () {

    // Icon CRUD
    Route::get('/icon/create', [IconController::class, 'create'])->name('icon.create');
    Route::post('/icon/store', [IconController::class, 'store'])->name('icon.store');
    Route::get('/icon/data', [IconController::class, 'data'])->name('icon.data');
    Route::get('/icon/edit/{id}', [IconController::class, 'edit'])->name('icon.edit');
    Route::put('/icon/update/{id}', [IconController::class, 'update'])->name('icon.update');
    Route::delete('/icon/delete/{id}', [IconController::class, 'destroy'])->name('icon.destroy');

    // Post CRUD
    Route::get('/post/data', [PostController::class, 'data']);
    Route::get('/post/create', [PostController::class, 'create']);
    Route::post('post', [PostController::class, 'store']);
    Route::get('/post/edit/{id}', [PostController::class, 'edit']);
    Route::post('update/{id}', [PostController::class, 'update']);
    Route::delete('/post/delete/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::post('/post/delete-image', [PostController::class, 'deleteImage']);

    // Category CRUD
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/category/data', [CategoryController::class, 'data'])->name('category.data');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Headline CRUD
    Route::get('/headline/create', [HeadlineController::class, 'create'])->name('headline.create');
    Route::post('/headlines', [HeadlineController::class, 'store'])->name('headlines.store');
    Route::get('/headline/data', [HeadlineController::class, 'data'])->name('headline.data');
    Route::get('/headline/edit/{id}', [HeadlineController::class, 'edit'])->name('headline.edit');
    Route::post('/headline/update/{id}', [HeadlineController::class, 'update'])->name('headline.update');
    Route::delete('/headline/delete/{id}', [HeadlineController::class, 'destroy'])->name('headline.destroy');

    // Data CRUD
    Route::get('/data/create', [DataController::class, 'create'])->name('data.create');
    Route::post('/data', [DataController::class, 'store'])->name('data.store');
    Route::delete('/data/delete/{id}', [DataController::class, 'destroy'])->name('data.destroy');

    // Document CRUD
    Route::get('/document/data', [DocumentController::class, 'data'])->name('document.data');
    Route::get('/document/create', [DocumentController::class, 'create'])->name('document.create');
    Route::post('/document', [DocumentController::class, 'store'])->name('document.store');
    Route::get('/document/edit/{id}', [DocumentController::class, 'edit'])->name('document.edit');
    Route::patch('/document/update/{id}', [DocumentController::class, 'update'])->name('document.update');
    Route::delete('delete/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');

    // File CRUD
    Route::get('/file/data', [FileController::class, 'data'])->name('file.data');
    Route::get('/file/create', [FileController::class, 'create'])->name('file.create');
    Route::post('/file', [FileController::class, 'store'])->name('file.store');
    Route::get('/file/edit/{id}', [FileController::class, 'edit'])->name('file.edit');
    Route::post('/file/update/{id}', [FileController::class, 'update'])->name('file.update');
    Route::delete('/file/{id}', [FileController::class, 'destroy'])->name('file.destroy');

});

require __DIR__.'/auth.php';