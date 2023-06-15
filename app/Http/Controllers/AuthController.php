<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Driver;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function customerSignUp(Request $request) {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:buyer, email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'phone_number' => 'requried',
            'gender' => 'required',
            'pfp' => 'max:10240'
        ]);


        $buyer = new Buyer();
        $buyer->first_name = $request->input('first_name');
        $buyer->last_name = $request->input('last_name');
        $buyer->email = $request->input('email');
        $buyer->password = Hash::make($request->input('password'));
        $buyer->phone_number = $request->input('phone_number');
        $buyer->gender = $request->input('gender');

        if ($request->has('pfp')) {
            // dd($request->file('pfp'));
            dd($request);
            $img_url = $this->uploadImage($request);
            $buyer->profile_img = $img_url;
        }

        $buyer->save();
        $this->customerLogin($request);
    }

    public function customerLogin(Request $request) {
        $validation = Validator::make($request->all(), [
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
        else redirect('/signup/customer');
    }

    public function driverSignup(Request $request) {
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:buyer, email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'phone_number' => 'requried',
            'gender' => 'required',
            'pfp' => 'max:10240'
        ]);


        $driver = new Driver();
        $driver->first_name = $request->input('first_name');
        $driver->last_name = $request->input('last_name');
        $driver->email = $request->input('email');
        $driver->password = Hash::make($request->input('password'));
        $driver->phone_number = $request->input('phone_number');
        $driver->gender = $request->input('gender');

        if ($request->has('pfp')) {
            // dd($request->file('pfp'));
            $img_url = $this->uploadImage($request);
            $driver->profile_img = $img_url;
        }

        $driver->save();
        $this->driverLogin($request);
    }

    public function driverLogin(Request $request) {
        $validation = Validator::make($request->all(), [
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
        else redirect('/signup/driver');
    }

    public function logout(Request $request) {
        Auth::guard('driver')->logout();
        Auth::guard('buyer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login/customer');
    }

    public function uploadImage(Request $request) {
        $image = $request->file('pfp');
        // dd($image);
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
