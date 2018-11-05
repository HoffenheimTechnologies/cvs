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

      if (event.action === 'some_action') {
        // Do something...
        console.log('manual action')
      } else if(event.action === 'view_app') {
        console.log(event)
      }else if(event.action === 'yes') {
        this.mark(1,event);
      }else if(event.action === 'no') {
        this.mark(0,event);
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

    mark(option, event){
      self.registration.pushManager.getSubscription().then(subscription => {
        if (subscription) {
          console.log(subscription)
          const data = new FormData()
          data.append('attendance', option)
          // data.append('user_id', subscription.data.user_id)
          // data.append('event_id', subscription.data.event_id)
          // Mark the attendance
          fetch('/cvs/attendance/mark/', {
            method: 'POST',
            body: data
          })
        }
      })
      event.notification.close();
    },

    /**
     * Send request to server to dismiss a notification.
     *
     * @param  {NotificationEvent} event
     * @param  {String} subscription.endpoint
     * @return {Response}
     */
    dismissNotification ({ notification }, { endpoint }) {
      if (!notification.data || !notification.data.id) {
        return
      }

      const data = new FormData()
      data.append('endpoint', endpoint)

      // Send a request to the server to mark the notification as read.
      fetch(`/cvs/notifications/${notification.data.id}/dismiss`, {
        method: 'POST',
        body: data
      })
    }
  }

  WebPush.init()
})()
