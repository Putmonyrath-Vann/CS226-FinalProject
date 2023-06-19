@extends('layout.masterrestaurant')

@section('styles')
    <link rel="stylesheet" href="/css/home.css">
@stop

@section('pageTitle', 'Restaurant Page')

@section('content')
    @if ($categories->isEmpty())
        <h1>Your shop haven't created any categories yet</h1>
        <div style="width: 70%;">
            <form action="/restaurant/add/category" method="post" id="form">@csrf</form>
        </div>

        <div id="buttons">
            <button class="add-category-page-btn" onclick="addCategory()">add new category</button>
        </div>
    @else
        <h1>Your shop's categories</h1>
        <div style="width: 70%;">
            @foreach($categories as $category)
                <div class="card">
                    {{$category->category_name}}
                    <a href="/restaurant/delete/category/{{$category->category_id}}">
                        <img src="/trash-bin.png" alt="delete" class="delete-icon"/>
                    </a>
                </div>
            @endforeach
            <form action="/restaurant/add/category" method="post" id="form">@csrf</form>
        </div>

            <div id="buttons">
                <button class="add-category-page-btn" onclick="addCategory()">add new category</button>
            </div>

            {{-- <form action="/restaurant/add/category" method="post" id="form">
                @csrf
                <input type="text" name="category_name" class="card" id="add" placeholder="Add New Category"/>
            </form>
        </div>
        <script src="/js/newcategory.js" defer></script> --}}
    @endif
    <script src="/js/addcategory.js" defer></script>
@stop
