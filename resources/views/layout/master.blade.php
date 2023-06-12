<head>
    @include('layout.head')
    @yield('styles')
    @yield('scripts')
</head>

<body>
    <nav>
        @include('layout.nav')
    </nav>

    <main>
        @yield('content')
    </main>
        
    <footer>
        @include('layout.footer')
    </footer>
</body>