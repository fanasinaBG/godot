import { initializeApp } from "firebase/app";
import { getAuth, initializeAuth, getReactNativePersistence } from "firebase/auth";
import AsyncStorage from '@react-native-async-storage/async-storage'; // Import AsyncStorage

const firebaseConfig = {
  apiKey: "AIzaSyB8u82ZyzcCLc9y-7NBLSLrZHT6QzSFDsE",
  authDomain: "estprojet.firebaseapp.com",
  projectId: "estprojet",
  storageBucket: "estprojet.appspot.com",
  messagingSenderId: "696271945279",
  appId: "1:696271945279:web:faa955db09512f6184828a",
  measurementId: "G-4QJDP718WL"
};

// Initialiser Firebase
const app = initializeApp(firebaseConfig);

// Initialiser Firebase Auth avec persistance via AsyncStorage
const auth = initializeAuth(app, {
  persistence: getReactNativePersistence(AsyncStorage)
});

export { app, auth };
