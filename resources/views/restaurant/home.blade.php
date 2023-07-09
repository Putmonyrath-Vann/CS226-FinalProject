@extends('layout.master')

@section('pageTitle', 'Restaurant Page')

@section('content')
    <script>
    </script>

    <div class="full-bg">
        <nav>
            <a href="/restaurant"><h1>Paragon Eats</h1></a>
            <div class="right">
                <a href="/restaurant/categories">Categories</a>
                <a href="/restaurant/food">Food</a>
                <a href="/restaurant/edit">Edit Info</a>
                <form action="/logout" method="POST">
                    @csrf
                    <button class="logout">Log Out</button>
                </form>
            </div>
        </nav>
        <main class="container" style="color:white">
            <h1 style="text-align: center;margin-bottom: 2rem;">Recent Orders</h1>
            @if (count($orders) == 0)
                <h2>No Orders</h2>
            @else
                <ul class="recent-orders">
                    <li>
                        <h3>Order ID</h3>
                        <h3>Buyer's Name</h3>
                        <h3>Total</h3>
                        <h3>Ordered At</h3>
                    </li>
                    @foreach ($orders as $order)
                        <li>
                            <h3>{{$order->order_id}}</h3>
                            <h3>{{$order->buyer_first_name}} {{$order->buyer_last_name}}</h3>
                            <h3>
                                @php
                                    $price = $order->total_price;
                                    $price = number_format($price, 2, '.', ',');
                                    echo '$' . $price;
                                @endphp
                            </h3>
                            <h3>{{$order->created_at}}</h3>
                        </li>
                    @endforeach
                </ul>
            @endif
        </main>
    </div>
@stop
