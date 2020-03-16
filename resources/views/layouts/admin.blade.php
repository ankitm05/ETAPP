<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
     <title>ETAPP Admin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/logo/logosn.png">
    <!-- Google Fonts ============================================ -->
    @if(Auth::check())
        @include('partials.headtwo')
    @else
        @include('partials.head')
    @endif
</head>

<body>
    @if(Auth::check())
        @include('partials.sidebar')
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        <div class="header-advance-area">
            @include('partials.topheader')
        </div>
    @endif
    <!-- CONTENT -->
        @yield('content')
    <!-- / CONTENT -->

    @if(Auth::check())
        @include('partials.footertwo')
    @else
        @include('partials.footer')
    @endif

    @yield('scripts')
</body>
</html>