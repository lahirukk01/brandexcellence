<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Brand Excellence</title>

        <link rel="shortcut icon" href="{{asset('images/be_logo.png')}}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('vendors/bootstrap/dist/css/bootstrap.css')}}">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #343a40;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
                color: #d4ac5b;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <img src="{{asset('images/be_logo.png')}}" alt="" class="img-fluid">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 title">
                        Brand Excellence
                    </div>
                </div>

                <div class="row">
                    @if (Route::has('login'))
{{--                        <div class="top-right links">--}}
                            @auth
                                <div class="col-sm-12">
                                    <a href="{{ url('/home') }}">Home</a>
                                </div>
                            @else
                            <div class="col-sm-6">
                                <a class="btn btn-info w-100" href="{{ route('login') }}">Login</a>
                            </div>
                            <div class="col-sm-6">
                                @if (Route::has('register'))
                                    <a class="btn btn-info w-100" href="{{ route('register') }}">Register</a>
                                @endif
                            </div>
                            @endauth
{{--                        </div>--}}
                    @endif
                </div>

            </div>
        </div>
    </body>
</html>
