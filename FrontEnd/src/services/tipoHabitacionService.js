// src/service/tipoHabitacionService.js

import axios from 'axios';
const API_URL = 'http://localhost:8080/2025/Sistema/Sistema/Sistema-de-Hoteler-a/api/tipoHabitacion.php';

const tipoHabitacionService = {
  // Obtener todos los tipos de habitación
  getAll: async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Error al obtener tipos de habitación:', error);
      throw error;
    }
  },

  // Obtener un tipo por ID
  getById: async (idTipo) => {
    try {
      const response = await axios.get(`${API_URL}?id=${idTipo}`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener tipo de habitación por ID:', error);
      throw error;
    }
  },

  // Crear un nuevo tipo de habitación
  create: async ({ nombre, descripcion }) => {
    try {
      const payload = { nombre, descripcion };
      const response = await axios.post(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al crear tipo de habitación:', error);
      throw error;
    }
  },

  // Modificar tipo existente
  update: async ({ idTipo, nombre, descripcion }) => {
    try {
      const payload = { idTipo, nombre, descripcion };
      const response = await axios.put(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al actualizar tipo de habitación:', error);
      throw error;
    }
  },

  // Eliminar tipo por ID
  remove: async (idTipo) => {
    try {
      const response = await axios.delete(API_URL, {
        data: { idTipo }
      });
      return response.data;
    } catch (error) {
      console.error('Error al eliminar tipo de habitación:', error);
      throw error;
    }
  },
};

export default tipoHabitacionService;
