<script>
var _token = '{{ csrf_token() }}'
var _registration = null;
registerServiceWorker();
askPermission()
function registerServiceWorker() {
  if (!('serviceWorker' in navigator)) {
    console.log('Service workers aren\'t supported in this browser.')
    return
  }
  return navigator.serviceWorker.register('js/sw.js')
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
    .then(() => { alert('subscribed'); })
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
  .then(() => { loading = false })
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
    .then(() => { loading = false })
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
