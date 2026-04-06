<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    // Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('pages.auth.verify-email', ['title' => 'Verify Email']);
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Dashboard Route
// Route::middleware(['auth', 'verified'])->group(function () {
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard.ecommerce', ['title' => 'Dashboard']);
    })->name('dashboard');

    // User Management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', \App\Livewire\Admin\User\Index::class)->name('users.index');
        Route::get('/users/create', \App\Livewire\Admin\User\Create::class)->name('users.create');
        Route::get('/users/{user}/edit', \App\Livewire\Admin\User\Edit::class)->name('users.edit');

        // Roles
        Route::get('/roles', \App\Livewire\Admin\Role\Index::class)->name('roles.index');
        Route::get('/roles/create', \App\Livewire\Admin\Role\Create::class)->name('roles.create');
        Route::get('/roles/{role}/edit', \App\Livewire\Admin\Role\Edit::class)->name('roles.edit');

        // Permissions
        Route::get('/permissions', \App\Livewire\Admin\Permission\Index::class)->name('permissions.index');
        Route::get('/permissions/create', \App\Livewire\Admin\Permission\Create::class)->name('permissions.create');
        Route::get('/permissions/{permission}/edit', \App\Livewire\Admin\Permission\Edit::class)->name('permissions.edit');

        // Location Management
        // Countries
        Route::get('/countries', \App\Livewire\Admin\Country\Index::class)->name('countries.index');
        Route::get('/countries/create', \App\Livewire\Admin\Country\Create::class)->name('countries.create');
        Route::get('/countries/{country}/edit', \App\Livewire\Admin\Country\Edit::class)->name('countries.edit');

        // States
        Route::get('/states', \App\Livewire\Admin\State\Index::class)->name('states.index');
        Route::get('/states/create', \App\Livewire\Admin\State\Create::class)->name('states.create');
        Route::get('/states/{state}/edit', \App\Livewire\Admin\State\Edit::class)->name('states.edit');

        // Cities
        Route::get('/cities', \App\Livewire\Admin\City\Index::class)->name('cities.index');
        Route::get('/cities/create', \App\Livewire\Admin\City\Create::class)->name('cities.create');
        Route::get('/cities/{city}/edit', \App\Livewire\Admin\City\Edit::class)->name('cities.edit');
    });
});
















