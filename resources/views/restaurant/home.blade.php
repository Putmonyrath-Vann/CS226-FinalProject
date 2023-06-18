@extends('layout.masterrestaurant')

@section('styles')
    <link rel="stylesheet" href="/css/home.css">
@stop

@section('pageTitle', 'Restaurant Page')

@section('content')
    <div class="heading">
        <h1>Recent Orders</h1>
    </div>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Buyer's Name</th>
            <th>Total</th>
            <th>Ordered At</th>
        </tr>

        @for ($i = 0; $i < 20; $i++)
            <tr>
                <td>00001</td>
                <td>Eav Long Sok</td>
                <td>$20.00</td>
                <td>2023-06-18 22:03:12</td>
            </tr>
        @endfor
    </table>
@stop
