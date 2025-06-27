// src/service/reservacionService.js
import axios from 'axios';

const API_URL = 'http://localhost:8080/2025/Sistema/Sistema/Sistema-de-Hoteler-a/api/reservacion.php';

const reservacionService = {
  // Obtener todas las reservaciones
  getAll: async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Error al obtener reservaciones:', error);
      throw error;
    }
  },

  // Obtener reservación por ID
  getById: async (idReservacion) => {
    try {
      const response = await axios.get(`${API_URL}?id=${idReservacion}`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener reservación por ID:', error);
      throw error;
    }
  },

  // Crear nueva reservación
  create: async ({ idCliente, fechaInicio, fechaFin, estado }) => {
    try {
      const payload = { idCliente, fechaInicio, fechaFin, estado };
      const response = await axios.post(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al crear reservación:', error);
      throw error;
    }
  },

  // Actualizar reservación
  update: async ({ idReservacion, idCliente, fechaInicio, fechaFin, estado }) => {
    try {
      const payload = { idReservacion, idCliente, fechaInicio, fechaFin, estado };
      const response = await axios.put(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al actualizar reservación:', error);
      throw error;
    }
  },

  // Eliminar reservación
  remove: async (idReservacion) => {
    try {
      const response = await axios.delete(API_URL, {
        data: { idReservacion }
      });
      return response.data;
    } catch (error) {
      console.error('Error al eliminar reservación:', error);
      throw error;
    }
  },
};

export default reservacionService;
