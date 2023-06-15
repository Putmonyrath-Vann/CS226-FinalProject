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
    <h1 class="heading-signup">Choose Your Role</h1>
    <div class="flex items-center justify-around">
        <div class="w-1/4">
            <a href="/login/customer">
                <div class="bg-blue-800 text-3xl w-full leading-loose text-white rounded-xl mt-4 h-36 flex items-center justify-center">
                    <span class="my-auto">Log in As A Customer</span>
                </div>
            </a>
        </div>
        <div class="w-1/4">
            <a href="/login/driver">
                <div class="bg-blue-800 text-3xl w-full leading-loose text-white rounded-xl mt-4 h-36 flex items-center justify-center">
                    <span>Log in As A Driver</span>
                </div>
            </a>
        </div>
    </div>
</body>
</html>
