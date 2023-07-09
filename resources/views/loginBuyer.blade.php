<head>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<script>
    function toggleShowPassword() {
        console.log("Work");
        let showPassElement = document.getElementById("show-pass");
        let passwordElement = document.getElementById("password");
        if (passwordElement.type == "password") {
            passwordElement.type = "text";
            showPassElement.innerHTML = "Hide password";
        } else {
            passwordElement.type = "password";
            showPassElement.innerHTML = "Show password";
        }
    }
</script>

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
    <h1>Paragon Eats</h1>
</nav>
<main>
    <form class="account-form" action="" method="POST">
        @csrf
        <h1>Login As Buyer</h1>

        <label for="email">Email</label>
        <input type="email" name="email" placeholder="example@gmail.com" />
        @if ($errors->has('email'))
            <p class="error">{{$errors->first('email')}}</p>
        @endif

        <label for="password">Password</label>
        <input type="password" name="password" id="password" />
        @if ($errors->has('password'))
            <p class="error">{{$errors->first('password')}}</p>
        @endif

        <label class="checkbox">
            <input type="checkbox" name="remember" checked />
            Remember Me
        </label>
        <p
            class="show-pass inactive"
            id="show-pass"
            onclick='toggleShowPassword()'
        >
            Show password
        </p>
        <div><button>Login</button></div>
    </form>
</main>
