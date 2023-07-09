<head>
    <link rel="stylesheet" href="/css/styles.css">
</head>

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
        <h1>Sign Up As Buyer</h1>

        <label for="first_name">First Name</label>
        <input type="text" name="first_name" placeholder="First Name" />
        @if ($errors->has('first_name'))
            <p class="error">{{$errors->first('first_name')}}</p>
        @endif

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" placeholder="Last Name" />
        @if ($errors->has('last_name'))
            <p class="error">{{$errors->first('last_name')}}</p>
        @endif

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

        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm-password" />
        @if ($errors->has('confirm_password'))
            <p class="error">{{$errors->first('confirm_password')}}</p>
        @endif

        <label for="phone_number">Phone Number</label>
        <input type="phone_number" name="phone_number" />
        @if ($errors->has('phone_number'))
            <p class="error">{{$errors->first('phone_number')}}</p>
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

        <label for="profile_picture">Profile Picture</label>
        <input type="file" name="profile_picture" />
        @if ($errors->has('profile_picture'))
            <p class="error">{{$errors->first('profile_picture')}}</p>
        @endif

        <p
            class="show-pass inactive"
            id="show-pass"
            onclick='toggleShowPassword()'
        >
            Show password
        </p>
        <div><button>Sign Up</button></div>
    </form>
</main>
