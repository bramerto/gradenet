<?php use Illuminate\Support\Facades\URL; ?>

<html lang="nl-NL">
    <head>
        <title>Gradenet</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="">

        <meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
        <meta HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT"> {{-- Cache control for debugging purposes -> remove on production --}}

        {{--<meta name="robots" content="index, follow">--}}

        <!-- Google data for Google crawl and indexation  -->
        <script type="application/ld+json">
            {
            "@type": "#",
                "url": "http://gradenet.nl",
                "contactPoint": [{
                "@type": "",
                "email": "",
                "contactType": "Info point"
                }]
            }
        </script>

        <!-- GLOBAL VARIABLES -->
        <script>
            var rootPath = '{{ URL::to('/') }}';
            var appPath = '{{ app_path() }}';
            var basePath = '{{ base_path() }}';
        </script>

        <link rel="icon" type="image/x-icon" href=" {{URL::asset('content/img/favicon.ico')}} " /> <!-- Favicon for top bar, needs to be 16x16 or 32x32 pixels -->

        <!--STYLESHEETS-->
        <link href="{{ URL::asset('content/Project/css/gradenet.css') }}" rel="stylesheet" type="text/css" />  <!-- URL::asset links to gradenet/public and loads in CSS and JS files from Laravel -->
        <link href="{{ URL::asset('content/Bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('content/Bootstrap/css/bootstrap-theme.css') }}" rel="stylesheet" type="text/css" />

        <!--BOOTSTRAP SCRIPTS -->
        <script src="{{ URL::asset('content/Bootstrap/js/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('content/Bootstrap/js/bootstrap.js') }}" type="text/javascript"></script>

        <!--CDN STYLESHEETS-->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.3.0/sweetalert2.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">

        <!--CDN SCRIPTS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://use.fontawesome.com/a818efc16e.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.3.0/sweetalert2.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>

        <!-- PROJECT SCRIPTS -->
        <script src="{{ URL::asset('content/Project/js/gradenet.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('content/Project/js/gradenetEventBinder.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('content/Project/js/chart.js')}}" type="text/javascript"></script>
    </head>
    <body>
        @yield('content')
    </body>
</html>