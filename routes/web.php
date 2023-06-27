<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\RestaurantController;
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
})->middleware('checkhome');

Route::prefix('/buyer')->group(function() {
    Route::view('/', 'buyer.home');
    Route::get('/order', [BuyerController::class, 'getDataForOrderPage']);
    Route::get('/order/{id}', [BuyerController::class, 'getFoodInRestaurant']);
    Route::get('/cart', [BuyerController::class, 'getCart']);
});

Route::view('/buyer', 'buyer.home')->middleware('buyercheck');
Route::view('/drivers', 'drivers')->middleware('drivercheck');
Route::view('/signup/buyer', 'signupbuyer')->middleware('checklogin');
Route::view('/signup/driver', 'signupDriver')->middleware('checklogin');
Route::view('/signup/restaurant', 'signupRestaurant')->middleware('checklogin');
Route::view('/login/buyer', 'loginbuyer')->middleware('checklogin');
Route::view('/login/driver', 'loginDriver')->middleware('checklogin');
Route::view('/login/restaurant', 'loginRestaurant')->middleware('checklogin');
Route::view('/login', 'login')->middleware('checklogin');
Route::view('signup', 'signup')->middleware('checklogin');

Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.home');
    Route::view('/add-restaurant', 'admin.addRestaurant');
});

Route::prefix('/restaurant')->group(function() {
   Route::view('/', 'restaurant.home');
   Route::get('/categories', [RestaurantController::class, 'getCategories']);
   Route::post('/add/category', [RestaurantController::class, 'addCategory']);
   Route::view('/add/category', 'restaurant.addCategory');
   Route::get('/delete/category/{id}', [RestaurantController::class, 'deleteCategory']);
   Route::get('/food', [RestaurantController::class, 'getFood']);
   Route::post('/add/food', [RestaurantController::class, 'addFood']);
   Route::get('/delete/food/{id}', [RestaurantController::class, 'deleteFood']);
});

Route::post('restaurant/add/category', [RestaurantController::class, 'addCategory']);

Route::post('signup/buyer', [AuthController::class, 'buyerSignUp']);
Route::post('signup/driver', [AuthController::class, 'driverSignUp']);
Route::post('signup/restaurant', [AuthController::class, 'restaurantSignUp']);

Route::post('login/buyer', [AuthController::class, 'buyerLogin']);
Route::post('login/driver', [AuthController::class, 'driverLogin']);
Route::post('login/restaurant', [AuthController::class, 'restaurantLogin']);

Route::post('logout', [AuthController::class, 'logout']);