@extends('layout.master')

@section('pageTitle', 'Restaurant Page')

@section('content')

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
        <main class="container">
            <h1 style="text-align: center;margin-bottom: 2rem;color:white">
                Your Food
            </h1>
            <ul class="foods-in-category">
                @foreach ($foods as $food)
                    <a onclick="
                        let confirmation = confirm('Are you sure you want to delete this food?');
                        if (confirmation) {
                            window.location.href = '/restaurant/remove/food/{{$food->food_id}}';
                        }
                    ">
                        <img src={{ $food->img }} alt="" />
                        <h3>{{ $food->name }}</h3>
                        <h3>
                            @php
                                foreach ($categories as $category) {
                                    if ($category->category_id == $food->category_id) {
                                        echo $category->category_name;
                                    }
                                }
                            @endphp
                        </h3>
                        <h3>
                            @php
                                $price = $food->price;
                                $price = number_format($price, 2, '.', ',');
                                echo '$' . $price;
                            @endphp
                        </h3>
                    </a>
                @endforeach
            </ul>
            <form class="new-category" action="/restaurant/add/food" method="POST" enctype="multipart/form-data">
                @csrf
                <h2 style="margin-top: 2rem;">Add Food</h2>
                <h3>Food Name</h3>
                <input type="text" placeholder="New Food" name="food_name"/>
                <h3>Food Image</h3>
                <input type="file" placeholder="New Food" name="food_image" accept="image/png, image/gif, image/jpeg"/>
                <h3>Category</h3>
                <select name="food_category" id="">
                    <option disabled selected>-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                    @endforeach
                </select>
                <h3>Food Price</h3>
                <input type="number" placeholder="" name="food_price" step="0.01" min="0"/>
                <div style="margin-top: 1rem;"><button>Add Food</button></div>
            </form>
        </main>
    </div>
@stop
