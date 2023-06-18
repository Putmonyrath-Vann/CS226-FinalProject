<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <title>Add Restaurant</title>
</head>
<body class="my-4">
    <h1 class="heading-signup capitalize">add a new restaurant</h1>
    <form class="signup" action="admin/add/restaurant" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="w-full">
            <label for="first_name">Restaurant Name:</label>
            <input class="personal-info" type="text" name="name"><br/>
        </div>

        <div class="w-full">
            <label for="email">Email:</label>
            <input class="personal-info" type="email" name="email"><br/>
        </div>

        <div class="w-full">
            <label for="password">Password:</label>
            <input class="personal-info password" type="password" name="password"><br/>
        </div>

        <div class="w-full">
            <label for="confirm_password">Confirm Password:</label>
            <input class="personal-info password" type="password" name="confirm_password"><br/>
        </div>

        <div class="w-full">
            <label for="phone_number">Phone Number:</label>
            <input class="personal-info" type="text" name="phone_number"><br/>
        </div>

        <div class="w-full">
            <label for="gender">Gender:</label>
            <select name="gender" class="personal-info">
                <option value=1>Male</option>
                <option value=0>Female</option>
            </select><br/>
        </div>

        <div class="w-full">
            <label for="pfp">Profile Picture:</label>
            <input class="personal-info !border-0" type="file" name="pfp"><br/>
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
