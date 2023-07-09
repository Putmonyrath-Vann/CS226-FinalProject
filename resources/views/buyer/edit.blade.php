@extends('layout.master')

@section('styles')
    <link rel="stylesheet" href="/css/edit.css">
@stop

@section('pageTitle', 'Edit Personal Information')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger" style="margin: 10px 0px 0px 0px;">
            <ul style="margin: 0px;">
                @foreach ($errors->all() as $error)
                    <li style="list-style: none;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <script>
            alert("{{session('success')}}")
        </script>
    @endif
    <h1>Edit Personal Information</h1>
    <form action="/buyer/edit/profile" method="post" id="form">
        @csrf
        <div class="profile-picture-row">
            <div class="profile-picture-wrapper">
                <img src="{{isset($buyer->profile_img) ? $buyer->profile_img : '/user.png'}}" class="profile-picture" id="img" />
                <label for="profile_img" class="label">Change Picture</label>
                <input type="file" name="profile_img" id="profile_img" style="display: none;" accept="image/png, image/jpeg" onchange="updateImage({{$buyer->buyer_id}})">
            </div>

        </div>
        <div class="input-row">
            <label>First Name: </label>
            <input class="input" type="text" name="first_name" value="{{$buyer->first_name}}">
        </div>
        <div class="input-row">
            <label>Last Name: </label>
            <input class="input" type="text" name="last_name" value="{{$buyer->last_name}}">
        </div>
        <div class="input-row">
            <label>Email: </label>
            <input class="input" type="email" name="email" value="{{$buyer->email}}">
        </div>
        <div class="input-row">
            <label onclick="togglePassword()">Password: </label>
            <input class="input password" type="password" name="password" placeholder="Enter Your New Password" class=>
        </div>
        <div class="input-row">
            <label onclick="togglePassword()">Confirm Password: </label>
            <input class="input password" type="password" name="confirm_password" placeholder="Enter Your New Password">
        </div>
        <div class="input-row">
            <label>Phone Number: </label>
            <input class="input" type="text" name="phone_number" value="{{$buyer->phone_number}}" placeholder="Phone Number">
        </div>
        <div class="input-row">
            <label>Building Number: </label>
            <input class="input" type="text" name="building_no" value="{{$buyer->building_no}}" placeholder="Building Number">
        </div>
        <div class="input-row">
            <label>Street Number: </label>
            <input class="input" type="text" name="street_no" value="{{$buyer->street_no}}" placeholder="Street Number">
        </div>
        <div class="input-row">
            <label>Region: </label>
            <select class="input" name="region">
                <option value=''>Select Region</option>
                @foreach ($regions as $region)
                    <option value="{{$region->region_id}}" {{$region->region_id == $buyer->region_id ? 'selected' : ''}}>{{$region->region_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="input-row" style="align-items: self-start;">
            <label>Address Description: </label>
            <textarea class="input input-textarea" type="text" name="description" placeholder="Write Your Address Description Here">{{$buyer->description}}</textarea>
        </div>

        <button class="save-btn" id="submit" onclick="submit()">Save</button>
    </form>

    <script src="/js/editProfile.js" defer></script>
@stop