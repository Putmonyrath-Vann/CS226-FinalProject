<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Driver;
use App\Models\Restaurant;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    //
    public function buyerSignUp(Request $request) {
        Auth::guard('buyer')->logout();
        Auth::guard('driver')->logout();
        Auth::guard('restaurant')->logout();
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:buyer,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'phone_number' => 'required',
            'gender' => 'required',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $email = $request->input('email');
        $email = strtolower(trim($email));
        $first_name = $request->input('first_name');
        $first_name = trim($first_name);
        $last_name = $request->input('last_name');
        $last_name = trim($last_name);

        $buyer = new Buyer();
        $buyer->first_name = $first_name;
        $buyer->last_name = $last_name;
        $buyer->email = $email;
        $buyer->password = Hash::make($request->input('password'));
        $buyer->phone_number = $request->input('phone_number');
        $buyer->gender = $request->input('gender');

        if ($request->has('profile_picture')) {
            $img_url = $this->uploadImage($request, 'profile_picture');
            $buyer->profile_img = $img_url;
        }

        $buyer->save();
        Auth::guard('buyer')->login($buyer, true);
        return redirect('/');
    }

    public function buyerLogin(Request $request) {
        Auth::guard('buyer')->logout();
        Auth::guard('driver')->logout();
        Auth::guard('restaurant')->logout();
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        if ($request->has('remember')) {
            $remember = 1;
        }
        else $remember = 0;

        if (Auth::guard('buyer')->attempt(['email' => $email, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect('/');
        }
        else return redirect('/login/buyer')->with(['unmatched' => ['Email and password do not match']]);
        // change needed
        // else redirect('/login');
    }

    public function driverSignup(Request $request) {
        Auth::guard('buyer')->logout();
        Auth::guard('driver')->logout();
        Auth::guard('restaurant')->logout();
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:driver,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'phone_number' => 'required',
            'gender' => 'required',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $email = $request->input('email');
        $email = strtolower(trim($email));
        $first_name = $request->input('first_name');
        $first_name = trim($first_name);
        $last_name = $request->input('last_name');
        $last_name = trim($last_name);

        $driver = new Driver();
        $driver->first_name = $first_name;
        $driver->last_name = $last_name;
        $driver->email = $email;
        $driver->password = Hash::make($request->input('password'));
        $driver->phone_number = $request->input('phone_number');
        $driver->gender = $request->input('gender');

        if ($request->has('profile_picture')) {
            $img_url = $this->uploadImage($request, 'profile_picture');
            $driver->profile_picture = $img_url;
        }

        $driver->save();
        Auth::guard('driver')->login($driver, true);
        return redirect('/');
    }

    public function driverLogin(Request $request) {
        Auth::guard('buyer')->logout();
        Auth::guard('driver')->logout();
        Auth::guard('restaurant')->logout();
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        if ($request->has('remember')) {
            $remember = 1;
        }
        else $remember = 0;

        if (Auth::guard('driver')->attempt(['email' => $email, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect('/');
        }
        else return redirect()->back()->withErrors(['unmatched' => 'Email and password do not match']);
        // change needed
        // else redirect('/signup');
    }

    public function restaurantSignUp(Request $request) {
        Auth::guard('buyer')->logout();
        Auth::guard('driver')->logout();
        Auth::guard('restaurant')->logout();

       $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:restaurant,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'phone_number' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $email = $request->input('email');
        $email = strtolower(trim($email));
        $name = $request->input('name');
        $name = trim($name);

        $restaurant = new Restaurant();
        $restaurant->name = $name;
        $restaurant->email = $email;
        $restaurant->password = Hash::make($request->input('password'));
        $restaurant->phone_number = $request->input('phone_number');

        $logo_url = $this->uploadImage($request, 'logo');
        $restaurant->logo = $logo_url;

        $restaurant->save();
        Auth::guard('restaurant')->login($restaurant, true);
        return redirect('/');
    }

    public function restaurantLogin(Request $request) {
        Auth::guard('buyer')->logout();
        Auth::guard('driver')->logout();
        Auth::guard('restaurant')->logout();
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        if ($request->has('remember')) {
            $remember = 1;
        }
        else $remember = 0;

        if (Auth::guard('restaurant')->attempt(['email' => $email, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect('/');
        }
        else return redirect('/login/restaurant')->with(['unmatched' => ['Email and password do not match']]);
    }

    public function logout(Request $request) {
        Auth::guard('driver')->logout();
        Auth::guard('buyer')->logout();
        Auth::guard('restaurant')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Cookie::queue(Cookie::forget('cart'));
        return redirect('/login');
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
