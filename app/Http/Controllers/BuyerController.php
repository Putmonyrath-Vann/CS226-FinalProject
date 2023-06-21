<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuyerController extends Controller
{
    //
    public function getDataForOrderPage(Request $request) {
        $restaurants = $this->getRestaurants();
        return view('buyer.order', ['restaurants' => $restaurants]);
    }

    public function getFoodInRestaurant(Request $request, $restaurant_id) {
        $categories = DB::table('category')->where('restaurant_id', $restaurant_id)->orderBy('category_id', 'asc')->get();

        $foods = DB::table('food')->where('restaurant_id', $restaurant_id)->orderBy('food_id', 'asc')->get();

        $restaurant = DB::table('restaurant')->where('restaurant_id', $restaurant_id)->first();

        $restaurant = (object)[
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
    public function getRestaurants() {
        $restaurants = DB::table('restaurant')->orderBy('name', 'asc')->get();

        $filterdRestaurants = $restaurants->map(function ($restaurant) {
            return (object)[
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
}
