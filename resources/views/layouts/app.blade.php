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
    <link rel="stylesheet" href="{{URL::asset('css/style.css')}}">

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
  <div class="navbar navbar-home">
      <div class="container">
          <div class="row">
              <div class="col s3">
                  <div class="content-left">
                      <a href="#slide-out" data-target="slide-out" class="sidenav-trigger"><i class="fa fa-bars"></i></a>

                  </div>
              </div>
              <div class="col s6">
                  <div class="content-center">
                      <a href="index.html"><h1>{{ config('app.name') }}</h1></a>
                  </div>
              </div>
              <div class="col s3">
                  <div class="content-right">
                      <a href="reservation.html"><i class="fa fa-clipboard"></i></a>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- end navbar -->

    <!-- <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <!-- <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <!-- <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            '@'yield('content')
        </main> -->
    <!-- </div>  -->
    <!-- sidebar -->
    <div class="sidebar-panel">
        <ul id="slide-out" class="collapsible sidenav side-left side-nav">
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="images/bg-user.html" alt="">
                    </div>
                    <h2><span></span>{{ config('app.name') }}</h2>
                    <p>Cafe & Restaurant</p>
                </div>
            </li>
            <li><a href="#!"><i class="fa fa-home"></i>Home</a></li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-list"></i>Menu<span><i class="fa fa-caret-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="menu-list.html">Menu</a></li>
                        <li><a href="menu-details.html">Menu Details</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-user-circle-o"></i>Chef<span><i class="fa fa-caret-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="chef.html">Chef</a></li>
                        <li><a href="chef-details.html">Chef Details</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-user"></i>Profile<span><i class="fa fa-caret-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="edit-profile.html">Edit Profile</a></li>
                        <li><a href="forgot-password.html">Forgot Password</a></li>
                        <li><a href="reset-password.html">Reset Password</a></li>
                        <li><a href="login.html">Sign In</a></li>
                        <li><a href="#!.html">Logout</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-file"></i>Pages<span><i class="fa fa-caret-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="about.html">About</a></li>
                        <li><a href="gallery.html">Gallery</a></li>
                        <li><a href="testimonial.html">Testimonial</a></li>
                        <li><a href="pricing-table.html">Pricing Table</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="register.html">Register</a></li>
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-tags"></i>Category<span><i class="fa fa-caret-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="category.html">Category</a></li>
                        <li><a href="category-details.html">Category Details</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-shopping-cart"></i>Shop<span><i class="fa fa-caret-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="category.html">Category</a></li>
                        <li><a href="cart.html">Cart</a></li>
                        <li><a href="checkout.html">Checkout</a></li>
                        <li><a href="done-process.html">Done</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-rss"></i>Blog<span><i class="fa fa-caret-right right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="blog.html">Blog</a></li>
                        <li><a href="blog-single.html">Blog Single</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="reservation.html"><i class="fa fa-book"></i>Reservation</a></li>
            <li><a href="open-hours.html"><i class="fa fa-clock-o"></i>Open Hours</a></li>
            <li><a href="contact.html"><i class="fa fa-envelope"></i>Contact</a></li>
            <li><a href="login.html"><i class="fa fa-sign-in"></i>Login</a></li>
            <li><a href="register.html"><i class="fa fa-user-plus"></i>Register</a></li>
            <li><a href="#!"><i class="fa fa-sign-out"></i>Logout</a></li>
        </ul>
    </div>
    <!-- end sidebar -->
    <!-- <main class="py-4"> -->
        @yield('content')
    <!-- </main> -->
    <!-- footer -->
    <footer>
        <div class="container">
            <div class="desc">
                <p>58 Poland Street, London</p>
                <span>United Kingdom</span>
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
  </body>
</html>
