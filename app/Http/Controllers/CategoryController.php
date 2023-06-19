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
        return redirect('/restaurant');
    }

    public function deleteCategory(Request $request) {
        $id = $request->id;
        $delete = DB::table('category')->where('category_id', $id)->delete();
        if (isset($delete)) {
            return redirect()->back()->with('success', 'Category deleted successfully');
        }
        return redirect()->back()->with('error', 'Error deleting category');
    }
}
