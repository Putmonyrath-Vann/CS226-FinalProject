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
        <a href="/buyer"><h1>Paragon Eats</h1></a>
    </nav>
    <main>
        <form class="account-form" action="/buyer/edit/profile" method="post" enctype="multipart/form-data">
            @csrf
            <h1>Edit Personal Information</h1>

            <label for="first_name">First Name</label>
            <input type="text" name="first_name" placeholder="First Name" value="{{$buyer->first_name}}"/>
            @if ($errors->has('first_name'))
                <p class="error">{{$errors->first('first_name')}}</p>
            @endif

            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" placeholder="Last Name" value="{{$buyer->last_name}}"/>
            @if ($errors->has('last_name'))
                <p class="error">{{$errors->first('last_name')}}</p>
            @endif

            <label for="email">Email</label>
            <input type="email" name="email" placeholder="example@gmail.com" value="{{$buyer->email}}"/>
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
            <input type="phone_number" name="phone_number" value="{{$buyer->phone_number}}"/>
            @if ($errors->has('phone_number'))
                <p class="error">{{$errors->first('phone_number')}}</p>
            @endif

            <label for="profile_picture">Profile Picture</label>
            <input type="file" name="profile_picture" accept="image/png, image/gif, image/jpeg"/>
            @if ($errors->has('profile_picture'))
                <p class="error">{{$errors->first('profile_picture')}}</p>
            @endif

            <section>
                <label for="gender">Gender:</label>
                <select name="gender">
                    <option value="1">Male</option>
                    <option value="0">Female</option>
                </select>
            </section>
            @if ($errors->has('gender'))
                <p class="error">{{$errors->first('gender')}}</p>
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

    {{-- @if ($errors->any())
        <div class="alert alert-danger" style="margin: 10px 0px 0px 0px;">
            <ul style="margin: 0px;">
                @foreach ($errors->all() as $error)
                    <li style="list-style: none;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <script>
            alert("{{session('success')}}")
        </script>
    @endif
    <h1>Edit Personal Information</h1>
    <form action="/buyer/edit/profile" method="post" id="form">
        @csrf
        <div class="profile-picture-row">
            <div class="profile-picture-wrapper">
                <img src="{{isset($buyer->profile_img) ? $buyer->profile_img : '/user.png'}}" class="profile-picture" id="img" />
                <label for="profile_img" class="label">Change Picture</label>
                <input type="file" name="profile_img" id="profile_img" style="display: none;" accept="image/png, image/jpeg" onchange="updateImage({{$buyer->buyer_id}})">
            </div>

        </div>
        <div class="input-row">
            <label>First Name: </label>
            <input class="input" type="text" name="first_name" value="{{$buyer->first_name}}">
        </div>
        <div class="input-row">
            <label>Last Name: </label>
            <input class="input" type="text" name="last_name" value="{{$buyer->last_name}}">
        </div>
        <div class="input-row">
            <label>Email: </label>
            <input class="input" type="email" name="email" value="{{$buyer->email}}">
        </div>
        <div class="input-row">
            <label onclick="togglePassword()">Password: </label>
            <input class="input password" type="password" name="password" placeholder="Enter Your New Password" class=>
        </div>
        <div class="input-row">
            <label onclick="togglePassword()">Confirm Password: </label>
            <input class="input password" type="password" name="confirm_password" placeholder="Enter Your New Password">
        </div>
        <div class="input-row">
            <label>Phone Number: </label>
            <input class="input" type="text" name="phone_number" value="{{$buyer->phone_number}}" placeholder="Phone Number">
        </div>
        <div class="input-row">
            <label>Building Number: </label>
            <input class="input" type="text" name="building_no" value="{{$buyer->building_no}}" placeholder="Building Number">
        </div>
        <div class="input-row">
            <label>Street Number: </label>
            <input class="input" type="text" name="street_no" value="{{$buyer->street_no}}" placeholder="Street Number">
        </div>
        <div class="input-row">
            <label>Region: </label>
            <select class="input" name="region">
                <option value=''>Select Region</option>
                @foreach ($regions as $region)
                    <option value="{{$region->region_id}}" {{$region->region_id == $buyer->region_id ? 'selected' : ''}}>{{$region->region_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="input-row" style="align-items: self-start;">
            <label>Address Description: </label>
            <textarea class="input input-textarea" type="text" name="description" placeholder="Write Your Address Description Here">{{$buyer->description}}</textarea>
        </div>

        <button class="save-btn" id="submit" onclick="submit()">Save</button>
    </form>

    <script src="/js/editProfile.js" defer></script> --}}
@stop