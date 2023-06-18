@extends('layout.masteradmin')

@section('styles')
    <link rel="stylesheet" href="/css/home.css">
@stop

@section('pageTitle', 'Admin Page')

@section('content')
    <div class="heading">
        <h1>Admin Page</h1>
    </div>
    <table>
        <tr>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Action</th>
        </tr>

        @for ($i = 0; $i < 20; $i++)
            <tr>
                <td>Putmonyrath Vann</td>
                <td>Male</td>
                <td>19</td>
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
