<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    public function restaurantHome(Request $request) {
        $restaurant_id = Auth::guard('restaurant')->user()->restaurant_id;

        // $orders = DB::table('order')->join('order_info', 'order_info.order_id', 'order.order_id')->join('food', 'food.food_id', 'order_info.food_id')->join('restaurant', 'restaurant.restaurant_id', 'order.restaurant_id')->join('buyer', 'buyer.buyer_id', 'order.buyer_id')->where('restaurant.restaurant_id', $restaurant_id)->select(['order.order_id', 'order.total_price', 'restaurant.name AS restaurant_name', 'restaurant.logo', 'order.created_at', 'buyer.first_name AS buyer_first_name', 'buyer.last_name AS buyer_last_name'])->orderBy('order.created_at', 'desc')->get();

        $orders = DB::select('SELECT * from orders_view WHERE restaurant_id = '.$restaurant_id.';');

    // dd($orders);
        return view('restaurant.home', ['orders' => $orders]);
    }
    //
    public function getCategories(Request $request) {
        $categories = DB::select('CALL get_categories('.Auth::guard('restaurant')->user()->restaurant_id.');');
        return view('restaurant.categories', ['categories' => $categories]);
        // return view('restaurant.categories');
    }

    public function addCategory(Request $request) {
        $request->validate([
            'category_name' => "required|string|max:20"
        ]);

        $category_name = $request->category_name;
        $restaurant_id = Auth::guard('restaurant')->user()->restaurant_id;

       $existingCategories = DB::select('CALL get_categories('.Auth::guard('restaurant')->user()->restaurant_id.');');

       $alreadyExists = false;
        foreach ($existingCategories as $existingCategory) {
            if (strtolower($existingCategory->category_name) == strtolower($category_name)) {
                $alreadyExists = true;
                break;
            }
        }

        if ($alreadyExists) {
            return redirect()->back()->with('error', 'Category already exists');
        }

        $category = DB::table('category')->insert([
            'category_name' => $category_name,
            'restaurant_id' => $restaurant_id,
        ]);
        return redirect()->back();
    }

    public function removeCategory(Request $request) {
        $id = $request->id;
        if (Auth::guard('restaurant')->user()->restaurant_id != DB::table('category')->where('category_id', $id)->first()->restaurant_id) {
            return redirect()->back()->with('error', 'Error deleting category');
        }
        $category = DB::table('category')->where('category_id', $id)->delete();
        return redirect('/restaurant/categories');
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
        $foods = DB::select('CALL get_food('.Auth::guard('restaurant')->user()->restaurant_id.');');
        $categories = DB::select('CALL get_categories('.Auth::guard('restaurant')->user()->restaurant_id.');');

        return view('restaurant.food', ['foods' => $foods, 'categories' => $categories]);
    }

    public function addFood(Request $request) {
        $validator = Validator::make($request->all(), [
            'food_name' => "required|string|max:30",
            'food_price' => "required|numeric|",
            'food_category' => "required|integer|",
            'food_image' => "required|image|mimes:jpeg,png,jpg,gif|max:1500",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $name = $request->food_name;
        $price = $request->food_price;
        $category = $request->food_category;
        $restaurant_id = Auth::guard('restaurant')->user()->restaurant_id;

        $link = $this->uploadImage($request, 'food_image');
        $name = trim($name);

        $food = DB::table('food')->insert([
            'name' => $name,
            'price' => $price,
            'category_id' => $category,
            'img' => $link,
            'restaurant_id' => $restaurant_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if (!$food) {
            return redirect()->back()->with('error', 'Error adding food');
        }

        return redirect()->back();
    }

    public function removeFood(Request $request) {
        $id = $request->id;
        if (Auth::guard('restaurant')->user()->restaurant_id != DB::table('food')->where('food_id', $id)->first()->restaurant_id) {
            return redirect()->back()->with('error', 'Error deleting food');
        }
        $delete = DB::table('food')->where('food_id', $id)->delete();
        if (isset($delete)) {
            return redirect()->back()->with('success', 'Food deleted successfully');
        }
        return redirect()->back()->with('error', 'Error deleting food');
    }

    public function getEditPage(Request $request) {
        $restaurant_id = Auth::guard('restaurant')->user()->restaurant_id;
        $restaurant = DB::table('restaurant')->leftJoin('address', 'address.address_id', 'restaurant.address_id')->where('restaurant.restaurant_id', $restaurant_id)->select(['restaurant.restaurant_id', 'restaurant.name', 'restaurant.email', 'restaurant.phone_number', 'restaurant.logo', 'address.building_no', 'address.street_no', 'address.region_id', 'address.description'])->first();

        $regions = DB::table('region')->orderBy('region_name')->get();

        return view('restaurant.edit', ['restaurant' => $restaurant, 'regions' => $regions]);
    }

    public function editProfile(Request $request) {
        $restaurant = Auth::guard('restaurant')->user();
        // dd($request);
        $rules = [
            'name' => 'required|string|max:30',
            'phone_number' => 'required',
            'password' => 'nullable|required_with:confirm_assword|min:8',
            'confirm_password' => 'nullable|required_with:password|same:password|min:8',
            'building_no' => 'nullable|required_with:street_no,region,description|string|max:10',
            'street_no' => 'nullable|required_with:building_no,region,description|string|max:10',
            'region' => 'nullable|required_with:street_no,building_no,description|integer',
            'description' => 'nullable|string|max:255'
        ];

        if ($restaurant->email != $request->input('email')) {
            $rules['email'] = 'required|email|unique:restaurant,email';
        }

        $request->validate($rules);

        $restaurant_id = Auth::guard('restaurant')->user()->restaurant_id;
        $name = $request->input('name');
        $phone_number = $request->input('phone_number');
        $email = $request->input('email');

        // if password is not empty, then update password
        if ($request->input('password') != null) {
            $password = Hash::make($request->input('password'));
            DB::table('restaurant')->where('restaurant_id', $restaurant_id)->update(['password' => $password]);
        }

        if ($request->hasFile('logo')) {
            $link = $this->uploadImage($request, 'logo');
            DB::table('restaurant')->where('restaurant_id', $restaurant_id)->update(['logo' => $link]);
        }

        DB::table('restaurant')->where('restaurant_id', $restaurant_id)->update([
            'name' => $name,
            'phone_number' => $phone_number,
            'email' => $email,
        ]);

        $address_id = $restaurant->address_id;
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
                DB::table('restaurant')->where('restaurant_id', $restaurant_id)->update(['address_id' => $address_id]);
            }
        }

        return redirect()->back()->with('success', 'Profile updated successfully');

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
            'verify' => false
            ]);
        $img_link =  json_decode($response->getBody()->getContents())->data->link;
        return $img_link;
    }
}
