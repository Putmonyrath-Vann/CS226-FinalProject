<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\Validator;

class BuyerController extends Controller
{
    //
    public function getDataForOrderPage(Request $request)
    {
        $restaurants = $this->getRestaurants();
        return view('buyer.order', ['restaurants' => $restaurants]);
    }

    public function getFoodInRestaurant(Request $request, $restaurant_id)
    {
        $categories = DB::table('category')->where('restaurant_id', $restaurant_id)->orderBy('category_id', 'asc')->get();

        $foods = DB::table('food')->where('restaurant_id', $restaurant_id)->orderBy('food_id', 'asc')->get();

        $restaurant = DB::table('restaurant')->where('restaurant_id', $restaurant_id)->first();

        $restaurant = (object) [
            'restaurant_id' => $restaurant->restaurant_id,
            'name' => $restaurant->name,
            'email' => $restaurant->email,
            'phone_number' => $restaurant->phone_number,
            'logo' => $restaurant->logo,
            'created_at' => $restaurant->created_at,
        ];

        // dd($categories, $foods, $restaurant);
        return view('buyer.order-restaurant', ['categories' => $categories, 'foods' => $foods, 'restaurant' => $restaurant]);
    }
    public function getRestaurants()
    {
        $restaurants = DB::table('restaurant')->orderBy('name', 'asc')->get();

        $filterdRestaurants = $restaurants->map(function ($restaurant) {
            return (object) [
                'restaurant_id' => $restaurant->restaurant_id,
                'name' => $restaurant->name,
                'email' => $restaurant->email,
                'phone_number' => $restaurant->phone_number,
                'logo' => $restaurant->logo,
                'created_at' => $restaurant->created_at,
            ];
        });
        return $filterdRestaurants;
    }

    public function getCart(Request $request)
    {
        $cart = $request->cookie("cart");
        if (!isset($cart)) {
            return view('cart', ['restaurant' => null, 'foods' => null]);
        }
        $cart = json_decode($cart);

        $restaurant = DB::table('restaurant')->where('restaurant_id', $cart->restaurantID)->take(1)->get(['name', 'logo']);
        $restaurant = $restaurant[0];

        $foods = [];
        foreach ($cart->foodObjects as $foodObject) {
            $food = DB::table('food')->where('food.food_id', $foodObject->id)->join('category', 'category.category_id', 'food.category_id')->first();
            $food->quantity = $foodObject->quantity;
            array_push($foods, $food);
        }

        return view('cart', ['restaurant' => $restaurant, 'foods' => $foods]);
    }

    public function buyerCheckout(Request $request){
        
        $json_cart = json_decode($_COOKIE['cart']);
        $buyer_id = Auth::guard('buyer')->user()->buyer_id;

        $saveOrderId = DB::table('orders')->insertGetId([
            'buyer_id' => $buyer_id,
            'total' => $json_cart->totalPrice
        ]);
        if (count($json_cart->foodObjects) > 0) {
            foreach ($json_cart->foodObjects as $food) {
                $saveOrderFood = DB::table('orderedFood')->insert([
                    'food_id' => $food->id,
                    'order_id' => $saveOrderId,
                    'food_quantity' => $food->quantity
                ]);
            }
        }
        Cookie::queue(Cookie::forget('cart'));
        
        return redirect('/buyer/receipt');
    }

    public function getReceipt()
    {
        return view('buyer.receipt');
    }
}