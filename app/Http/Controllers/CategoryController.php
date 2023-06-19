<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
    public function getCategories(Request $request) {
        $categories = DB::table('category')->where('restaurant_id', Auth::guard('restaurant')->user()->restaurant_id)->get();
        return view('restaurant.categories');
        return view('restaurant.categories', ['categories' => $categories]);
    }

    public function addCategory(Request $request) {
        $request->validate([
            'category_name' => "required|array|",
            'category_name.*' => 'required|string|distinct'
        ]);

        $categories = $request->category_name;
        $restaurant_id = Auth::guard('restaurant')->user()->restaurant_id;
        foreach($categories as $category) {
            $insert = DB::table('category')->insert([
                'category_name' => $category,
                'restaurant_id' => $restaurant_id,
            ]);
            if (!$insert) {
                return redirect()->back()->with('error', 'Error adding category');
            }
        }
        return redirect('/restaurant');
    }
}
