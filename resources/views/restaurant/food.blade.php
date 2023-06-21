@extends('layout.masterrestaurant')

@section('styles')
    <link rel="stylesheet" href="/css/home.css">
@stop

@section('pageTitle', 'Restaurant Page')

@section('content')
    @for ($i = 0; $i < count(old('food_image', [])); $i++)
        @if ($errors->has('food_image.' . $i))
            <span class="error">{{ $errors->first('food_image.' . $i) }}</span>
        @endif
    @endfor
        <div class="alert alert-danger">
            @if ($errors->has('food_image'))
                <script>alert({{"file size too big"}})</script>
            @endif

        </div>

    @if ($foods->isEmpty())
        <h1>Your shop haven't added any food yet</h1>
        <div style="width: 70%;">
            <form action="/restaurant/add/food" method="post" id="form" enctype="multipart/form-data">@csrf</form>
        </div>

        <div id="buttons">
            <button class="category-food-add-btn" onclick="addFood({{$categories}})">add new food</button>
        </div>
    @else
        {{-- {{$categories}} --}}
        <h1>Your shop's foods</h1>
            <div style="width: 70%;">
                @foreach($foods as $food)
                    <div class="food">
                        <div class="image-for-food">
                            <img src="{{$food->img}}" alt="food" class="food-image"/>
                        </div>
                        <div class="food-detail">
                        <p class="food-name">{{$food->name}}</p>
                        <p class="food-secondary-text">
                            @php
                                foreach ($categories as $category) {
                                    if ($category->category_id == $food->category_id) {
                                        echo $category->category_name;
                                    }
                                }
                            @endphp
                        </p>
                        <p class="food-secondary-text">
                            @php
                                $price = $food->price;
                                $price = number_format($price, 2, '.', ',');
                                echo '$'.$price;
                            @endphp
                        </p>
                        <a href="/restaurant/delete/food/{{$food->food_id}}">
                            <img src="/trash-bin.png" alt="delete" class="delete-icon self-end"/>
                        </a>
                    </div>
                @endforeach
                <form action="/restaurant/add/food" method="post" id="form">@csrf</form>
            </div>
        </div>

            <div id="buttons">
                <button class="category-food-add-btn" onclick="addFood($categories)">add new food</button>
            </div>

            {{-- <form action="/restaurant/add/category" method="post" id="form">
                @csrf
                <input type="text" name="category_name" class="card" id="add" placeholder="Add New Category"/>
            </form>
        </div>
        <script src="/js/newcategory.js" defer></script> --}}
    @endif
    <script src="/js/addFood.js" defer></script>
@stop
