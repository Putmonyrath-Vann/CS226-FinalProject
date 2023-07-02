@extends('layout.master')

@section('styles')
    <link rel="stylesheet" href="/css/home.css">
@stop

@section('pageTitle', 'buyer\'s Page')

@section('content')
    <div class="heading">
        <a href="/buyer/order" class="homepage-btn-link"><button class="homepage-btn">Order Now</button></a>
        <a href="/buyer/edit" class="homepage-btn-link"><button class="homepage-btn">Edit Personal Information</button></a>
    </div>
@stop
