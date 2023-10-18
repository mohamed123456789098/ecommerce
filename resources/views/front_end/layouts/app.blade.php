<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @extends('front_end.layouts.header')
</head>
<body class="goto-here">
    @include('front_end.layouts.nav')
    @yield('content')
    @extends('front_end.layouts.footer')
</body>
</html>

