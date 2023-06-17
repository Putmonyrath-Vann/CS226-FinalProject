<div class="container">
    <div class="nav-left">
        <a href="/"><img src="/images/musical-note.png" alt=""></a>
    </div>
    <div class="nav-right">
        <a href="/customers">Customer</a>
        <a href="/drivers">Driver</a>
        <a href="/signup/customer">Customer Sign Up</a>
        <a href="/signup/driver">Driver Sign Up</a>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit">Log out</button>
        </form>
    </div>
</div>
