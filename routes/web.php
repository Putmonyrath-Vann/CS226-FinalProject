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

Route::get('/')->middleware('redirectMiddleware');

Route::prefix('/buyer')->middleware('buyercheck')->group(function() {
    Route::view('/', 'buyer.home');
    Route::get('/order', [BuyerController::class, 'getDataForOrderPage']);
    Route::get('/order/{id}', [BuyerController::class, 'getFoodInRestaurant']);
    Route::get('/cart', [BuyerController::class, 'getCart']);
    Route::post('/buyerCheckout', [BuyerController::class, 'buyerCheckout']);
    Route::get('/history', [BuyerController::class, 'getHistory']);
    Route::get('/edit', [BuyerController::class, 'getEditPage']);
    Route::post('/edit/profile', [BuyerController::class, 'editProfile']);
});

Route::group(['middleware' => ['checkLogin']], function() {
    Route::view('/login', 'login-signup');
    Route::view('/login/buyer', 'loginbuyer');
    Route::view('/login/restaurant', 'loginRestaurant');
    Route::view('signup', 'signup');
    Route::view('/signup/buyer', 'signupbuyer');
    Route::view('/signup/restaurant', 'signupRestaurant');
});

Route::prefix('/restaurant')->middleware('restaurantcheck')->group(function() {
   Route::get('/', [RestaurantController::class, 'restaurantHome']);
   Route::get('/categories', [RestaurantController::class, 'getCategories']);
   Route::post('/add/category', [RestaurantController::class, 'addCategory']);
   Route::view('/add/category', 'restaurant.addCategory');
   Route::get('/remove/category/{id}', [RestaurantController::class, 'removeCategory']);
   Route::get('/food', [RestaurantController::class, 'getFood']);
   Route::post('/add/food', [RestaurantController::class, 'addFood']);
   Route::get('/remove/food/{id}', [RestaurantController::class, 'removeFood']);
   Route::get('/edit', [RestaurantController::class, 'getEditPage']);
   Route::post('/edit/profile', [RestaurantController::class, 'editProfile']);
});

Route::post('signup/buyer', [AuthController::class, 'buyerSignUp']);
Route::post('signup/restaurant', [AuthController::class, 'restaurantSignUp']);

Route::post('login/buyer', [AuthController::class, 'buyerLogin']);
Route::post('login/restaurant', [AuthController::class, 'restaurantLogin']);

Route::post('logout', [AuthController::class, 'logout']);