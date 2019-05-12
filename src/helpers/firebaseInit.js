import firebase from "firebase/app";
import "firebase/auth";
import "firebase/firestore";
import "firebase/firebase-functions";
import firebaseConfig from "./credentials.js";

firebase.initializeApp(firebaseConfig);

export const db = firebase.firestore();
export const auth = firebase.auth();

export default firebase;
