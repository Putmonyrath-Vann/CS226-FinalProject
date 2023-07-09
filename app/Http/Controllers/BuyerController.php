<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
        $buyer = DB::table('buyer')->leftJoin('address', 'address.address_id', 'buyer.address_id')->where('buyer.buyer_id', $buyer_id)->select(['buyer.buyer_id', 'buyer.first_name', 'buyer.last_name', 'buyer.email', 'buyer.phone_number', 'buyer.profile_img', 'address.building_no', 'address.street_no', 'address.region_id', 'address.description'])->first();

        $regions = DB::table('region')->orderBy('region_name')->get();

        return view('buyer.edit', ['buyer' => $buyer, 'regions' => $regions]);
    }

    public function editProfile(Request $request) {
        $buyer = Auth::guard('buyer')->user();
        // dd($request);
        $rules = [
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'phone_number' => 'required',
            'password' => 'nullable|required_with:confirm_assword|min:8',
            'confirm_password' => 'nullable|required_with:password|same:password|min:8',
            'building_no' => 'nullable|required_with:street_no,region,description|string|max:10',
            'street_no' => 'nullable|required_with:building_no,region,description|string|max:10',
            'region' => 'nullable|required_with:street_no,building_no,description|integer',
            'description' => 'nullable|string|max:255'
        ];

        if ($buyer->email != $request->input('email')) {
            $rules['email'] = 'required|email|unique:buyer,email';
        }

        $request->validate($rules);

        $buyer_id = Auth::guard('buyer')->user()->buyer_id;
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $phone_number = $request->input('phone_number');
        $email = $request->input('email');

        // if password is not empty, then update password
        if ($request->input('password') != null) {
            $password = Hash::make($request->input('password'));
            DB::table('buyer')->where('buyer_id', $buyer_id)->update(['password' => $password]);
        }

        DB::table('buyer')->where('buyer_id', $buyer_id)->update([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone_number' => $phone_number,
            'email' => $email,
        ]);

        $address_id = $buyer->address_id;
        if (isset($address_id)) {
            DB::table('address')->where('address_id', $address_id)->update([
                'building_no' => $request->input('building_no'),
                'street_no' => $request->input('street_no'),
                'region_id' => $request->input('region'),
                'description' => $request->input('description'),
            ]);
        }

        else {
            if ($request->input('building_no') != null) {
                $address_id = DB::table('address')->insertGetId([
                    'building_no' => $request->input('building_no'),
                    'street_no' => $request->input('street_no'),
                    'region_id' => $request->input('region'),
                    'description' => $request->input('description'),
                ]);
                DB::table('buyer')->where('buyer_id', $buyer_id)->update(['address_id' => $address_id]);
            }
        }

        return redirect()->back()->with('success', 'Profile updated successfully');

    }

    public function updateProfileImage(Request $request) {
        $buyer_id = $request->input('buyer_id');
        // return response()->json(['buyer_id' => $request->input(), 'profile_img' => $request->file('profile_img')]);

        $request->validate([
            'profile_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $profile_img_url = $this->uploadImage($request, 'profile_img');
        DB::table('buyer')->where('buyer_id', $buyer_id)->update(['profile_img' => $profile_img_url]);
        return response()->json(['img_url' => $profile_img_url]);
    }

    public function uploadImage(Request $request, string $fileName) {
        $image = $request->file($fileName);
        $client = new Client();
        $response = $client->request('POST', 'https://api.imgur.com/3/image', [
            'headers' => [
                    'authorization' => 'Client-ID ' . env('imgur_client_id'),
                    'content-type' => 'application/x-www-form-urlencoded',
                ],
            'form_params' => [
                    'image' => base64_encode(file_get_contents($image))
                ],
            ]);
        $img_link =  json_decode($response->getBody()->getContents())->data->link;
        return $img_link;
    }
}