<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;

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

    // Landing Page
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    // Authentication Routes (from Breeze)
    require __DIR__.'/auth.php';

    // Authenticated Routes
    Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Admin Routes
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/transactions', function () {
            return view('admin.transactions');
        })->name('admin.transactions');
        Route::post('/transactions/process', [App\Http\Controllers\Admin\TransactionController::class, 'process'])->name('admin.transactions.process');
        Route::get('/api/user-balance', [App\Http\Controllers\Admin\TransactionController::class, 'getUserBalance']);
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
        Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
        Route::post('/admin/users/update-saldo', [App\Http\Controllers\Admin\UserController::class, 'updateSaldo'])->name('admin.users.update-saldo');
        Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
        Route::get('/users/add-saldo', [App\Http\Controllers\Admin\UserController::class, 'addSaldo'])->name('admin.users.add-saldo');
        Route::post('/users/add-saldo', [App\Http\Controllers\Admin\UserController::class, 'addSaldoProcess'])->name('admin.users.add-saldo.process');
        Route::post('/users/add-saldo/import', [App\Http\Controllers\Admin\UserController::class, 'importSaldo'])->name('admin.users.add-saldo.import');
        Route::get('/users/min-saldo', [App\Http\Controllers\Admin\UserController::class, 'minSaldo'])->name('admin.users.min-saldo');
        Route::post('/users/min-saldo', [App\Http\Controllers\Admin\UserController::class, 'minSaldoProcess'])->name('admin.users.min-saldo.process');
        Route::post('/users/min-saldo/import', [App\Http\Controllers\Admin\UserController::class, 'importminSaldo'])->name('admin.users.min-saldo.import');
        Route::post('/admin/users/import', [\App\Http\Controllers\Admin\UserController::class, 'import'])->name('admin.users.import');
        Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
        // Add other admin routes here
    });
    });
    
    // User Routes
    Route::prefix('user')->middleware(['role:user'])->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/transactions', [App\Http\Controllers\User\TransactionController::class, 'index'])->name('transactions');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        // Add other user routes here
    
});
