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
    <h1 class="text-3xl mb-16 text-center font-bold cursor-pointer">Choose Your Role</h1>
    <div class="flex items-center justify-around">
        <div class="w-1/4">
            <a href="/signup/customer">
                <div class="bg-blue-800 text-3xl w-full leading-loose text-white rounded-xl mt-4 h-36 flex items-center justify-center">
                    <span class="my-auto">Sign Up As A Customer</span>
                </div>
            </a>
        </div>
        <div class="w-1/4">
            <a href="/signup/driver">
                <div class="bg-blue-800 text-3xl w-full leading-loose text-white rounded-xl mt-4 h-36 flex items-center justify-center">
                    <span>Sign Up As A Driver</span>
                </div>
            </a>
        </div>

        <div class="w-1/4">
            <a href="/signup/restaurant">
                <div class="bg-blue-800 text-3xl w-full leading-loose text-white rounded-xl mt-4 h-36 flex items-center justify-center">
                    <span>Sign Up For A Restaurant</span>
                </div>
            </a>
        </div>
    </div>

    <div class="flex justify-center">
        <a href="/login" class="text-3xl mt-28 text-center font-bold cursor-pointer hover:underline">Log In</a>
    </div>
</body>
</html>
