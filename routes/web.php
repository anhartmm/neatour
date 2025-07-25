<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/katalog', [HomeController::class, 'katalog'])->name('katalog');
Route::get('/katalog/{id}', [HomeController::class, 'show'])->name('katalog.detail');

Route::get('dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('destination.index');
    } elseif ($user->role === 'superadmin') {
        return redirect()->route('user.index');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {
    Route::resource('user', UserController::class);
    
    // Category routes dengan pembatasan akses hanya untuk superadmin
    Route::controller(CategoryController::class)->prefix('category')->name('category.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{category}', 'update')->name('update');
        Route::delete('/{category}', 'destroy')->name('destroy');
    });
});

// Destination routes
Route::resource('destination', DestinationController::class)->middleware(['auth']);

// Testimonial routes
Route::resource('testimonial', TestimonialController::class)->middleware(['auth']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
