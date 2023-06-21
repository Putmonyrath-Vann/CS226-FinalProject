@extends('layout.master')

@section('styles')
    <link rel="stylesheet" href="/css/buyer.css">
@stop

@section('pageTitle', 'Order Page')

@section('content')
    <h1>Restaurants</h1>
    <div class="width-70">
        {{-- {{$restaurants}} --}}
        @foreach($restaurants as $restaurant)
            <div class="restaurant-row">
                <div class="logo">
                    <img src="{{$restaurant->logo}}" />
                </div>
                <div class="restaurant-text">
                    <p class="restaurant-name">{{$restaurant->name}}</p>
                </div>
                <a href="/buyer/order/{{$restaurant->restaurant_id}}" class="ml-auto"><button class="order-btn">Order Now</button></a>
            </div>
        @endforeach
    </div>
@stop
