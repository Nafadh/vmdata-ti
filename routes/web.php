<?php
// routes/web.php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VMController;
use App\Http\Controllers\VMRentalController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // VM Routes
    Route::resource('vms', VMController::class);
    
    // Rental Routes
    Route::get('/rentals', [VMRentalController::class, 'index'])->name('rentals.index');
    Route::post('/rentals', [VMRentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/{rental}', [VMRentalController::class, 'show'])->name('rentals.show');
});

require __DIR__.'/auth.php';