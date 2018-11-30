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
                    <div class="dropdown">
            					<a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-clipboard"></i></a>
            					<div class="dropdown-menu dropdown-menu-right text-center">
            					  <h5 class="p-b-10">Push Notification</h5>
            					  <div class="dropdown-divider"></div>
            					  <button type="button" onclick="askPermission();" class="btn btn-success">Subscribe</button>
            					</div>
          				  </div>
                      <!-- <a href="#" onclick="askPermission();"><i class="fa fa-clipboard">Notification Subscription</i></a> -->
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
                        <img src="push.png" alt="">
                    </div>
                    <h2 class="text-danger"><span></span>{{ config('app.name') }}</h2>
                    <p class="text-danger">Church Validation Management System</p>
                </div>
            </li>
            <hr>
            @auth
            <li><a href="{{route('home')}}"><i class="fa fa-home fa-spin"></i>Home</a></li>
            <li>
                <div class="collapsible-header">
                    <i class="fa fa-file fa-spin"></i>Attendance<span><i class="fa fa-caret-right right fa-spin"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a class="" href="{{route('attendance.history')}}"><i class="fa fa-table fa-spin"></i>History</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="{{route('profile')}}"><i class="fa fa-user-circle-o fa-spin"></i>Profile</a></li>
            @if(Auth::user()->Admin())
              <li>
                <div class="collapsible-header">
                    <i class="fa fa-lock fa-spin"></i>Admin<span><i class="fa fa-caret-right right fa-spin"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                      <li><a href="{{route('event')}}"><i class="fa fa-lock fa-spin"></i>Event</a></li>
                      <li><a href="{{route('report')}}"><i class="icofont icofont-chart-histogram fa-spin"></i>Report</a></li>
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
    <div class="segments-page">
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
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <!-- <script src="{{URL::asset('js/script.js')}}"></script> -->
    @yield('jslink')


    @yield('script')
    <script type="text/javascript">
      function toggleAble(element,bool){
    		$(element).prop('disabled', bool);
    		// $(element).find('#loader').show();
    		let $this = $(element);
    		var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
    		if (bool) {
    			$this.data('original-text', $($this).html());
    			$this.html(loadingText);
    		}else{
    			$this.html($this.data('original-text'))
    		}
    	}
      $(document).ready(function(){
        $(".card-header-right .icofont-rounded-down").on('click',function(){
          var $this=$(this);var port=$($this.parents('.card'));
          var card=$(port).children('.card-block').slideToggle();$(this).toggleClass("icon-up").fadeIn('slow');
        });
          $(".icofont-refresh").on('mouseenter mouseleave',function(){
            $(this).toggleClass("rotate-refresh").fadeIn('slow');
          });
      });
      //push section
      var _token = '{{ csrf_token() }}'
      var _registration = null;
      registerServiceWorker();
      askPermission()
      function registerServiceWorker() {
        if (!('serviceWorker' in navigator)) {
          console.log('Service workers aren\'t supported in this browser.')
          return
        }
        return navigator.serviceWorker.register('js/service-worker.js')
        .then(function(registration) {
          console.log('Service worker successfully registered.');
          _registration = registration;
          return registration;
        })
        .catch(function(err) {
          console.error('Unable to register service worker.', err);
        });
      }

      function askPermission() {
        return new Promise(function(resolve, reject) {
          const permissionResult = Notification.requestPermission(function(result) {
            resolve(result);
          });
          if (permissionResult) {
            permissionResult.then(resolve, reject);
          }
        })
        .then(function(permissionResult) {
          if (permissionResult !== 'granted') {
            throw new Error('Service worker not granted permission.');
          }
          else{
            subscribeUserToPush();
          }
        });
      }

      function subscribeUserToPush() {
        getSWRegistration()
        .then(function(registration) {
          console.log(registration);
          const subscribeOptions = {
            userVisibleOnly: true,
              applicationServerKey: urlBase64ToUint8Array(
              "{{env('VAPID_PUBLIC_KEY')}}"
            )
          };
        return registration.pushManager.subscribe(subscribeOptions);
        })
        .then(function(pushSubscription) {
          console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
          updateSubscription(pushSubscription);
          return pushSubscription;
        });
      }

      function getSWRegistration(){
        var promise = new Promise(function(resolve, reject) {
          // do a thing, possibly async, then…
          if (_registration != null) {
            resolve(_registration);
          }
          else {
            reject(Error("It broke"));
          }
        });
        return promise;
      }

      /**
       * Subscribe for push notifications.
       */
      function subscribe () {
        navigator.serviceWorker.ready.then(registration => {
          const options = { userVisibleOnly: true }
          const vapidPublicKey = window.Laravel.vapidPublicKey

          if (vapidPublicKey) {
            options.applicationServerKey = urlBase64ToUint8Array(vapidPublicKey)
          }

          registration.pushManager.subscribe(options)
            .then(subscription => {

              updateSubscription(subscription)
            })
            .catch(e => {
              if (Notification.permission === 'denied') {
                console.log('Permission for Notifications was denied')
              } else {
                console.log('Unable to subscribe to push.', e)
              }
            })
        })
      }

      /**
       * Unsubscribe from push notifications.
       */
      function unsubscribe () {
        navigator.serviceWorker.ready.then(registration => {
          registration.pushManager.getSubscription().then(subscription => {
            if (!subscription) {
              isPushEnabled = false
              pushButtonDisabled = false
              return
            }

            subscription.unsubscribe().then(() => {
              deleteSubscription(subscription)

            }).catch(e => {
              console.log('Unsubscription error: ', e)
            })
          }).catch(e => {
            console.log('Error thrown while unsubscribing.', e)
          })
        })
      }

      /**
       * Toggle push notifications subscription.
       */
      function togglePush () {
        if (isPushEnabled) {
          unsubscribe()
        } else {
          subscribe()
        }
      }

      /**
       * Send a request to the server to update user's subscription.
       *
       * @param {PushSubscription} subscription
       */
      function updateSubscription (subscription) {
        const key = subscription.getKey('p256dh')
        const token = subscription.getKey('auth')

        const data = {
          endpoint: subscription.endpoint,
          key: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
          token: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null,
          _token: _token
        }

        $.ajax({
          url: "{{route('subscription.update')}}",
          type: "post",
          data: data, dataType: "json", encode: true
        })
          .then(() => {  })
      }

      /**
       * Send a requst to the server to delete user's subscription.
       *
       * @param {PushSubscription} subscription
       */
      function deleteSubscription (subscription) {
        $.ajax({
          url: "{{route('subscription.delete')}}",
          type: "post",
          dataType: "json", encode: true,
          data: { endpoint: subscription.endpoint }
        })
        .then(() => { })
      }

      /**
       * Send a request to the server for a push notification.
       */
      function sendNotification () {
        $.ajax({
          url: '{{route("notification")}}',
          type: "post",
          dataType: "json", encode: true,
          data: {_token: _token}
        })
          .error(error => console.log(error))
          .then(() => {  })
      }

      /**
       * https://github.com/Minishlink/physbook/blob/02a0d5d7ca0d5d2cc6d308a3a9b81244c63b3f14/app/Resources/public/js/app.js#L177
       *
       * @param  {String} base64String
       * @return {Uint8Array}
       */
      function urlBase64ToUint8Array (base64String) {
          const padding = '='.repeat((4 - base64String.length % 4) % 4);
          const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/')

          const rawData = window.atob(base64)
          const outputArray = new Uint8Array(rawData.length)

          for (let i = 0; i < rawData.length; ++i) {
              outputArray[i] = rawData.charCodeAt(i)
          }

          return outputArray
      }
    </script>
  </body>
</html>
