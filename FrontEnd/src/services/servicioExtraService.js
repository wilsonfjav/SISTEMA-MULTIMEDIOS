// src/service/servicioExtraService.js

import axios from 'axios';

const API_URL = 'http://localhost:8080/2025/Sistema/Sistema/Sistema-de-Hoteler-a/api/servicioExtra.php';

const servicioExtraService = {
  // Obtener todos los servicios extra
  getAll: async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data; // Esperamos un array de objetos { idServicio, nombre, descripcion }
    } catch (error) {
      console.error('Error al obtener servicios extra:', error);
      throw error;
    }
  },

  // Obtener un servicio extra por ID
  getById: async (idServicio) => {
    try {
      const response = await axios.get(`${API_URL}?id=${idServicio}`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener servicio extra por ID:', error);
      throw error;
    }
  },

  // Crear nuevo servicio extra
  create: async ({ nombre, descripcion }) => {
    try {
      const payload = { nombre, descripcion };
      const response = await axios.post(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al crear servicio extra:', error);
      throw error;
    }
  },

  // Actualizar servicio extra existente
  update: async ({ idServicio, nombre, descripcion }) => {
    try {
      const payload = { idServicio, nombre, descripcion };
      const response = await axios.put(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al actualizar servicio extra:', error);
      throw error;
    }
  },

  // Eliminar servicio extra por ID
  remove: async (idServicio) => {
    try {
      const response = await axios.delete(API_URL, {
        data: { idServicio }
      });
      return response.data;
    } catch (error) {
      console.error('Error al eliminar servicio extra:', error);
      throw error;
    }
  },
};

export default servicioExtraService;
