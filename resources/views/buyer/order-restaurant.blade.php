@extends('layout.master')

@section('pageTitle', 'Order')

@section('content')
    <div class="full-bg">
        <nav>
            <a href="/buyer"><h1>Paragon Eats</h1></a>
            <div class="right">
                <a href="/buyer/order">Order</a>
                <a href="/buyer/history">History</a>
                <a href="/buyer/cart">
                    <img src="/grocery-store.png" alt="" />
                </a>
                <form action="/logout" method="POST">
                    @csrf
                    <button class="/logout">Log Out</button>
                </form>
            </div>
        </nav>
        <main class="container">
            <div class="restaurant-info">
                <img src={{$restaurant->logo}} alt="" />
                <h1>{{$restaurant->name}}</h1>
            </div>
            @foreach($categories as $category)
                @php
                    $foods_in_category = $foods->filter(function($food) use ($category) {
                        return $food->category_id == $category->category_id;
                    })
                @endphp

                @if (count($foods_in_category) === 0)
                    @continue
                @endif

                <h1 style="color:white;font-size:1.6rem">
                    {{$category->category_name}}
                </h1>
                <ul class="foods-in-category">
                    @foreach($foods_in_category as $food)
                        @if ($restaurant_in_cart === $restaurant->restaurant_id && isset($foods_in_cart) && in_array($food->food_id, $foods_in_cart))
                            <li class="in-cart">
                                <img src="{{$food->img}}" alt="" />
                                <h3>{{ $food->name }}</h3>
                                <h3>
                                    @php
                                        $price = $food->price;
                                        $price = number_format($price, 2, '.', ',');
                                        echo '$' . $price;
                                    @endphp
                                </h3>
                            </li>
                        @else
                            <li onclick="addToCart({{$restaurant->restaurant_id}}, {{$food->food_id}})" id="food{{$food->food_id}}">
                                <img src="{{$food->img}}" alt="" />
                                <h3>{{ $food->name }}</h3>
                                <h3>
                                    @php
                                        $price = $food->price;
                                        $price = number_format($price, 2, '.', ',');
                                        echo '$' . $price;
                                    @endphp
                                </h3>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endforeach
        </main>
    </div>

    <script src="/js/addtocart.js" defer></script>
@stop
