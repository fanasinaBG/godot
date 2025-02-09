import { auth } from "./../../firebaseConfig";
import { createUserWithEmailAndPassword, signInWithEmailAndPassword, signOut } from "firebase/auth";

// Fonction pour l'inscription
export const signUp = (email, password) => {
  return createUserWithEmailAndPassword(auth, email, password);
};

// Fonction pour la connexion
export const signIn = (email, password) => {
  return signInWithEmailAndPassword(auth, email, password);
};

// Fonction pour la déconnexion
export const logOut = () => {
  return signOut(auth);
};
