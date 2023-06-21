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
            <p>{{$category->category_name}}</p>

        @foreach($foods_in_category as $food_in_category)
            <p>{{$food_in_category->name}}<p>
        @endforeach

    @endforeach
@stop
