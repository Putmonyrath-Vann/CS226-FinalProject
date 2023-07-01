@extends('layout.master')

@section('styles')
    <link rel="stylesheet" href="/css/receipt.css">
@stop

@section('pageTitle', 'Receipt')

@section('content')
    <div class="receipt">
        <h2 class="receipt-heading">Receipt</h2>
        <div class="order">
            <p>Order No. :</p>
            <p class="text-end">{{ $order->order_id }}</p>
            <p>Restaurant :</p>
            <p class="text-end">{{ $order->restaurant_name }} (ID: {{$order->restaurant_id}})</p>
            <p>Phone Number :</p>
            <p class="text-end">{{ $order->restaurant_phone_number }}</p>
            <p>Buyer's Name :</p>
            <p class="text-end">{{ $order->buyer_first_name }} {{ $order->buyer_last_name }} (ID: {{$order->buyer_id}})</p>
            <p>Phone Number :</p>
            <p class="text-end">{{ $order->buyer_phone_number }}</p>
            <p>Ordered At :</p>
            <p class="text-end">{{ $order->created_at }}</p>
        </div>

        <div class="order-info">
            <p>No.</p>
            <p>Items</p>
            <p class="text-end">Price</p>

            @foreach($order_info as $index => $food)
                <p>{{ $index + 1 }}.</p>
                <p>{{$food->quantity}}x {{ $food->name }}</p>
                <p class="text-end">
                    @php
                        $price = number_format($food->price, 2, '.', ',');
                        echo '$' . $price .' x'. $food->quantity;
                    @endphp</p>
            @endforeach
        </div>

        <div class="order-summary">
            <p>Total :</p>
            <p class="text-end bold double-underline">@php
                $price = number_format($order->total_price, 2, '.', ',');
                echo '$' . $price;
            @endphp</p></p>
        </div>
    </div>
@stop
