importScripts(
    "https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js",
);
importScripts(
    "https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js",
);

const firebaseConfig = {
    apiKey: "AIzaSyCCS4tA3AS-faG_yW6ELauREM1S-O4z5cQ",
    authDomain: "bukusiswa-ec0d6.firebaseapp.com",
    projectId: "bukusiswa-ec0d6",
    storageBucket: "bukusiswa-ec0d6.firebasestorage.app",
    messagingSenderId: "551546808094",
    appId: "1:551546808094:web:c4b939883e0048947acb0f",
    measurementId: "G-ZTVNYKER5N",
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();