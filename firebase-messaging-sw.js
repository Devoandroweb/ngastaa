import { initializeApp } from "https://www.gstatic.com/firebasejs/9.19.0/firebase-app.js";
import { getMessaging, onMessage, getToken, onBackgroundMessage } from "https://www.gstatic.com/firebasejs/9.19.0/firebase-messaging.js";

var firebaseConfig = {
    apiKey: "AIzaSyCfGUdQ5Sd9LS5wmxe-IA4k47DGoBEV7eg",
    messagingSenderId: "146204970389",
    
  };

const app = initializeApp(firebaseConfig);

const messaging = getMessaging(app);
onBackgroundMessage(messaging, (payload) => {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
    icon: '/favicon.ico'
  };

  self.registration.showNotification(notificationTitle,
    notificationOptions);
});