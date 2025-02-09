import React from 'react';
import { View, Text, StyleSheet } from 'react-native';

const DetailScreen = ({ route }) => {
    const { item } = route.params;

    return (
        <View style={styles.container}>
            <Text style={styles.title}>Détails de l'élément</Text>
            <Text style={styles.itemText}>ID: {item.id}</Text>
            <Text style={styles.itemText}>Nom: {item.name}</Text>
        </View>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
        padding: 20,
        backgroundColor: '#f5f5f5',
    },
    title: {
        fontSize: 24,
        fontWeight: 'bold',
        marginBottom: 20,
    },
    itemText: {
        fontSize: 18,
        marginBottom: 10,
    },
});

export default DetailScreen;
