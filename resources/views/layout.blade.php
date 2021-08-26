<!-- layout.blade.php -->
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>王氏針法穴道薈萃 - @yield('title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
    <body>
        <header>
        @section('header')
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <a class="navbar-brand" href="/" style="font-size: 30px;">王氏針法穴道薈萃</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/login">Login</a></li>
                    <li><a href="/admin">Admin</a></li>
                </ul>
                </div>
            </div>
        </nav>
        @show
        </header>

        <nav>
        </nav>

        <section>
            <style>
                .full-height {
                    /*height: 100vh;*/
                }
                .flex-center {
                    align-items: center;
                    display: flex;
                    justify-content: center;
                }
                .content {
                    margin-top: 80px;
                    text-align: center;
                }
                .navbar {
                    margin-bottom: 0;
                    background-color: #f4511e;
                    z-index: 9999;
                    border: 0;
                    font-size: 18px !important;
                    line-height: 1.42857143 !important;
                    letter-spacing: 4px;
                    border-radius: 0;
                }
                .navbar li a, .navbar .navbar-brand {
                    color: #fff !important;
                }
                .navbar-nav li a:hover, .navbar-nav li.active a {
                    color: #f4511e !important;
                    background-color: #fff !important;
                }
                .navbar-default .navbar-toggle {
                    border-color: transparent;
                    color: #fff !important;
                }
                .navbar-right {
                    display: flex;
                }
                @media screen and (max-width: 768px) {
                    .col-sm-4 {
                        text-align: center;
                        margin: 25px 0;
                    }
                    .content {
                        margin-top: 13%;
                    }
                }
            </style>
            @yield('content')
        </section>

        <!--footer>
            <div id="copyright text-right" style="margin-top: 5%;">© Copyright 2020</div>
        </footer-->
    </body>
    <section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        @yield('page-js-files')
    </section>
    @yield('page-js-script')
</html>