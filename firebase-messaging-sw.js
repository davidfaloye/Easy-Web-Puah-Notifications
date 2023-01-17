importScripts('https://www.gstatic.com/firebasejs/3.9.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.9.0/firebase-messaging.js');


firebase.initializeApp({
'messagingSenderId': '785129191486',
'apiKey': 'AAAAts1YuD4:APA91bG19p7paiyXRfGmar3-oqH_iJg_l6Aq-VvSDj-PxRU88gB0_5_KX4J20BulZ4Oge_oMBAuQ-qGbwpuocDzT7TWYkTMQDSo42-6-r0JkapUK81qoRel-8ey1WDTj5acDhhSjQJOf	',
'projectId': 'notifier-4f0de',
});
//apikey is server key in cloud messaging
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
console.log('[firebase-messaging-sw.js] Received background message ', payload);
// Customize notification here
const notificationTitle = payload['data']['pinpoint.notification.title'];
const notificationBody = payload['data']['pinpoint.notification.body'];
const notificationUrl = payload['data']['pinpoint.url'];//redirect url when user clicks on the notofication
const notificationIcon = "https://.../imgs/LOGO-1.png";//logo you want displayed when notification arrives
const notificationOptions = {
body: notificationBody,
data: notificationUrl,
icon: notificationIcon
};

return self.registration.showNotification(notificationTitle,
notificationOptions);


});



self.addEventListener('notificationclick', function (event) {
  event.notification.close();
  event.waitUntil(self.clients.openWindow(event.notification.data));
});

