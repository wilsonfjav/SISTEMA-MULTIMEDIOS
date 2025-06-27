import axios from 'axios';

// Ajusta esta URL según tu backend PHP real
const API_URL = 'http://localhost:8080/2025/Sistema/Sistema/Sistema-de-Hoteler-a/api/habitacionPaquete.php';

const habitacionPaqueteService = {
  // Obtener todos
  getAll: async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data; // Debe devolver un array de objetos
    } catch (error) {
      console.error('Error al obtener habitacion-paquete:', error);
      throw error;
    }
  },

  // Obtener por ID
  getById: async (idHabitacionPaquete) => {
    try {
      const response = await axios.get(`${API_URL}?id=${idHabitacionPaquete}`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener habitacion-paquete por ID:', error);
      throw error;
    }
  },

  // Crear nuevo registro
  create: async ({ idHabitacion, idPaquete }) => {
    try {
      const payload = { idHabitacion, idPaquete };
      const response = await axios.post(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al crear habitacion-paquete:', error);
      throw error;
    }
  },

  // Actualizar
  update: async ({ idHabitacionPaquete, idHabitacion, idPaquete }) => {
    try {
      const payload = { idHabitacionPaquete, idHabitacion, idPaquete };
      const response = await axios.put(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al actualizar habitacion-paquete:', error);
      throw error;
    }
  },

  // Eliminar
  remove: async (idHabitacionPaquete) => {
    try {
      const response = await axios.delete(API_URL, {
        data: { idHabitacionPaquete },
      });
      return response.data;
    } catch (error) {
      console.error('Error al eliminar habitacion-paquete:', error);
      throw error;
    }
  },
};

export default habitacionPaqueteService;
