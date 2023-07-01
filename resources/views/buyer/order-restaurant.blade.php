@extends('layout.master')

@section('styles')
    <link rel="stylesheet" href="/css/buyer.css">
@stop

@section('pageTitle', 'Order Page')

@section('content')
    <div class="restaurant-heading">
        <img src="{{$restaurant->logo}}" class="heading-logo"/>
        <p class="heading-text">{{$restaurant->name}}</p>
    </div>

    @foreach($categories as $category)
        @php
            $foods_in_category = $foods->filter(function($food) use ($category) {
                return $food->category_id == $category->category_id;
            })
        @endphp

        @if ($foods_in_category->count() === 0)
            @continue
        @endif

        <h1>{{$category->category_name}}</h1>

        <div class="all-foods-in-category">
        @foreach($foods_in_category as $food_in_category)
            <div class="food-in-category" data-foodid="{{$food_in_category->food_id}}">
                <img src="{{$food_in_category->img}}" class="food-in-category-image"/>
                <p class="food_in_category_text food_name">{{ $food_in_category->name }}</p>
                <p class="food_in_category_text food_price">
                    @php
                        $price = $food_in_category->price;
                        $price = number_format($price, 2, '.', ',');
                        echo '$' . $price;
                    @endphp
                    @if ($restaurant_in_cart === $restaurant->restaurant_id && isset($foods_in_cart) && in_array($food_in_category->food_id, $foods_in_cart))
                        <img src="/images/check-mark.png" class="tick"/>
                    @endif
                </p>
                <div class="cart-row" onclick="addToCart({{$restaurant->restaurant_id}}, {{$food_in_category->food_id}})">
                    <img src="/shopping-cart.png" class="cart-image"/>
                </div>
            </div>

        @endforeach
        </div>

    @endforeach

    <script src="/js/addtocart.js" defer></script>
@stop
