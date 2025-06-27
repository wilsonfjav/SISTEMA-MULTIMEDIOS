import axios from 'axios';

// Ruta a tu API de paquetes
const API_URL = 'http://localhost:8080/2025/Sistema/Sistema/Sistema-de-Hoteler-a/api/paquete.php';

const paqueteService = {
  // Obtener todos los paquetes
  getAll: async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data; // Asegúrate que el controlador devuelve un array plano
    } catch (error) {
      console.error('Error al obtener paquetes:', error);
      throw error;
    }
  },

  // Obtener paquete por ID
  getById: async (idPaquete) => {
    try {
      const response = await axios.get(`${API_URL}?id=${idPaquete}`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener paquete por ID:', error);
      throw error;
    }
  },

  // Crear nuevo paquete
  create: async ({ nombre, descripcion, precio }) => {
    try {
      const payload = { nombre, descripcion, precio };
      const response = await axios.post(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al crear paquete:', error);
      throw error;
    }
  },

  // Actualizar paquete
  update: async ({ idPaquete, nombre, descripcion, precio }) => {
    try {
      const payload = { idPaquete, nombre, descripcion, precio };
      const response = await axios.put(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al actualizar paquete:', error);
      throw error;
    }
  },

  // Eliminar paquete
  remove: async (idPaquete) => {
    try {
      const response = await axios.delete(API_URL, {
        data: { idPaquete },
      });
      return response.data;
    } catch (error) {
      console.error('Error al eliminar paquete:', error);
      throw error;
    }
  },
};

export default paqueteService;
