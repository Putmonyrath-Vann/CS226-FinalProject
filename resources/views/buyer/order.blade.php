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
                    <button class="logout">Log Out</button>
                </form>
            </div>
        </nav>
        <main class="container">
            <h1 style="color:white">Restaurants</h1>
            <ul class="restaurant-list">
                @foreach($restaurants as $restaurant)
                    <a href="/buyer/order/{{$restaurant->restaurant_id}}">
                        <img src={{$restaurant->logo}} alt="" />
                        <h3>{{$restaurant->name}}</h3>
                    </a>
                @endforeach
            </ul>
        </main>
    </div>
@stop
