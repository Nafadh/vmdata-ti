<?php
// routes/web.php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VMController;
use App\Http\Controllers\VMRentalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;


Route::resource('servers', ServerController::class);
Route::resource('rentals', RentalController::class)->middleware(['auth']);
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
    //Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    //Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store');
    //Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');
});

require __DIR__.'/auth.php';