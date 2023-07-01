@extends('layout.master')

@section('styles')
    <link rel="stylesheet" href="/css/receipt.css">
@stop

@section('pageTitle', 'Receipt')

@section('content')
    <h2 class="heading-receipt">Order History</h2>
    @foreach ($history as $order)
    <div class="order-history">
        <div class="restaurant-info" onclick="showReceipt({{$order->order_id}})">
            <img src="{{$order->logo}}" class="logo"/>
            <div class="name-side">
                <p class="restaurant-name">{{$order->restaurant_name}}</p>
                <p class="order-time">Ordered At: {{$order->created_at}}</p>
                <ul class="order-food-list">
                    @for($i = 0; $i < count($order->food_name); $i++)
                        <li>{{$order->quantity[$i]}}x {{$order->food_name[$i]}}</li>
                    @endfor
                </ul>
            </div>
            <p class="order-price">
                @php
                $price = $order->total_price;
                $price = number_format($price, 2, '.', ',');
                echo '$' . $price;
            @endphp</p>
        </div>
    </div>
    @endforeach

    <script>
        function showReceipt(id) {
            window.location.href = "/buyer/receipt/" + id;
        }
    </script>
@stop
