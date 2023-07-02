@extends('layout.master')

@section('styles')
    <link rel="stylesheet" href="/css/edit.css">
@stop

@section('pageTitle', 'Edit Personal Information')

@section('content')
    <h1>Edit Personal Information</h1>
    <form action="/edit" method="post">
        <div class="profile-picture-row">
            <div class="profile-picture-wrapper">
                <img src="{{isset($buyer->profile_img) ? $buyer->profile_img : '/user.png'}}" class="profile-picture" />
                <label for="profile_img" class="label">Change Picture</label>
                <input type="file" name="profile_img" id="profile_img" style="display: none;" accept="image/png, image/jpeg">
            </div>

        </div>
        <div class="input-row">
            <label>First Name: </label>
            <input class="input" type="text" name="first_name" value="{{$buyer->first_name}}">
        </div>
        <div class="input-row">
            <label>Last Name: </label>
            <input class="input" type="text" name="phone_number" value="{{$buyer->last_name}}">
        </div>
        <div class="input-row">
            <label>Email: </label>
            <input class="input" type="email" name="email" value="{{$buyer->email}}">
        </div>
        <div class="input-row">
            <label>Password: </label>
            <input class="input" type="password" name="password" placeholder="Enter Your New Password">
        </div>
        <div class="input-row">
            <label>Confirm Password: </label>
            <input class="input" type="password" name="confirm_assword" placeholder="Enter Your New Password">
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
                <option>Select Region</option>
                @foreach ($regions as $region)
                    <option value="{{$region->region_id}}" {{$region->region_id == $buyer->region_id ? 'selected' : ''}}>{{$region->region_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="input-row">
            <label>Address Description: </label>
            <textarea class="input" type="text" name="description" value="{{$buyer->description}}" placeholder="Write Your Address Description Here"></textarea>
        </div>

    </form>
@stop