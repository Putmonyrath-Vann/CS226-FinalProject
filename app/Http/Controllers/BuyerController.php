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

        $cart = $request->cookie("cart");
        // dd($cart);
        // dd(!isset($cart));
        // dd(!property_exists($cart, 'restaurant'));
        if (!isset($cart)) {
            return view('buyer.order-restaurant', ['categories' => $categories, 'foods' => $foods, 'restaurant' => $restaurant, 'restaurant_in_cart' => null, 'foods_in_cart' => null]);
        }
        $cart = json_decode($cart);

        if (!property_exists($cart, 'restaurantID') || !property_exists($cart, 'foodObjects')) {
            Cookie::queue(Cookie::forget('cart'));
        }

        $foods_in_cart = [];
        foreach ($cart->foodObjects as $foodObject) {
            array_push($foods_in_cart, $foodObject->id);
        }

        return view('buyer.order-restaurant', ['categories' => $categories, 'foods' => $foods, 'restaurant' => $restaurant, 'restaurant_in_cart' => $cart->restaurantID, 'foods_in_cart' => $foods_in_cart]);
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
            return view('buyer.cart', ['restaurant' => null, 'foods' => null]);
        }
        $cart = json_decode($cart);

        if (!property_exists($cart, 'restaurantID') || !property_exists($cart, 'foodObjects')) {
            Cookie::queue(Cookie::forget('cart'));
            return view('buyer.cart', ['restaurant' => null, 'foods' => null]);
        }

        $restaurant = DB::table('restaurant')->where('restaurant_id', $cart->restaurantID)->take(1)->get(['name', 'logo']);
        $restaurant = $restaurant[0];

        $foods = [];
        foreach ($cart->foodObjects as $foodObject) {
            $food = DB::table('food')->where('food.food_id', $foodObject->id)->join('category', 'category.category_id', 'food.category_id')->first();
            $food->quantity = $foodObject->quantity;
            array_push($foods, $food);
        }

        return view('buyer.cart', ['restaurant' => $restaurant, 'foods' => $foods]);
    }

    public function buyerCheckout(Request $request){

        $cart = $request->cookie('cart');

        if (!isset($cart)) {
            return redirect('/buyer/order');
        }

        $cart = json_decode($cart);

        if (!property_exists($cart, 'restaurantID') || !property_exists($cart, 'foodObjects') || count($cart->foodObjects) < 0) {
            Cookie::queue(Cookie::forget('cart'));
            return redirect('/buyer/order');
        }

        $buyer_id = Auth::guard('buyer')->user()->buyer_id;

        $total_price = 0;
        foreach ($cart->foodObjects as $foodObject) {
            $food = DB::table('food')->where('food.food_id', $foodObject->id)->first();
            $total_price += $food->price * $foodObject->quantity;
        }

        $order_id = DB::table('order')->insertGetId(['buyer_id' => $buyer_id,'restaurant_id' => $cart->restaurantID, 'total_price' => $total_price, 'created_at' => Carbon::now()]);

        if (count($cart->foodObjects) > 0) {
            foreach ($cart->foodObjects as $food) {
                $order_info = DB::table('order_info')->insert([
                    'order_id' => $order_id,
                    'food_id' => $food->id,
                    'quantity' => $food->quantity,
                    'created_at' => Carbon::now()
                ]);
            }
        }

        Cookie::queue(Cookie::forget('cart'));
        return redirect('/buyer/receipt/'.$order_id);
    }

    public function getReceipt(Request $request, $id)
    {
        $order_info = DB::table('order_info')->join('food', 'order_info.food_id', 'food.food_id')->where('order_id', $id)->get();

        $order = DB::table('order')->join('buyer', 'buyer.buyer_id', 'order.buyer_id')->join('restaurant', 'restaurant.restaurant_id', 'order.restaurant_id')->where('order_id', $id)->select(['order.order_id', 'order.total_price', 'order.created_at', 'buyer.buyer_id', 'buyer.first_name AS buyer_first_name', 'buyer.last_name AS buyer_last_name', 'buyer.phone_number AS buyer_phone_number', 'restaurant.restaurant_id', 'restaurant.name AS restaurant_name', 'restaurant.phone_number AS restaurant_phone_number'])->first();

        return view('buyer.receipt', ['order' => $order, 'order_info' => $order_info]);
    }

    public function getHistory(Request $request) {
        $buyer_id = Auth::guard('buyer')->user()->buyer_id;

        $history = DB::table('order')->join('order_info', 'order_info.order_id', 'order.order_id')->join('food', 'food.food_id', 'order_info.food_id')->join('restaurant', 'restaurant.restaurant_id', 'order.restaurant_id')->where('buyer_id', $buyer_id)->select(['order.order_id', 'order.total_price', 'restaurant.name AS restaurant_name', 'restaurant.logo', 'order.created_at', DB::raw('GROUP_CONCAT(food.name) AS food_name'), DB::raw('GROUP_CONCAT(food.price) AS food_price'), DB::raw('GROUP_CONCAT(order_info.quantity) AS quantity')])->groupBy('order.order_id')->orderBy('order.created_at', 'desc')->get();

        foreach($history as $order) {
            $order->food_name = explode(',', $order->food_name);
            $order->food_price = explode(',', $order->food_price);
            $order->quantity = explode(',', $order->quantity);
        }

        return view('buyer.history', ['history' => $history]);
    }

    public function getEditPage() {
        $buyer_id = Auth::guard('buyer')->user()->buyer_id;
        $buyer = DB::table('buyer')->leftJoin('address', 'address.address_id', 'buyer.address_id')->where('buyer.buyer_id', $buyer_id)->select(['buyer.first_name', 'buyer.last_name', 'buyer.email', 'buyer.phone_number', 'buyer.profile_img', 'address.building_no', 'address.street_no', 'address.region_id', 'address.description'])->first();

        $regions = DB::table('region')->orderBy('region_name')->get();

        return view('buyer.edit', ['buyer' => $buyer, 'regions' => $regions]);
    }
}