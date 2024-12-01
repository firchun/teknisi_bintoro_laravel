<!DOCTYPE html>

<html lang="zxx">

<head>
    <meta charset="utf-8">
    <title>Teknisi AC</title>

    <!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- theme meta -->
    <meta name="theme-name" content="godocs" />

    <!-- ** Plugins Needed for the Project ** -->
    <!-- plugins -->
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/plugins/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/plugins/themify-icons/themify-icons.css">
    <!-- Main Stylesheet -->
    <link href="{{ asset('frontend_theme') }}/css/style.css" rel="stylesheet">

    <!--Favicon-->
    <link rel="shortcut icon" href="{{ asset('frontend_theme') }}/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="{{ asset('frontend_theme') }}/images/favicon.ico" type="image/x-icon">

</head>

<body>



    @include('layouts.frontend.header')

    @yield('content')

    @include('layouts.frontend.footer')

    <!-- plugins -->
    <script src="{{ asset('frontend_theme') }}/plugins/jQuery/jquery.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/plugins/masonry/masonry.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/plugins/clipboard/clipboard.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/plugins/match-height/jquery.matchHeight-min.js"></script>

    <!-- Main Script -->
    <script src="{{ asset('frontend_theme') }}/js/script.js"></script>
    @stack('js')
</body>

</html>
