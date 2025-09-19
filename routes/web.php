<?php
// routes/web.php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VMController;
use App\Http\Controllers\VMRentalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Dashboard umum (hanya login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// ROUTE ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Server hanya bisa dikelola admin
    Route::resource('servers', ServerController::class);

    // Rental full akses (admin bisa kelola semua)
    Route::resource('rentals', RentalController::class);

    // Admin dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
});

// ROUTE USER (accessible by admin and user)
Route::middleware(['auth', 'role:admin,user'])->group(function () {
    // User hanya bisa kelola VM sendiri
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    // Ensure named index route exists (some callers expect route('vms.index'))
    Route::get('/vms', [VMController::class, 'index'])->name('vms.index');
    // Ensure named create route exists for forms/links
    Route::get('/vms/create', [VMController::class, 'create'])->name('vms.create');
    Route::resource('vms', VMController::class);

    // User dashboard
    Route::get('/user/dashboard', [DashboardController::class, 'user'])
        ->name('user.dashboard');
});


// ROUTE UMUM (semua user login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
// Test route - tambahkan di bagian bawah
Route::get('/test-role', function() {
    return 'Role middleware working! User: ' . auth()->user()->name . ', Role: ' . auth()->user()->role;
})->middleware(['auth', 'role:user']);

    // Rental Routes
    //Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    //Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store');
    //Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');

    // VMRental resource (user can request rental)
    Route::resource('vmrentals', VMRentalController::class);
});

require __DIR__.'/auth.php';