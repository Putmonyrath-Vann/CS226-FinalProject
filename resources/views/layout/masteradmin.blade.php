<head>
    @include('layout.head')
    @yield('styles')
    @yield('scripts')
</head>

<body>
    <nav>
        @include('layout.navadmin')
    </nav>

    <main class="center" style="min-height: 700px">
        @yield('content')
    </main>

</body>