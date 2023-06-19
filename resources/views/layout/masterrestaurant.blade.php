<head>
    @include('layout.head')
    @yield('styles')
    @yield('scripts')
</head>

<body>
    <nav>
        @include('layout.navrestaurant')
    </nav>

    <main class="center" style="min-height: 700px">
        @yield('content')
    </main>

</body>