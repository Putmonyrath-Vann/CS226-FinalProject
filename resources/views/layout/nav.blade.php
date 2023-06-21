<div class="container">
    <div class="nav-left">
        <a href="/"><img src="/images/musical-note.png" alt=""></a>
    </div>
    <div class="nav-right">
        <a href="/buyer/order">Order</a>
        <a href="/buyer/history">History</a>
        {{-- <a href="/">Customer Sign Up</a>
        <a href="/signup/driver">Driver Sign Up</a> --}}
        <form action="/logout" method="POST">
            @csrf
            <button type="submit">Log out</button>
        </form>
    </div>
</div>
