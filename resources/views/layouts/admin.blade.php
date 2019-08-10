<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Brand Excellence Admin Panel')</title>
    <meta name="description" content="Brand Excellence">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="{{asset('images/be_logo.png')}}">

    <link rel="stylesheet" href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/themify-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/selectFX/css/cs-skin-elastic.css')}}">


    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/mystyle.css')}}">

    @yield('styles')

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>


<!-- Left Panel -->

<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" style="white-space: inherit; text-align: center; line-height: inherit;" href="#">{{Auth::user()->name}}</a>
            <a class="navbar-brand" href="#"><h6>{{Auth::user()->is_super == 1 ? 'Super User' : 'Admin'}}</h6></a>
            <a class="navbar-brand hidden" href="#"><img src="{{ asset('images/be_logo.png') }}" alt="" class="img-fluid"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li id="dashboard-li">
                    <a href="{{route('admin.index')}}"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                </li>

                <li id="clients-li">
                    <a href="{{route('admin.client.index')}}"> <i class="menu-icon fa fa-briefcase"></i>Clients </a>
                </li>

                <li id="brands-li">
                    <a href="{{route('admin.brand.index')}}"> <i class="menu-icon fa fa-first-order"></i>Brands </a>
                </li>

                <li id="judges-li">
                    <a href="{{route('admin.judge.index')}}"> <i class="menu-icon fa fa-gavel"></i>Judges </a>
                </li>

                <li id="auditors-li">
                    <a href="{{route('admin.auditor.index')}}"> <i class="menu-icon fa fa-search"></i>Auditors </a>
                </li>

                <li id="smes-li">
                    <a href="{{route('admin.sme.index')}}"> <i class="menu-icon fa fa-grav"></i>SME </a>
                </li>

                <li id="scores-r1-li" class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"> <i class="menu-icon fa fa-star"></i>Scores R1</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li id="judge-wise-r1-li"><i class="fa fa-user"></i><a href="{{ route('admin.score.judge_wise') }}">Judge Wise</a></li>
                        <li id="entry-wise-r1-li"><i class="fa fa-list"></i><a href="{{ route('admin.score.entry_wise') }}">Entry Wise</a></li>
                    </ul>
                </li>

                <li id="benchmarks-li">
                    <a href="{{route('admin.benchmark.index')}}"> <i class="menu-icon fa fa-scissors"></i>Benchmarks </a>
                </li>

                <li id="panels-li">
                    <a href="{{route('admin.panel.index')}}"> <i class="menu-icon fa fa-columns"></i>Panels </a>
                </li>

                <li id="scores-r2-li" class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"> <i class="menu-icon fa fa-star"></i>Scores R2</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li id="judge-wise-r2-li"><i class="fa fa-user"></i>
                            <a href="{{ route('admin.score.judge_wise2') }}">Judge Wise</a>
                        </li>
                        <li id="entry-wise-r2-li"><i class="fa fa-list"></i>
                            <a href="{{ route('admin.score.entry_wise2') }}">Entry Wise</a>
                        </li>
                    </ul>
                </li>

                <li id="winners-li">
                    <a href="{{route('admin.winner.index')}}"> <i class="menu-icon fa fa-trophy"></i>Winners </a>
                </li>

                @if( Auth::check() && Auth::user()->is_super == 1)

                    <li id="categories-li">
                        <a href="{{route('super.category.index')}}"> <i class="menu-icon fa fa-snowflake-o"></i>Categories </a>
                    </li>

                    <li id="industry-categories-li">
                        <a href="{{route('super.industry_category.index')}}"> <i class="menu-icon fa fa-industry"></i>Industry Categories </a>
                    </li>

                    <li id="admins-li">
                        <a href="{{route('super.admin.index')}}"> <i class="menu-icon fa fa-users"></i>Admins </a>
                    </li>

                @endif

                @if( Auth::check() && Auth::user()->is_super == 0)

                    <li id="categories-li">
                        <a href="{{route('admin.categories')}}"> <i class="menu-icon fa fa-snowflake-o"></i>Categories </a>
                    </li>

                    <li id="industry-categories-li">
                        <a href="{{route('admin.industry_categories')}}"> <i class="menu-icon fa fa-industry"></i>Industry Categories </a>
                    </li>

                @endif

                <li id="resetpw-li">
                    <a href="{{route('admin.show_password_reset_form')}}"> <i class="menu-icon fa fa-key"></i>Reset Password </a>
                </li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside><!-- /#left-panel -->

<!-- Left Panel -->

<!-- Right Panel -->

<div id="right-panel" class="right-panel">

    <!-- Header-->
    <header id="header" class="header">

        <div class="header-menu">

            <div class="col-sm-7">
                <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
            </div>

            <div class="col-sm-5">
                <div class="user-area dropdown float-right">
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary"><i class="fa fa-power-off"></i> Logout</button>
                    </form>
                </div>

            </div>
        </div>

    </header><!-- /header -->
    <!-- Header-->

    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>@yield('breadcrumbs_title')</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        @yield('breadcrumbs')
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">

{{--        <div class="col-sm-12">--}}
{{--            <div class="alert  alert-success alert-dismissible fade show" role="alert">--}}
{{--                <span class="badge badge-pill badge-success">Success</span> You successfully read this important alert message.--}}
{{--                <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                    <span aria-hidden="true">&times;</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}

        @yield('content')


    </div> <!-- .content -->
</div><!-- /#right-panel -->

<!-- Right Panel -->

<script src="{{asset('vendors/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('vendors/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('vendors/jQuery-Form-Validator/form-validator/jquery.form-validator.js')}}"></script>

<script>
    const $ = jQuery
</script>

@yield('scripts')

</body>

</html>
