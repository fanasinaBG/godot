// screens/LoginScreen.js
import React, { useState } from 'react';
import { View, Text, TextInput, Button, StyleSheet, Alert } from 'react-native';
import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';
import{ signUp, signIn, logOut }from './../services/authService';

const LoginScreen = ({ navigation }) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

//   const handleLogin = async () => {
//     try {
//       const response = await axios.post('https://your-api-url.com/login', {
//         email,
//         password,
//       });

//       if (response.data.token) {
//         await AsyncStorage.setItem('userToken', response.data.token);
//         navigation.navigate('Home');
//       } else {
//         Alert.alert('Erreur', 'Identifiants incorrects');
//       }
//     } catch (error) {
//       Alert.alert('Erreur', 'Une erreur est survenue lors de la connexion');
//     }
//   };
  const handleSignIn = () => {
    signIn(email, password)
      .then(() =>{ 
        Alert.alert("Connexion réussie !");
        navigation.navigate('List');
      }
      )
      .catch((error) => Alert.alert("Erreur :", error.message));
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Connexion</Text>
      <TextInput
        style={styles.input}
        placeholder="Email"
        value={email}
        onChangeText={setEmail}
        keyboardType="email-address"
        autoCapitalize="none"
      />
      <TextInput
        style={styles.input}
        placeholder="Mot de passe"
        value={password}
        onChangeText={setPassword}
        secureTextEntry
      />
      {/*  */}
      <Button 
        title="Se connecter" 
        /*onPress={handleLogin}   */
        onPress={handleSignIn}

      />
      <Button
        title="S'inscrire"
        onPress={() => navigation.navigate('Inscription')}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    padding: 16,
  },
  title: {
    fontSize: 24,
    marginBottom: 16,
    textAlign: 'center',
  },
  input: {
    height: 40,
    borderColor: 'gray',
    borderWidth: 1,
    marginBottom: 12,
    paddingHorizontal: 8,
  },
});

export default LoginScreen;