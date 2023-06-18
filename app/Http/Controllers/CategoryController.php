<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function getCategories(Request $request) {
        $categories = array((object)['id' => 1, 'name' => 'Pizza'], (object)['id' => 2, 'name' => 'Burger'], (object)['id' => 3, 'name' => 'Pasta']);
        // dd($categories);
        return view('restaurant.categories');
        return view('restaurant.categories', ['categories' => $categories]);
    }
}
