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
    <title>@yield('title', 'Brand Excellence Judge Panel')</title>
    <meta name="description" content="Brand Excellence">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
            <a class="navbar-brand" href="#"><h6>Judge</h6></a>
            <a class="navbar-brand hidden" href="#"><img src="{{ asset('images/be_logo.png') }}" alt="" class="img-fluid"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            @if(Auth::user()->first_time_password_reset)
            <ul class="nav navbar-nav">

                @if($flags->current_round == 2)
                <li id="round2-li" class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"> <i class="menu-icon fa fa-star"></i>Round 2</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li id="entries-r1-li"><i class="fa fa-ravelry"></i>
                            <a href="{{ route('judge.index2') }}">Entries </a>
                        </li>
                        <li id="my-scores-r1-li"><i class="fa fa-star"></i>
                            <a href="{{ route('judge.my_scores2') }}">My Scores </a>
                        </li>
                        <li id="score-pattern-r2-li"><i class="fa fa-bar-chart"></i>
                            <a href="{{ route('judge.score_pattern2') }}">Score Pattern</a>
                        </li>
                    </ul>
                </li>

                    @php
                        $judge = \Illuminate\Support\Facades\Auth::user();
                        $judgePanels = $judge->panels;
                        $hasSME = false;

                        foreach ($judgePanels as $p) {
                            $categories = $p->categories;
                            if($categories->count() == 1) {
                                foreach ($categories as $c) {
                                    if($c->code == 'SME') {
                                        $hasSME = true;
                                    }
                                }
                            }
                        }
                    @endphp

                    @if($hasSME)
                <li id="round2-sme-li" class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"> <i class="menu-icon fa fa-star"></i>Round 2 SME</a>
                    <ul class="sub-menu children dropdown-menu">

                        <li id="entries-sme-r2-li"><i class="fa fa-ravelry"></i>
                            <a href="{{ route('judge.sme.index_r2') }}">SME Entries </a>
                        </li>
                        <li id="my-scores-sme-r2-li"><i class="fa fa-list"></i>
                            <a href="{{ route('judge.sme.my_scores_r2') }}">My SME Scores </a>
                        </li>
                        <li id="score-pattern-sme-r2-li"><i class="fa fa-bar-chart"></i>
                            <a href="{{ route('judge.sme.score_pattern_r2') }}">SME Score Pattern</a>
                        </li>
                    </ul>
                </li>
                    @endif
                @endif

                <li id="round1-li" class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"> <i class="menu-icon fa fa-star"></i>Round 1</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li id="entries-r1-li"><i class="fa fa-ravelry"></i>
                            <a href="{{ route('judge.index') }}">Entries </a>
                        </li>
                        <li id="my-scores-r1-li"><i class="fa fa-list"></i>
                            <a href="{{ route('judge.my_scores') }}">My Scores </a>
                        </li>
                        <li id="score-pattern-r1-li"><i class="fa fa-bar-chart"></i>
                            <a href="{{ route('judge.score_pattern') }}">Score Pattern</a>
                        </li>
                    </ul>
                </li>

                @if(\App\SmeJudge::whereJudgeId(Auth::user()->id)->count() != 0)
                <li id="round1-sme-li" class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"> <i class="menu-icon fa fa-star"></i>Round 1 SME</a>
                    <ul class="sub-menu children dropdown-menu">

                        <li id="entries-sme-r1-li"><i class="fa fa-ravelry"></i>
                            <a href="{{ route('judge.sme.index_r1') }}">SME Entries </a>
                        </li>
                        <li id="my-scores-sme-r1-li"><i class="fa fa-list"></i>
                            <a href="{{ route('judge.sme.my_scores_r1') }}">My SME Scores </a>
                        </li>
                        <li id="score-pattern-sme-r1-li"><i class="fa fa-bar-chart"></i>
                            <a href="{{ route('judge.sme.score_pattern_r1') }}">SME Score Pattern</a>
                        </li>
                    </ul>
                </li>
                @endif

                <li id="resetpw-li">
                    <a href="{{route('judge.show_password_reset_form')}}"> <i class="menu-icon fa fa-key"></i>Reset Password </a>
                </li>

            </ul>
            @endif
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
