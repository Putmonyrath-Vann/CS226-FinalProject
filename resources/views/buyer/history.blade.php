@extends('layout.master')

@section('pageTitle', 'History')

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
                    <button class="logout">Log Out</button>
                </form>
            </div>
        </nav>
        <main class="container" style="color:white">
            <h1 style="text-align: center;margin-bottom: 2rem;">History</h1>
            @if (count($orders) == 0)
                <h2>No Items</h2>
            @else
                <ul class="history">
                    @foreach ($orders as $order)
                        <li>
                            <div>
                                <img src={{$order->logo}} alt="" />
                                <h2>{{$order->restaurant_name}}</h2>
                            </div>
                            <div class="col-2">
                                <ul class="order-food-list">
                                    @for($i = 0; $i < count($order->food_name); $i++)
                                        <h3>{{$order->food_name[$i]}} x {{$order->quantity[$i]}}</h3>
                                    @endfor
                                </ul>
                                <h3>Total:
                                    @php
                                        $price = $order->total_price;
                                        $price = number_format($price, 2, '.', ',');
                                        echo '$' . $price;
                                    @endphp
                                </h3>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </main>
    </div>
@stop
