//register service worker
function registerServiceWorker () {
  if (!('serviceWorker' in navigator)) {
    console.log('Service workers aren\'t supported in this browser.')
    return
  }

  navigator.serviceWorker.register('/sw.js')
    .then(() => this.initialiseServiceWorker())
}

//initialize
function initialiseServiceWorker () {
  if (!('showNotification' in ServiceWorkerRegistration.prototype)) {
    console.log('Notifications aren\'t supported.')
    return
  }

  if (Notification.permission === 'denied') {
    console.log('The user has blocked notifications.')
    return
  }

  if (!('PushManager' in window)) {
    console.log('Push messaging isn\'t supported.')
    return
  }

  navigator.serviceWorker.ready.then(registration => {
    registration.pushManager.getSubscription()
      .then(subscription => {

        if (!subscription) {
          console.log('Not Subscribed.')
          return
        }

        this.updateSubscription(subscription)

        this.isPushEnabled = true
      })
      .catch(e => {
        console.log('Error during getSubscription()', e)
      })
  })
}

//ask for permission
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
      throw new Error('We weren\'t granted permission.');
    }
    else{
      subscribeUserToPush();
    }
  });
}

//
function subscribeUserToPush () {
  navigator.serviceWorker.ready.then(registration => {
    const options = { userVisibleOnly: true }
    const vapidPublicKey = window.Laravel.vapidPublicKey

    if (vapidPublicKey) {
      options.applicationServerKey = this.urlBase64ToUint8Array(vapidPublicKey)
    }

    registration.pushManager.subscribe(options)
      .then(subscription => {
        this.isPushEnabled = true
        this.pushButtonDisabled = false

        this.updateSubscription(subscription)
      })
      .catch(e => {
        if (Notification.permission === 'denied') {
          console.log('Permission for Notifications was denied')
          this.pushButtonDisabled = true
        } else {
          console.log('Unable to subscribe to push.', e)
          this.pushButtonDisabled = false
        }
      })
  })
}

//send subscription to back end
function updateSubscription (subscription) {
  const key = subscription.getKey('p256dh')
  const token = subscription.getKey('auth')

  const data = {
    endpoint: subscription.endpoint,
    key: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
    token: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null
  }

  return fetch('api/save-subscription/{{Auth::user()->id}}', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  })
  .then(function(response) {
    if (!response.ok) {
      throw new Error('Bad status code from server.');
    }
    return response.json();
  })
  .then(function(responseData) {
    if (!(responseData.data && responseData.data.success)) {
      throw new Error('Bad response from server.');
    }
  });
}

 /**
 * Unsubscribe from push notifications.
 */
function unsubscribe () {
  navigator.serviceWorker.ready.then(registration => {
    registration.pushManager.getSubscription().then(subscription => {
      if (!subscription) {
        this.isPushEnabled = false
        this.pushButtonDisabled = false
        return
      }

      subscription.unsubscribe().then(() => {
        this.deleteSubscription(subscription)

        this.isPushEnabled = false
        this.pushButtonDisabled = false
      }).catch(e => {
        console.log('Unsubscription error: ', e)
        this.pushButtonDisabled = false
      })
    }).catch(e => {
      console.log('Error thrown while unsubscribing.', e)
    })
  })
}

/**
 * Send a requst to the server to delete user's subscription.
 *
 * @param {PushSubscription} subscription
 */
function deleteSubscription (subscription) {
  $.ajax.post('/subscriptions/delete', { endpoint: subscription.endpoint })
    .then(() => { this.loading = false })
}

/**
 * Send a request to the server for a push notification.
 */
function sendNotification () {

  $.ajax.post('/notifications')
    .catch(error => console.log(error))
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
