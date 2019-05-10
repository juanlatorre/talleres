import firebase from "firebase/app";
import "firebase/auth";

var firebaseConfig = {
  apiKey: "AIzaSyAMf4SKxT5eoI6MotAyFx6a1HX2PnQxnak",
  authDomain: "talleres-16e00.firebaseapp.com",
  databaseURL: "https://talleres-16e00.firebaseio.com",
  projectId: "talleres-16e00",
  storageBucket: "talleres-16e00.appspot.com",
  messagingSenderId: "912820578646",
  appId: "1:912820578646:web:8fa5ff85f10ab8c1"
};

firebase.initializeApp(firebaseConfig);

export default firebase;
