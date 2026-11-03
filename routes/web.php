<?php
use App\Http\Controllers\{AsistenciaController, AuthController, DashboardController, MembresiaController, PlanController, SocioController};
use App\Http\Middleware\Role;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'form'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('socios', SocioController::class)->except('destroy');
    Route::post('socios/{socio}/membresias', [MembresiaController::class, 'store'])->name('membresias.store');
    Route::get('/checkin', [AsistenciaController::class, 'index'])->name('checkin');
    Route::post('/api/asistencias', [AsistenciaController::class, 'store'])->name('api.asistencias');

    // Solo administrador
    Route::middleware(Role::class . ':admin')->group(function () {
        Route::delete('socios/{socio}', [SocioController::class, 'destroy'])->name('socios.destroy');
        Route::resource('planes', PlanController::class)->only(['index', 'store', 'destroy'])->parameters(['planes' => 'plan']);
    });
});
