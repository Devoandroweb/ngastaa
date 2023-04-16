// Import the functions you need from the SDKs you need
// import { initializeApp } from "firebase/app";
// import { getAnalytics } from "firebase/analytics";
// import { getMessaging, getToken } from "firebase/messaging";

import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.19.0/firebase-app.js'
import { getMessaging, getToken } from 'https://www.gstatic.com/firebasejs/9.19.0/firebase-messaging.js'
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyCfGUdQ5Sd9LS5wmxe-IA4k47DGoBEV7eg",
  authDomain: "app-absensi-and-payroll.firebaseapp.com",
  projectId: "app-absensi-and-payroll",
  storageBucket: "app-absensi-and-payroll.appspot.com",
  messagingSenderId: "146204970389",
  appId: "1:146204970389:web:0859640e7126a7f3ab3a9c",
  measurementId: "G-FX27LM1XVY"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// const messaging = getMessaging(app);
const vapidKey = "BJABEArzIap2Vc8kosjlLFtQRsVi2m9s6yug-lv7yrIqzcmVdIlvOWRqswapCPhNHK_qplDIutMtCZp8upt3YcY"
// Get registration token. Initially this makes a network call, once retrieved
// subsequent calls to getToken will return from cache.
const messaging = getMessaging(app);
getToken(messaging, { vapidKey: vapidKey }).then((currentToken) => {
  if (currentToken) {
    // Send the token to your server and update the UI if necessary
    // ...
    console.log('Oke');

  } else {
    // Show permission request UI
    console.log('No registration token available. Request permission to generate one.');
    // ...
  }
}).catch((err) => {
  console.log('An error occurred while retrieving token. ', err);
  // ...
});
