<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    @include('partials.top._head')

    @include('partials.top._links')

    @yield('links')

</head>
<body>
    <div id="app">
        
        @include('partials.top._nav')

        <div class="container">

            @yield('content')

        </div>

    </div>

    <!-- Scripts -->
    @include('partials.bottom._scripts')
    @yield('scripts')

</body>
</html>
