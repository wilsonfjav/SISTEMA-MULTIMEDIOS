import axios from 'axios';

// Ajusta esta URL a tu ruta real de la API PHP
const API_URL = 'http://localhost:8080/2025/Sistema/Sistema/Sistema-de-Hoteler-a/api/habitacion.php';

const habitacionService = {

  // Obtener todas las habitaciones
  getAll: async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Error al obtener habitaciones:', error);
      throw error;
    }
  },

  // Obtener una habitación por ID
  getById: async (idHabitacion) => {
    try {
      const response = await axios.get(`${API_URL}?id=${idHabitacion}`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener habitación:', error);
      throw error;
    }
  },

  // Crear una nueva habitación
  create: async ({ numero, idTipo, precio }) => {
    try {
      const payload = { numero, idTipo, precio };
      const response = await axios.post(API_URL, payload, {
        headers: { 'Content-Type': 'application/json' }
      });
      return response.data;
    } catch (error) {
      console.error('Error al crear habitación:', error);
      throw error;
    }
  },

  // Actualizar habitación
  update: async ({ idHabitacion, numero, idTipo, precio }) => {
    try {
      const payload = { idHabitacion, numero, idTipo, precio };
      const response = await axios.put(API_URL, payload, {
        headers: { 'Content-Type': 'application/json' }
      });
      return response.data;
    } catch (error) {
      console.error('Error al actualizar habitación:', error);
      throw error;
    }
  },

  // Eliminar habitación
  remove: async (idHabitacion) => {
    try {
      const response = await axios.delete(API_URL, {
        headers: { 'Content-Type': 'application/json' },
        data: { idHabitacion }
      });
      return response.data;
    } catch (error) {
      console.error('Error al eliminar habitación:', error);
      throw error;
    }
  }

};

export default habitacionService;
