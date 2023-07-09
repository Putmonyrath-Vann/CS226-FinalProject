@extends('layout.master')

@section('pageTitle', 'Restaurant Page')

@section('content')
    <script>
        let categories = ["Fast Food", "Deserts", "Alcohol"];
    </script>

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
        <main class="container" style="color:white">
            <h1 style="text-align: center;margin-bottom: 2rem;">Your Categories</h1>
            <ul class="categories">
                @foreach($categories as $category)
                    <a onclick="
                        let confirmation = confirm('Are you sure you want to delete this category?');
                        if (confirmation) {
                            window.location.href = '/restaurant/remove/category/{{$category->category_id}}';
                        }
                    ">
                        {{$category->category_name}}
                    </a>
                @endforeach
            </ul>
            <h2 style="margin-top: 2rem;">New Category</h2>
            <form class="new-category" action="/restaurant/add/category" method="POST">
                @csrf
                <input type="text" placeholder="New Category" name="category_name"/>
                <button>Add Category</button>
            </form>
        </main>
    </div>
@stop
