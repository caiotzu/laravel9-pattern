<?php

use Illuminate\Support\Facades\Route;

// imports theme
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\LayoutSchemeController;
use App\Http\Controllers\ColorSchemeController;

// imports admin
use App\Http\Controllers\Admin\ {
  AdminAuthController,
  AdminHomeController,
  AdminUserController,
};

// themes route
  Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
  Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');
  Route::get('layout-scheme-switcher/{layout_scheme}', [LayoutSchemeController::class, 'switch'])->name('layout-scheme-switcher');
//---

// admin authentication routes
  Route::get('admin', [AdminAuthController::class, 'index'])->name('admin.auth.index');
  Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.auth.login');
//---

// authenticated routes
  Route::middleware('auth')->group(function() {
    // admin routes
      Route::prefix('admin')->group(function() {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.auth.logout');

        Route::get('/home', [AdminHomeController::class, 'index'])->name('admin.home.index');

        // settings routes
          Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create')->middleware('check.admin.permission:USER_CREATE');
          Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit')->middleware('check.admin.permission:USER_EDIT');
          Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update')->middleware('check.admin.permission:USER_EDIT');
          Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store')->middleware('check.admin.permission:USER_CREATE');
          Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index')->middleware('check.admin.permission:USER_INDEX');
        //---
      });
    //---
  });
//---
