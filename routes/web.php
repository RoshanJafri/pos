<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PortionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagerAuthController;
use App\Http\Controllers\SubCategoryController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
/* Login / Logout */
Route::get('/manager/login', [ManagerAuthController::class, 'showLogin'])
    ->name('manager.login');

Route::post('/manager/login', [ManagerAuthController::class, 'login'])
    ->name('manager.login.submit');

Route::post('/manager/logout', [ManagerAuthController::class, 'logout'])
    ->name('manager.logout');

Route::resource('employees', EmployeeController::class);
Route::resource('items', ItemController::class);
Route::resource('kitchen', PortionController::class);
Route::post('kitchen/updateAll', [PortionController::class, 'updateAll']);



Route::middleware('manager.auth')->group(function () {
    Route::prefix('accounts')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('accounts.index');
        Route::get('items', [AccountController::class, 'itemsSold'])->name('accounts.items.sold');
        Route::get('sales', [AccountController::class, 'salesShow'])->name('accounts.sales.show');
        // Route::get('/sales/{date}', [AccountController::class, 'showDay'])->name('accounts.sales.day');
        Route::get('/filter', [AccountController::class, 'filter'])->name('accounts.filter');
    });

    Route::get('orders', [OrderController::class,'index']);
});


Route::get('orders/printClient/{id}', [OrderController::class, 'clientReceipt'])->name('orders.printClient');
Route::get('orders/printOffice/{id}', [OrderController::class, 'officeReceipt'])->name('orders.printOffice');
Route::get('orders/download/{file}', function ($file) {
    $path = storage_path('app/' . $file);
    if (file_exists($path)) {
        return response()->download($path)->deleteFileAfterSend(true);
    }

    abort(404, 'File not found');
})->name('orders.download');
Route::resource('orders', OrderController::class);
Route::get('/categories/sort', [CategoryController::class, 'sort'])->name('categories.sort');
Route::post('/categories/updateOrder', [CategoryController::class, 'updateOrder'])->name('categories.updateOrder');
Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubCategoryController::class);

Route::post('/admin/clear-cache', function () {
    cache()->forget('categories');
    cache()->forget('employees');
    return response()->json(['success' => true]);
})->name('admin.clear.cache');