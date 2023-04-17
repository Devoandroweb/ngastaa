
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.19.0/firebase-app.js";
import { getMessaging, onMessage, getToken } from "https://www.gstatic.com/firebasejs/9.19.0/firebase-messaging.js";

var firebaseConfig = {
    apiKey: "AIzaSyCfGUdQ5Sd9LS5wmxe-IA4k47DGoBEV7eg",
    authDomain: "app-absensi-and-payroll.firebaseapp.com",
    projectId: "app-absensi-and-payroll",
    storageBucket: "app-absensi-and-payroll.appspot.com",
    messagingSenderId: "146204970389",
    appId: "1:146204970389:web:0859640e7126a7f3ab3a9c",
    measurementId: "G-FX27LM1XVY"
  };


// Inisialisasi Firebase
// const app = initializeApp(firebaseConfig);
const app = initializeApp(firebaseConfig);
// Dapatkan instance messaging dari Firebase
const messaging = getMessaging(app);

// Minta izin untuk menerima pesan
getToken(messaging, { vapidKey: 'BJABEArzIap2Vc8kosjlLFtQRsVi2m9s6yug-lv7yrIqzcmVdIlvOWRqswapCPhNHK_qplDIutMtCZp8upt3YcY' })
  .then((currentToken) => {
    if (currentToken) {
      // Token berhasil didapatkan
      console.log("Token FCM:", currentToken);
    } else {
      // Gagal mendapatkan token
      console.log("Gagal mendapatkan token FCM");
    }
  })
  .catch((error) => {
    console.error("Error dalam meminta izin FCM:", error);
  });

  Notification.requestPermission().then((permission) => {
    if (permission === 'granted') {
      console.log('Notification permission granted.');
      // TODO(developer): Retrieve a registration token for use with FCM.
      // ...
    } else {
      console.log('Unable to get permission to notify.');
    }
  });
// Menambahkan event listener untuk menerima pesan
onMessage(messaging, (payload) => {
  console.log('Pesan diterima:', payload);
});