<?php

use App\Http\Controllers\AuthController;
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
    return view('index');
});

Route::view('/customers', 'customers');
Route::view('/drivers', 'drivers');
Route::view('/signup/customer', 'signupCustomer');
Route::view('/signup/driver', 'signupDriver');
Route::view('/login/customer', 'loginCustomer');
Route::view('/login/driver', 'loginDriver');
Route::view('/login', 'login');
Route::view('signup', 'signup');

Route::post('signup/customer', [AuthController::class, 'customerSignUp']);
Route::post('signup/driver', [AuthController::class, 'driverSignUp']);

Route::post('login/customer', [AuthController::class, 'customerLogin']);
Route::post('login/driver', [AuthController::class, 'driverLogin']);

Route::post('logout', [AuthController::class, 'logout']);