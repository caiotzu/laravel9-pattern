<?php

use Illuminate\Support\Facades\Route;

// imports theme
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\LayoutSchemeController;
use App\Http\Controllers\ColorSchemeController;

// imports general controllers
use App\Http\Controllers\ {
  CountyController,
  ZipCodeController,
};

// imports admin
use App\Http\Controllers\Admin\ {
  AdminAuthController,
  AdminUserController,
  AdminHomeController,
  AdminSystemController,
  AdminCompanyController,
  AdminPermissionController,
  AdminUserProfileController,
  AdminCompanyGroupController,
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

        // user profile
          Route::get('/userProfile', [AdminUserProfileController::class, 'index'])->name('admin.userProfiles.index');
        //---


        // records route
          Route::get('/companyGroups/create', [AdminCompanyGroupController::class, 'create'])->name('admin.companyGroups.create')->middleware('check.admin.permission:COMPANYGROUP_CREATE');
          Route::get('/companyGroups/{id}/edit', [AdminCompanyGroupController::class, 'edit'])->name('admin.companyGroups.edit')->middleware('check.admin.permission:COMPANYGROUP_EDIT');
          Route::put('/companyGroups/{id}', [AdminCompanyGroupController::class, 'update'])->name('admin.companyGroups.update')->middleware('check.admin.permission:COMPANYGROUP_EDIT');
          Route::post('/companyGroups', [AdminCompanyGroupController::class, 'store'])->name('admin.companyGroups.store')->middleware('check.admin.permission:COMPANYGROUP_CREATE');
          Route::get('/companyGroups', [AdminCompanyGroupController::class, 'index'])->name('admin.companyGroups.index')->middleware('check.admin.permission:COMPANYGROUP_INDEX');

          Route::get('/companies/create', [AdminCompanyController::class, 'create'])->name('admin.companies.create')->middleware('check.admin.permission:COMPANY_CREATE');
          Route::get('/companies/{id}/edit', [AdminCompanyController::class, 'edit'])->name('admin.companies.edit')->middleware('check.admin.permission:COMPANY_EDIT');
          Route::put('/companies/{id}', [AdminCompanyController::class, 'update'])->name('admin.companies.update')->middleware('check.admin.permission:COMPANY_EDIT');
          Route::post('/companies', [AdminCompanyController::class, 'store'])->name('admin.companies.store')->middleware('check.admin.permission:COMPANY_CREATE');
          Route::get('/companies', [AdminCompanyController::class, 'index'])->name('admin.companies.index')->middleware('check.admin.permission:COMPANY_INDEX');
        //---

        // settings routes
          Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create')->middleware('check.admin.permission:USER_CREATE');
          Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit')->middleware('check.admin.permission:USER_EDIT');
          Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update')->middleware('check.admin.permission:USER_EDIT');
          Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store')->middleware('check.admin.permission:USER_CREATE');
          Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index')->middleware('check.admin.permission:USER_INDEX');

          Route::get('/permissions/create', [AdminPermissionController::class, 'create'])->name('admin.permissions.create')->middleware('check.admin.permission:PERMISSION_CREATE');
          Route::get('/permissions/{id}/edit', [AdminPermissionController::class, 'edit'])->name('admin.permissions.edit')->middleware('check.admin.permission:PERMISSION_EDIT');
          Route::put('/permissions/{id}', [AdminPermissionController::class, 'update'])->name('admin.permissions.update')->middleware('check.admin.permission:PERMISSION_EDIT');
          Route::post('/permissions', [AdminPermissionController::class, 'store'])->name('admin.permissions.store')->middleware('check.admin.permission:PERMISSION_CREATE');
          Route::get('/permissions', [AdminPermissionController::class, 'index'])->name('admin.permissions.index')->middleware('check.admin.permission:PERMISSION_INDEX');

          Route::put('/systems', [AdminSystemController::class, 'update'])->name('admin.systems.update')->middleware('check.admin.permission:SYSTEM_EDIT');
          Route::get('/systems', [AdminSystemController::class, 'index'])->name('admin.systems.index')->middleware('check.admin.permission:SYSTEM_INDEX');
        //---
      });
    //---

    // ajax routes
      Route::prefix('ajax')->group(function() {
        Route::post('/zipCodeSearch', [ZipCodeController::class, 'search']);

        Route::get('/countySearch', [CountyController::class, 'search']);
        Route::get('/getCountyById', [CountyController::class, 'getCountyById']);
      });
    //---
  });
//---
