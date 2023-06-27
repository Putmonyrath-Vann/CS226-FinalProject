@extends('layout.master')

@section('styles')
    <link rel="stylesheet" href="/css/buyer.css">
@stop

@section('pageTitle', 'Order Page')

@section('content')
    <h1>My Cart</h1>
    @if ($restaurant == null)
    <div class="empty-cart">
        <h2>Your cart is empty</h2>
    </div>

    @else
    <div class="cart-page">
        <div class="cart-page-restaurant">
            <img src="{{$restaurant->logo}}" class="cart-page-logo" />
            <h3>{{$restaurant->name}}</h3>
        </div>
        <div class="cart-items">
            <div class="cart-page-cart-row">
                <p>No.</p>
                <p>Name</p>
                <p>Quantity</p>
                <p>Unit Price</p>
            </div>
            @foreach ($foods as $food)
            <div class="cart-page-cart-row" id="item{{$food->food_id}}">
                <p>{{ $loop->index + 1 }}</p>
                <p>{{ $food->name }}</p>
                <input type="number" value="{{$food->quantity}}" min="1" onchange="updateQuantity({{$food->food_id}})" class="cart-page-quantity" />
                <p class="cart-page-price">
                    @php
                        $price = $food->price;
                        $price = number_format($price, 2, '.', ',');
                        echo '$' . $price;
                    @endphp
                </p>
                <img src="/trash-bin.png" class="remove-from-cart" onclick="removeFromCart({{$food->food_id}})"/>
            </div>
            @endforeach
            <div class="cart-page-total">
                <p>Total:</p>
                <p> </p>
                <p class="cart-page-total-price">
                    @php
                        $total = 0;
                        foreach ($foods as $food) {
                            $total += $food->price * $food->quantity;
                        }
                        $total = number_format($total, 2, '.', ',');
                        echo '$' . $total;
                    @endphp
                </p>
            </div>
            <div class="cart-page-checkout-row">
                {{-- checkout button using a tag and button tag--}}
                <a href="/buyer/check">
                    <button class="cart-page-checkout">Checkout</button>
                </a>
            </div>
        </div>
    </div>
    <script src="/js/addtocart.js" defer></script>
    @endif
@stop
