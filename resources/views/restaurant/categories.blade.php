@extends('layout.masterrestaurant')

@section('styles')
    <link rel="stylesheet" href="/css/home.css">
@stop

@section('scripts')
    <script src="/js/addcategory.js" defer></script>
@stop

@section('pageTitle', 'Restaurant Page')

@section('content')
    @if (!isset($categories))
        <h1>Your shop haven't created any categories yet</h1>
        <div style="width: 70%;" id="wrapper"></div>
        <button class="add-category" onclick="console.log('hi')">add new category</button>
    @else
        <h1>Your shop's categories</h1>
        <div style="width: 70%;">
            @foreach($categories as $category)
                <div class="card" draggable="true">
                    {{$category->id}}
                    {{$category->name}}
                </div>
            @endforeach
            <form action="restaurant/add/category" method="post" id="form">
                <input type="text" class="card" name="category_name" id="add" placeholder="Add New Category"/>
            </form>
        </div>
    @endif
@stop
