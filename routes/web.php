<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketStatusController;
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

Route::middleware('splade')->group(function () {
    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();



    Route::middleware('auth')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/dashboard', DashboardController::class)->middleware(['verified']);



        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('tickets/{ticket}/restore', [TicketController::class, 'restore'])->name('tickets.restore')->withTrashed();
        Route::resource('tickets', TicketController::class);

        Route::get('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore')->withTrashed();
        Route::resource('users', UserController::class)->withTrashed();

        Route::resource('logs', LogController::class);



        Route::get('categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore')->withTrashed();
        Route::get('categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::resource('categories', CategoryController::class);

        Route::get('labels/{label}/restore', [LabelController::class, 'restore'])->name('labels.restore')->withTrashed();
        Route::resource('labels', LabelController::class);

        Route::post('comments/{ticket}', [CommentController::class, 'store'])->name('comments.store');
        Route::resource('comments', CommentController::class)->only('edit', 'update');

        Route::patch('/ticket/status/{ticket}', TicketStatusController::class)->name('ticketStatus');
    });

    require __DIR__ . '/auth.php';
});