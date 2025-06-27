import axios from 'axios';

const API_URL = 'http://localhost:8080/2025/Sistema/Sistema/Sistema-de-Hoteler-a/api/mantenimientoHabitacion.php';

const mantenimientoHabitacionService = {

  // Obtener todos los mantenimientos
  getAll: async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Error al obtener mantenimientos:', error);
      throw error;
    }
  },

  // Obtener un mantenimiento por ID
  getById: async (idMantenimiento) => {
    try {
      const response = await axios.get(`${API_URL}?id=${idMantenimiento}`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener mantenimiento por ID:', error);
      throw error;
    }
  },

  // Crear un nuevo mantenimiento
  create: async ({ idHabitacion, descripcion, fecha }) => {
    try {
      const payload = { idHabitacion, descripcion, fecha };
      const response = await axios.post(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al crear mantenimiento:', error);
      throw error;
    }
  },

  // Actualizar mantenimiento
  update: async ({ idMantenimiento, idHabitacion, descripcion, fecha }) => {
    try {
      const payload = { idMantenimiento, idHabitacion, descripcion, fecha };
      const response = await axios.put(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al actualizar mantenimiento:', error);
      throw error;
    }
  },

  // Eliminar mantenimiento
  remove: async (idMantenimiento) => {
    try {
      const response = await axios.delete(API_URL, {
        data: { idMantenimiento }
      });
      return response.data;
    } catch (error) {
      console.error('Error al eliminar mantenimiento:', error);
      throw error;
    }
  },
};

export default mantenimientoHabitacionService;
