@extends('layout.master')

@section('styles')
    <link rel="stylesheet" href="/css/home.css">
@stop

@section('pageTitle', 'buyer\'s Page')

@section('content')
    <div class="heading">
        <h1>buyers Page</h1>
    </div>
    <table>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Joined At:</th>
            <th>Action</th>
        </tr>

        @for ($i = 0; $i < 20; $i++)
            <tr>
                <td>{{ $i + 1 }}.</td>
                <td>Putmonyrath Vann</td>
                <td>Male</td>
                <td style="max-width: 300px;">example@gmail.com</td>
                <td>2022-06-16</td>
                <td class="action">
                    <button>
                        <a href="/delete">Delete</a>
                    </button>
                    <button>
                        <a href="/edit">Edit</a>
                    </button>
                </td>
            </tr>
        @endfor
    </table>
@stop
