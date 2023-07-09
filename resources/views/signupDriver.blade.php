<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <title>Sign Up</title>
</head>
<body class="my-4">
    <h1 class="heading-signup">Sign Up As A Driver</h1>
    <form class="signup" action="/signup/driver" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="w-full">
            <label for="first_name">First Name:</label>
            @if ($errors->has('first_name'))
                <p class="text-[red]">{{$errors->first('first_name')}}</p>
            @endif
            <input class="personal-info" type="text" name="first_name"><br/>
        </div>

        <div class="w-full">
            <label for="last_name">Last Name:</label>
            @if ($errors->has('last_name'))
                <p class="text-[red]">{{$errors->first('last_name')}}</p>
            @endif
            <input class="personal-info" type="text" name="last_name"><br/>
        </div>

        <div class="w-full">
            <label for="email">Email:</label>
            @if ($errors->has('email'))
                <p class="text-[red]">{{$errors->first('email')}}</p>
            @endif
            <input class="personal-info" type="email" name="email"><br/>
        </div>

        <div class="w-full">
            <label for="password">Password:</label>
            @if ($errors->has('password'))
                <p class="text-[red]">{{$errors->first('password')}}</p>
            @endif
            <input class="personal-info password" type="password" name="password"><br/>
        </div>

        <div class="w-full">
            <label for="confirm_password">Confirm Password:</label>
            @if ($errors->has('confirm_password'))
                <p class="text-[red]">{{$errors->first('confirm_password')}}</p>
            @endif
            <input class="personal-info password" type="password" name="confirm_password"><br/>
        </div>

        <div class="w-full">
            <label for="phone_number">Phone Number:</label>
            @if ($errors->has('phone_number'))
                <p class="text-[red]">{{$errors->first('phone_number')}}</p>
            @endif
            <input class="personal-info" type="text" name="phone_number"><br/>
        </div>

        <div class="w-full">
            <label for="gender">Gender:</label>
            @if ($errors->has('gender'))
                <p class="text-[red]">{{$errors->first('gender')}}</p>
            @endif
            <select name="gender" class="personal-info">
                <option value=1>Male</option>
                <option value=0>Female</option>
            </select><br/>
        </div>

        <div class="w-full">
            <label for="profile_picture">Profile Picture:</label>
            @if ($errors->has('profile_picture'))
                <p class="text-[red]">{{$errors->first('profile_picture')}}</p>
            @endif
            <input class="personal-info !border-0" type="file" name="profile_picture"><br/>
        </div>

        <p class="self-start hover:underline cursor-pointer select-none" onclick="showPassword()" id="show">Show Password</p>

        <button type="submit" class="bg-blue-800 text-2xl w-full leading-loose text-white rounded-xl mt-6">Submit</button>

    </form>

    <script defer>
        function showPassword() {
            const password = document.querySelectorAll('.password')
            if (password[0].type == "password") {
                password[0].type = 'text'
                password[1].type = 'text'
            }
            else {
                password[0].type = "password"
                password[1].type = "password"
            }
        }
    </script>
</body>
</html>
