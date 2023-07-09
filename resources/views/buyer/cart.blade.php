@extends('layout.master')

@section('pageTitle', 'Order Page')

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
            <h1 style="text-align: center;margin-bottom: 2rem;">Cart</h1>
            @if ($restaurant == null)
                <h2>Cart is empty</h2>
            @else
                <ul class="cart">
                    <li>No.</li>
                    <li>Name</li>
                    <li>Quantity</li>
                    <li>Unit Price</li>
                    <li />
                    @foreach ($foods as $food)
                        <li>{{ $loop->index + 1 }}</</li>
                        <li>{{ $food->name }}</li>
                        <li><input type="number" value="{{$food->quantity}}" min="1" onchange="updateQuantity({{ $food->food_id }})" class="quantity" /></li>
                        <li id="food-{{$food->food_id}}-price" class="price">
                            @php
                                $price = $food->price;
                                $price = number_format($price, 2, '.', ',');
                                echo '$' . $price;
                            @endphp
                        </li>
                        <li><a href="" onclick="removeFromCart({{$food->food_id}})" class="remove-item">Remove</a></li>
                    @endforeach
                    <li>Total:</li>
                    <li id="total-price">
                        @php
                            $total = 0;
                            foreach ($foods as $food) {
                                $total += $food->price * $food->quantity;
                            }
                            $total = number_format($total, 2, '.', ',');
                            echo '$' . $total;
                        @endphp
                    </li>
                    <li />
                </ul>
                <form action="/buyer/buyerCheckout" method="post" enctype="multipart/form-data">
                    @csrf
                <div style="display: flex;justify-content: end">
                    <button class="checkout">Check Out</button>
                </div>
                </form>
            @endif
        </main>
    </div>
    <script src="/js/addtocart.js" defer></script>

@stop
