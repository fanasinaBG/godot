import React, { useState } from 'react';
import { View, Text, FlatList, TouchableOpacity, StyleSheet } from 'react-native';
import { useNavigation } from '@react-navigation/native';

const ListScreen = () => {
    const navigation = useNavigation();
    const [items, setItems] = useState([
        { id: '1', name: 'Item 1' },
        { id: '2', name: 'Item 2' },
        { id: '3', name: 'Item 3' },
        { id: '4', name: 'Item 4' },
        { id: '5', name: 'Item 5' },
    ]);

    const handlePress = (item) => {
        navigation.navigate('Commande', { item });
    };

    const renderItem = ({ item }) => (
        <TouchableOpacity style={styles.item}  onPress={() => handlePress(item)}>
            <Text style={styles.itemText}>{item.name}</Text>
        </TouchableOpacity>
    );

    return (
        <View style={styles.container}>
            <Text style={styles.title}>Liste des Plat</Text>
            <FlatList
                data={items}
                keyExtractor={(item) => item.id}
                renderItem={renderItem}
            />
        </View>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        padding: 20,
        backgroundColor: '#f5f5f5',
    },
    title: {
        fontSize: 24,
        fontWeight: 'bold',
        marginBottom: 20,
        textAlign: 'center',
    },
    item: {
        padding: 15,
        backgroundColor: '#007bff',
        marginVertical: 5,
        borderRadius: 5,
    },
    itemText: {
        color: '#fff',
        fontSize: 18,
    },
});

export default ListScreen;
