@extends('layout.master')

@section('pageTitle', 'Edit Personal Information')

@section('content')

    <script>
        function toggleShowPassword() {
            let showPassElement = document.getElementById("show-pass");
            let passwordElement = document.getElementById("password");
            let confirmPasswordElement =
                document.getElementById("confirm-password");
            if (passwordElement.type == "password") {
                passwordElement.type = "text";
                confirmPasswordElement.type = "text";
                showPassElement.innerHTML = "Hide password";
            } else {
                passwordElement.type = "password";
                confirmPasswordElement.type = "password";
                showPassElement.innerHTML = "Show password";
            }
        }
    </script>

    @if (session('success'))
        <script>
            alert("{{session('success')}}")
        </script>
    @endif

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
        <a href="/restaurant"><h1>Paragon Eats</h1></a>
    </nav>
    <main>
        <form class="account-form" action="/restaurant/edit/profile" method="post" enctype="multipart/form-data">
            @csrf
            <h1>Edit Personal Information</h1>

            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Name" value="{{$restaurant->name}}"/>
            @if ($errors->has('name'))
                <p class="error">{{$errors->first('name')}}</p>
            @endif

            <label for="email">Email</label>
            <input type="email" name="email" placeholder="example@gmail.com" value="{{$restaurant->email}}"/>
            @if ($errors->has('email'))
                <p class="error">{{$errors->first('email')}}</p>
            @endif

            <label for="password">Password</label>
            <input type="password" name="password" id="password" />
            @if ($errors->has('password'))
                <p class="error">{{$errors->first('password')}}</p>
            @endif

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm-password" />
            @if ($errors->has('confirm_password'))
                <p class="error">{{$errors->first('confirm_password')}}</p>
            @endif

            <label for="phone_number">Phone Number</label>
            <input type="phone_number" name="phone_number" value="{{$restaurant->phone_number}}"/>
            @if ($errors->has('phone_number'))
                <p class="error">{{$errors->first('phone_number')}}</p>
            @endif

            <label for="logo">Logo</label>
            <input type="file" name="logo" accept="image/png, image/gif, image/jpeg"/>
            @if ($errors->has('logo'))
                <p class="error">{{$errors->first('logo')}}</p>
            @endif

            <label for="building_no">Building Number</label>
            <input type="text" name="building_no" value="{{$restaurant->building_no}}"/>
            @if ($errors->has('building_no'))
                <p class="error">{{$errors->first('building_no')}}</p>
            @endif

            <label for="street_no">Street Number</label>
            <input type="text" name="street_no" value="{{$restaurant->street_no}}"/>
            @if ($errors->has('street_no'))
                <p class="error">{{$errors->first('street_no')}}</p>
            @endif

            <section>
                <label for="region">Region:</label>
                <select name="region">
                    <option value=''>Select Region</option>
                    @foreach ($regions as $region)
                        <option value="{{$region->region_id}}" {{$region->region_id == $restaurant->region_id ? 'selected' : ''}}>{{$region->region_name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('region'))
                    <p class="error">{{$errors->first('region')}}</p>
                @endif
            </section>

            <label for="description">Address Description:</label>
            <textarea class="textarea" type="text" name="description" placeholder="Write Your Address Description Here">{{$restaurant->description}}</textarea>
            @if ($errors->has('description'))
                <p class="error">{{$errors->first('description')}}</p>
            @endif

            <p
                class="show-pass inactive"
                id="show-pass"
                onclick="toggleShowPassword()"
            >
                Show password
            </p>
            <div><button>Update</button></div>
        </form>
    </main>
@stop