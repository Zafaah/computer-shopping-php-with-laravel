<?php


use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRollsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [DashboardController::class, 'index']);

Route::get('/customers', [CustomerController::class, 'index']);
Route::post('/customers', [CustomerController::class, 'create']);
Route::get('/customers/edit/{id}', [CustomerController::class, 'editCustomer'])->name('customers.edit');
Route::get('/customers/delete/{id}', [CustomerController::class, 'deleteCustomer'])->name('customers.delete');


Route::get('/suppliers', [SupplierController::class, 'index']);
Route::post('/suppliers', [SupplierController::class, 'create']);
Route::get('/suppliers/edit/{id}', [SupplierController::class, 'editSupplier'])->name('suppliers.edit');
Route::get('/suppliers/delete/{id}', [SupplierController::class, 'deleteSupplier'])->name('suppliers.delete');


Route::get('/departments', [DepartmentController::class, 'index']);
Route::post('/departments', [DepartmentController::class, 'create']);
Route::get('/departments/edit/{id}', [DepartmentController::class, 'editDepartment'])->name('departments.edit');
Route::get('/departments/delete/{id}', [DepartmentController::class, 'deleteDepartment'])
                                        ->name('departments.delete');

Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/employees', [EmployeeController::class, 'create']);
Route::get('/employees/edit/{id}', [EmployeeController::class, 'editEmployee'])->name('employees.edit');
Route::get('/employees/delete/{id}', [EmployeeController::class, 'deleteEmployee'])
                                        ->name('employees.delete');

Route::get('/menus', [MenuController::class, 'index']);
Route::post('/menus', [MenuController::class, 'create']);
Route::get('/menus/edit/{id}', [MenuController::class, 'editMenu'])->name('menus.edit');
Route::get('/menus/delete/{id}', [MenuController::class, 'deleteMenu'])
                                        ->name('menus.delete');

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'create']);
Route::get('/products/edit/{id}', [ProductController::class, 'editProduct'])->name('products.edit');
Route::get('/products/delete/{id}', [ProductController::class, 'deleteProduct'])
                                        ->name('products.delete');


Route::get('/purchases', [PurchaseController::class, 'index']);
Route::post('/purchases', [PurchaseController::class, 'create']);
Route::get('/purchases/edit/{id}', [PurchaseController::class, 'editPurchase'])->name('purchases.edit');
Route::get('/purchases/delete/{id}', [PurchaseController::class, 'deletePurchase'])
                                        ->name('purchases.delete');

Route::get('/sales', [SalesController::class, 'index']);
Route::post('/sales', [SalesController::class, 'create']);
Route::get('/sales/edit/{id}', [SalesController::class, 'editSale'])->name('sales.edit');
Route::get('/sales/delete/{id}', [SalesController::class, 'deleteSale'])
                                        ->name('sales.delete');

Route::get('/users', [UserController::class, 'index'])->middleware(['auth']);
Route::post('/users', [UserController::class, 'create'])->middleware('auth');
Route::get('/users/edit/{id}', [UserController::class, 'editUser'])->name('users.edit')
      ->middleware(['auth']);
Route::get('/users/delete/{id}', [UserController::class, 'deleteUser'])
                                        ->name('users.delete')->middleware(['auth']);

Route::get('/users/login', [UserController::class, 'display']);
Route::post('/users/login', [UserController::class, 'login'])->name('login');
Route::get('/users/logout', [UserController::class, 'logout'])->middleware('auth');

Route::get('/rolls', [UserRollsController::class, 'index']);
Route::post('/rolls', [UserRollsController::class, 'create']);
Route::get('/rolls/edit/{id}', [UserRollsController::class, 'editRoll'])->name('rolls.edit');
Route::get('/rolls/delete/{id}', [UserRollsController::class, 'deleteRoll'])
                                        ->name('rolls.delete');


                                        