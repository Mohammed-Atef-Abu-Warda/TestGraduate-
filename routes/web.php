<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;

// 1. الصفحة العامة
Route::get('/', function () {
    return view('welcome_hr');
})->name('home');

// 2. الضيوف (غير مسجلي الدخول)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// 3. المسارات المحمية (auth)
// 3. المسارات المحمية (auth)
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('employees.dashboard');
    Route::get('/profile', [EmployeeController::class, 'profile'])->name('employees.profile');
    
    // جميع مسارات الموظفين بدون دالة Middleware هنا
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});
