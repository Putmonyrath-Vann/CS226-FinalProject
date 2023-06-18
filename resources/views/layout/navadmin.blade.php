<div class="container">
    <div class="nav-left">
        <a href="/"><img src="/images/musical-note.png" alt=""></a>
    </div>
    <div class="nav-right">
        <a href="/admin/add-restaurant">Add Restaurant</a>
        <a href="/drivers">Driver</a>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit">Log out</button>
        </form>
    </div>
</div>
