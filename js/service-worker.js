// self.addEventListener('push', function(event) {
//   if (event.data) {
//     var data = event.data.json();
//     self.registration.showNotification(data.title,data);
//     console.log('This push event has data: ', event.data.text());
//   } else {
//     console.log('This push event has no data.');
//   }
// });

(() => {
  'use strict'

  const WebPush = {
    init () {
      self.addEventListener('push', this.notificationPush.bind(this))
      self.addEventListener('notificationclick', this.notificationClick.bind(this))
      self.addEventListener('notificationclose', this.notificationClose.bind(this))
    },

    /**
     * Handle notification push event.
     *
     * https://developer.mozilla.org/en-US/docs/Web/Events/push
     *
     * @param {NotificationEvent} event
     */
    notificationPush (event) {
      if (!(self.Notification && self.Notification.permission === 'granted')) {
        return
      }

      // https://developer.mozilla.org/en-US/docs/Web/API/PushMessageData
      if (event.data) {
        event.waitUntil(
          this.sendNotification(event.data.json())
        )
      }
    },

    /**
     * Handle notification click event.
     *
     * https://developer.mozilla.org/en-US/docs/Web/Events/notificationclick
     *
     * @param {NotificationEvent} event
     */
    notificationClick (event) {
      // console.log(event.notification)

      if(event.action === 'view_app') {
        console.log(event)
        console.log(event.data)
      }else if(event.action === 'yes') {
        this.mark(event.notification,1);
      }else if(event.action === 'no') {
        this.mark(event.notification,0);
      }else{
        self.clients.openWindow('/cvs')
        this.notificationClose(event)
      }
    },

    /**
     * Handle notification close event (Chrome 50+, Firefox 55+).
     *
     * https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerGlobalScope/onnotificationclose
     *
     * @param {NotificationEvent} event
     */
    notificationClose (event) {
      self.registration.pushManager.getSubscription().then(subscription => {
        if (subscription) {
          this.dismissNotification(event, subscription)
        }
      })
    },

    /**
     * Send notification to the user.
     *
     * https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerRegistration/showNotification
     *
     * @param {PushMessageData|Object} data
     */
    sendNotification (data) {
      return self.registration.showNotification(data.title, data)
    },

    mark(datas, option){
      const data = {'attendance': option, 'user_id': datas.data.user_id, 'event_id': datas.data.event_id, '_token': datas.data.token}
      fetch(datas.data.url, {
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        method: 'POST',
        body: JSON.stringify(data)
      })
      datas.close();
    },

    /**
     * Send request to server to dismiss a notification.
     *
     * @param  {NotificationEvent} event
     * @param  {String} subscription.endpoint
     * @return {Response}
     */
    dismissNotification ({notification }, { endpoint }) {
      if (!notification.data || !notification.data.id) {
        return
      }

      const data = new FormData()
      data.append('endpoint', endpoint)
      // Send a request to the server to mark the notification as read.
      fetch(`/cvs/attendance/mark`, {
        method: 'POST',
        body: data
      })
    }
  }

  WebPush.init()
})()
