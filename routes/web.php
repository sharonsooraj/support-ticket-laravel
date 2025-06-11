<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/ticket/create', [TicketController::class, 'index'])->name('ticket.create');
Route::post('/ticket/store', [TicketController::class, 'store'])->name('ticket.store');
Route::get('/ticket/success', function () {
    return view('tickets.success');
})->name('ticket.success');

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('admin.tickets');
    Route::match(['get', 'post'], '/tickets/show', [AdminTicketController::class, 'show'])->name('admin.tickets.show');

    Route::Post('/tickets/update', [AdminTicketController::class, 'update'])->name('admin.tickets.update');
    Route::delete('/tickets/delete', [AdminTicketController::class, 'destroy'])->name('admin.tickets.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
