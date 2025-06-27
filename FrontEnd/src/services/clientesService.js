

import axios from 'axios';

// Ajusta esta URL a tu ruta real de la API PHP
// ✅ URL corregida según tu estructura y puerto
const API_URL = 'http://localhost/SISTEMA-MULTIMEDIOS/Sistema-de-Hoteler-a/api/clientes.php';

const clientesService = {

  //Obtener todos los clientes
  getAll: async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data; // Devuelve [{ idCliente, nombre, correo }, ...]
    } catch (error) {
      console.error('Error al obtener clientes:', error);
      throw error;
    }
  },

  // Obtener un cliente por ID
  getById: async (idCliente) => {
    try {
      const response = await axios.get(`${API_URL}?id=${idCliente}`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener cliente por ID:', error);
      throw error;
    }
  },

  // Crear un cliente nuevo
  create: async ({ nombre, correo }) => {
    try {
      const payload = { nombre, correo };
      const response = await axios.post(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al crear cliente:', error);
      throw error;
    }
  },

  // Modificar cliente existente
  update: async ({ idCliente, nombre, correo }) => {
    try {
      const payload = { idCliente, nombre, correo };
      const response = await axios.put(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al actualizar cliente:', error);
      throw error;
    }
  },

  // Eliminar cliente por ID
  remove: async (idCliente) => {
    try {
      const response = await axios.delete(API_URL, {
        data: { idCliente }
      });
      return response.data;
    } catch (error) {
      console.error('Error al eliminar cliente:', error);
      throw error;
    }
  },

};

export default clientesService;
