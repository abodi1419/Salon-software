<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('employees','App\Http\Controllers\EmployeeController');
Route::resource('products','App\Http\Controllers\ProductController');
Route::resource('services','App\Http\Controllers\ServiceController');
Route::resource('purchase_invoices','App\Http\Controllers\PurchaseInvoiceController');
Route::resource('sale_invoices','App\Http\Controllers\SaleInvoiceController');
Route::post('job_title/store','App\Http\Controllers\JobTitleController@store');
Route::get('job_title/create','App\Http\Controllers\JobTitleController@create');

