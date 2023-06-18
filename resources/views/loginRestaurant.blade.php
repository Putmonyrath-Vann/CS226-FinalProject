<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <title>Log in</title>
</head>
<body class="my-4">
    <h1 class="heading-signup">Log in As A Customer</h1>
    <form class="signup" action="/login/restaurant" method="POST" enctype="multipart/form-data">
        @csrf

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

        <p class="self-start hover:underline cursor-pointer select-none" onclick="showPassword()" id="show">Show Password</p>

        <div class="self-start mt-5">
            <input type="checkbox" name="remember" class="scale-125 mr-2" value=1>
            <label for="remember" class="text-lg">Remember Me</label>
        </div>

        <button type="submit" class="bg-blue-800 text-2xl w-full leading-loose text-white rounded-xl mt-4">Submit</button>

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
