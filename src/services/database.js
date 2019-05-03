import firebase from "firebase";
import store from "@/store";

var config = {
  apiKey: "AIzaSyAfvZK3DswuI972bS20b8Gj6I_y0VDmo4w",
  authDomain: "talleres-cb.firebaseapp.com",
  databaseURL: "https://talleres-cb.firebaseio.com",
  projectId: "talleres-cb",
  storageBucket: "talleres-cb.appspot.com",
  messagingSenderId: "314845540699"
};

const database = firebase.initializeApp(config);

database.login = async (email, password) => {
  try {
    await firebase.auth().signInWithEmailAndPassword(email, password);

    store.commit("setCurrentUser", firebase.auth().currentUser);

    return true;
  } catch (error) {
    return error;
  }
};

export default database;
