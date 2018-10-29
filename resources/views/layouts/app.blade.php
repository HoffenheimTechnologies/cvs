<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{URL::asset('css/materialize.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/loaders.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/style.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/icofont.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/stylemashable.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/datedropper.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/sweetalert.css')}}">
    @yield('css')

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> -->

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
</head>
<body>

  <!-- preloader -->
  <div class="preloader">
      <div class="spinner"></div>
  </div>
  <!-- end preloader -->

  <!-- navbar -->
  <div class="navbar navbar-home" style="">
      <div class="container">
          <div class="row">
              <div class="col s3">
                  <div class="content-left">
                      <a href="#slide-out" data-target="slide-out" class="sidenav-trigger"><i class="fa fa-bars"></i></a>

                  </div>
              </div>
              <div class="col s6">
                  <div class="content-center">
                      <a href="{{route('home')}}"><h1>{{ config('app.name') }}</h1></a>
                  </div>
              </div>
              <div class="col s3">
                  <div class="content-right">
                      <a href="#"><i class="fa fa-clipboard"></i></a>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- end navbar -->

    <!-- sidebar -->
    <div class="sidebar-panel">
        <ul id="slide-out" class="collapsible sidenav side-left side-nav">
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="images/bg-user.html" alt="">
                    </div>
                    <h2><span></span>{{ config('app.name') }}</h2>
                    <p>Validation Management System</p>
                </div>
            </li>
            <hr>
            @auth
            <li><a href="{{route('home')}}"><i class="fa fa-home"></i>Home</a></li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-file"></i>Attendance<span><i class="fa fa-caret-right right fa-spin"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="{{route('attendance.history')}}"><i class="fa fa-table fa-spin"></i>History</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-user"></i>Profile<span><i class="fa fa-caret-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="{{route('profile')}}"><i class="fa fa-user-circle-o fa-spin"></i>Profile</a></li>
                        <li><a href="{{route('profile.edit')}}"><i class="fa fa-edit fa-spin"></i>Edit Profile</a></li>
                    </ul>
                </div>
            </li>
            @if(Auth::user()->Admin())
              <li>
                <div class="collapsible-header">
                    <i class="fa fa-lock"></i>Admin<span><i class="fa fa-caret-right right fa-spin"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                      <li><a href="{{route('event')}}"><i class="fa fa-lock"></i>Event</a></li>
                      <li><a href="{{route('report')}}"><i class="icofont icofont-chart-histogram"></i>Report</a></li>
                    </ul>
                </div>
              </li>
            @endif
            @else
            <li><a href="{{route('login')}}"><i class="fa fa-sign-in fa-spin"></i>Login</a></li>
            <li><a href="{{route('register')}}"><i class="fa fa-user-plus fa-spin"></i>Register</a></li>
            <li><a href="{{route('password.request')}}"><i class="fa fa-key fa-spin"></i>Forgot Password</a></li>
            @endauth
            @auth
            <li><a
                  href="{{route('logout')}}" onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();"
                ><i class="fa fa-sign-out fa-spin"></i>Logout</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endauth
        </ul>
    </div>
    <!-- end sidebar -->
    <!-- <main class="py-4"> -->
    <div class="container segments-page">
      @yield('content')
    </div>
    <!-- </main> -->
    <!-- footer -->
    <footer>
        <div class="container">
            <div class="desc">
                <p>Hoffenheim Technologies Limited</p>
                <!-- <span>United Kingdom</span> -->
            </div>
            <ul>
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            </ul>
            <p>Copyright Hoffenheim Technologies © All Right Reserved</p>
        </div>
    </footer>
    <!-- end footer -->
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('js/materialize.min.js')}}"></script>
    <script src="{{URL::asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{URL::asset('js/main.js')}}"></script>
    <script src="{{URL::asset('js/sweetalert.min.js')}}"></script>
    <!-- <script src="{{URL::asset('js/script.js')}}"></script> -->
    @yield('jslink')

    @yield('script')
    <script type="text/javascript">
      $(document).ready(function(){


      });
    </script>
  </body>
</html>
