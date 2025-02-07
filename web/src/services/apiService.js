import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  headers: {
    'Content-Type': 'application/json',
  },
});

export default {
  login(email, mdp) {
    const data = {
      email: email,
      mdp: mdp
    };
    return apiClient.post('/admins/login', data);
  },


  getClientById(id) {
    return apiClient.get(`/clients/${id}`);
  },

  addClient(client) {
    return apiClient.post('/clients', client);
  },

  updateClient(id, client) {
    return apiClient.put(`/clients/${id}`, client);
  },

  deleteClient(id) {
    return apiClient.delete(`/clients/${id}`);
  },
};
