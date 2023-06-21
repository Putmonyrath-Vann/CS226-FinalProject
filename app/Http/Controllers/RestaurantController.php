<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    //
    public function getCategories(Request $request) {
        $categories = DB::table('category')->where('restaurant_id', Auth::guard('restaurant')->user()->restaurant_id)->orderBy('category_id', 'asc')->get();
        return view('restaurant.categories', ['categories' => $categories]);
        return view('restaurant.categories');
    }

    public function addCategory(Request $request) {
        $request->validate([
            'category_name' => "required|array|",
            'category_name.*' => 'required|string|distinct'
        ]);

        $categories = $request->category_name;
        $restaurant_id = Auth::guard('restaurant')->user()->restaurant_id;
        foreach($categories as $category) {
            $category = trim($category);
            $insert = DB::table('category')->insert([
                'category_name' => $category,
                'restaurant_id' => $restaurant_id,
            ]);
            if (!$insert) {
                return redirect()->back()->with('error', 'Error adding category');
            }
        }
        return redirect()->back();
    }

         public function deleteCategory(Request $request) {
        $id = $request->id;
        $delete = DB::table('category')->where('category_id', $id)->delete();
        if (isset($delete)) {
            return redirect()->back()->with('success', 'Category deleted successfully');
        }
        return redirect()->back()->with('error', 'Error deleting category');
    }

    public function getFood(Request $request) {
        $foods = DB::table('food')->where('restaurant_id', Auth::guard('restaurant')->user()->restaurant_id)->orderBy('food_id', 'asc')->get();
        $categories = DB::table('category')->where('restaurant_id', Auth::guard('restaurant')->user()->restaurant_id)->orderBy('category_id', 'asc')->get();
        return view('restaurant.food', ['foods' => $foods, 'categories' => $categories]);
    }

    public function addFood(Request $request) {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'food_name' => "required|array|",
            'food_name.*' => 'required|string|distinct',
            'food_price' => "required|array|",
            'food_price.*' => 'required|numeric|distinct',
            'food_category' => "required|array|",
            'food_category.*' => 'required|integer|distinct',
            'food_image' => "required|array|",
            'food_image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:1500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $names = $request->food_name;
        $prices = $request->food_price;
        $categories = $request->food_category;
        $images = $request->food_image;
        $restaurant_id = Auth::guard('restaurant')->user()->restaurant_id;

        for ($i = 0; $i < count($names); $i++) {
            $names[$i] = trim($names[$i]);
            $link = $this->uploadImage($request, 'food_image.' . $i);

            $food = DB::table('food')->insert([
                'name' => $names[$i],
                'price' => $prices[$i],
                'category_id' => $categories[$i],
                'img' => $link,
                'restaurant_id' => $restaurant_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if (!$food) {
                return redirect()->back()->with('error', 'Error adding food');
            }
        }
        return redirect()->back();
    }

    public function deleteFood(Request $request) {
        $id = $request->id;
        $delete = DB::table('food')->where('food_id', $id)->delete();
        if (isset($delete)) {
            return redirect()->back()->with('success', 'Food deleted successfully');
        }
        return redirect()->back()->with('error', 'Error deleting food');
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
