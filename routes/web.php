<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ChatController;



Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show'); // Ver perfil
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create'); // Crear perfil
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store'); // Guardar perfil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // Editar perfil
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Actualizar perfil
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Eliminar perfil
});

Route::middleware('auth')->group(function () {
    Route::get('/chat/{userId}/create', [ChatController::class, 'createChat'])->name('chat.create');
    Route::get('/chat/{chatId}', [ChatController::class, 'showChat'])->name('chat.show');
    Route::post('/chat/{chatId}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])
    ->name('appointments.destroy')
    ->middleware('auth');


require __DIR__.'/auth.php';

