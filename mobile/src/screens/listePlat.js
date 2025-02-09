import React, { useState, useEffect } from 'react';
import { View, Text, FlatList, Button, StyleSheet } from 'react-native';
import * as Network from 'expo-network'; // Importation du module expo-network

const PlatList = () => {
  const [plats, setPlats] = useState([]);
  const [error, setError] = useState(null);
  const [ipAddress, setIpAddress] = useState('');

  // Fonction pour récupérer l'adresse IP locale
  const getLocalIp = async () => {
    try {
      const ip = await Network.getIpAddressAsync(); // Utilisation d'expo-network pour obtenir l'adresse IP
      if (ip) {
        setIpAddress(ip);
        console.log('IP Address:', ip);
      } else {
        console.error('No IP address found');
        setError('No IP address available');
      }
    } catch (error) {
      console.error('Error retrieving IP address:', error);
      setError('Error retrieving IP address');
    }
  };

  // Fonction pour récupérer les plats depuis le serveur
  const getPlats = async () => {
    try {
      if (!ipAddress) {
        throw new Error('No IP address available');
      }
  
      const url = `http://${ipAddress}:5001/estprojet/us-central1/api/plat`;
      console.log('Fetching plats from:', url); // Vérifie l'URL avant de faire la requête
  
      const response = await fetch(url);
      console.log('Response Status:', response.status); // Vérifie le statut de la réponse
  
      if (!response.ok) {
        const errorDetails = await response.text(); // Récupère le message d'erreur du serveur
        throw new Error(`Failed to fetch plats: ${errorDetails}`);
      }
  
      const data = await response.json();
      console.log('Fetched plats:', data); // Vérifie les données récupérées
      setPlats(data);
      setError(null); // Réinitialiser l'erreur en cas de succès
    } catch (error) {
      console.error('Error fetching plats:', error.message);
      setError(error.message);
    }
  };
  

  // Effet pour récupérer l'adresse IP au démarrage
  useEffect(() => {
    getLocalIp();
  }, []);

  // Effet pour charger les plats dès qu'une adresse IP est obtenue
  useEffect(() => {
    if (ipAddress) {
      getPlats();
    }
  }, [ipAddress]);

  // Rendu du composant
  return (
    <View style={styles.container}>
      <Text style={styles.title}>Liste des Plats</Text>
      {error && <Text style={styles.error}>Error: {error}</Text>}
      {plats.length === 0 ? (
        <Text>No plats available</Text>
      ) : (
        <FlatList
          data={plats}
          keyExtractor={(item, index) => index.toString()}
          renderItem={({ item }) => (
            <View style={styles.platItem}>
              <Text>{item.nom}</Text>
              <Text>{item.prix}</Text>
            </View>
          )}
        />
      )}
      <Button title="Reload" onPress={getPlats} />
    </View>
  );
};

// Styles du composant
const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
  },
  title: {
    fontSize: 20,
    fontWeight: 'bold',
    marginBottom: 16,
  },
  error: {
    color: 'red',
    marginBottom: 16,
  },
  platItem: {
    padding: 16,
    borderBottomWidth: 1,
    borderBottomColor: '#ccc',
  },
});

export default PlatList;
