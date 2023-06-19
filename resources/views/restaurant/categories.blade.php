@extends('layout.masterrestaurant')

@section('styles')
    <link rel="stylesheet" href="/css/home.css">
@stop

@section('pageTitle', 'Restaurant Page')

@section('content')
    @if (!isset($categories))
        <h1>Your shop haven't created any categories yet</h1>
        <div style="width: 70%;">
            <form action="/restaurant/add/category" method="post" id="form">@csrf</form>
        </div>

        <div id="buttons">
            <button class="add-category-page-btn" onclick="addCategory()">add new category</button>
        </div>
        <script src="/js/addcategory.js" defer></script>
    @else
        <h1>Your shop's categories</h1>
        <div style="width: 70%; margin: 0 0 200px 0">
            @foreach($categories as $category)
                <div class="card">
                    {{$category->category_name}}
                    <img src="/trash-bin.png" alt="delete" class="delete-icon" onclick="" />
                </div>
            @endforeach
            <form action="/restaurant/add/category" method="post" id="form">
                <input type="text" name="category_name" class="card" id="add" placeholder="Add New Category"/>
            </form>
        </div>
        <script src="/js/newcategory.js" defer></script>
    @endif
@stop
