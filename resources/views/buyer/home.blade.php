@extends('layout.master')

@section('pageTitle', 'User Home Page')

@section('content')
    <div class="custom-shape-divider-top-1688805370">
        <svg
            data-name="Layer 1"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 1200 120"
            preserveAspectRatio="none"
        >
            <path
                d="M0,0V7.23C0,65.52,268.63,112.77,600,112.77S1200,65.52,1200,7.23V0Z"
                class="shape-fill"
            />
        </svg>
    </div>
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
    <main class="buyer-home">
        <a href="/buyer/order">
            <img src="/store.png" alt="" />
            Order Now
        </a>
        <a href="/buyer/edit">
            <img src="/user-avatar.png" alt="" />
            Edit Info
        </a>
    </main>

@stop
