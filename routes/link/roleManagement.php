<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\RoleManagmentController;

Route::group(['group' => 'role'], function () {
    Route::get('admin-list', [RoleManagmentController::class, 'adminList'])->name('adminList');
    Route::post('admin', [RoleManagmentController::class, 'addEditAdmin'])->name('addEditAdmin')->middleware('check_demo');
    Route::get('admin-profile-{id}', [RoleManagmentController::class, 'viewAdminProfile'])->name('viewAdminProfile');
    Route::get('admin-edit-{id}', [RoleManagmentController::class, 'editAdminProfile'])->name('editAdminProfile');
    Route::get('admin-delete-{id}', [RoleManagmentController::class, 'deleteAdminProfile'])->name('deleteAdminProfile')->middleware('check_demo');

    Route::get('admin-role-list', [RoleManagmentController::class, 'adminRoleList'])->name('adminRoleList');
    Route::post('admin-role', [RoleManagmentController::class, 'adminRoleSave'])->name('adminRoleSave')->middleware('check_demo');
    Route::get('role-delete-{id}', [RoleManagmentController::class, 'adminRoleDelete'])->name('adminRoleDelete')->middleware('check_demo');

    Route::post('permission-route', [RoleManagmentController::class, 'addPermissionRoute'])->name('addPermissionRoute');
    Route::post('permission-route-delete-{id}', [RoleManagmentController::class, 'addPermissionRouteDelete'])->name('addPermissionRouteDelete')->middleware('check_demo');
    Route::get('permission-route-edit-{id}', [RoleManagmentController::class, 'addPermissionRouteEdit'])->name('addPermissionRouteEdit');
    Route::get('permission-route-reset', [RoleManagmentController::class, 'addPermissionRouteReset'])->name('addPermissionRouteReset');

    Route::get('admin-role-permission-group-list', [RoleManagmentController::class, 'adminRolePermissionGroupList'])->name('adminRolePermissionGroupList');
    Route::post('admin-role-permission-save', [RoleManagmentController::class, 'adminRolePermissionSave'])->name('adminRolePermissionSave')->middleware('check_demo');
});
