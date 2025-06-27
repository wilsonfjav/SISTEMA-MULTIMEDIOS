import axios from 'axios';

const API_URL = 'http://localhost:8080/2025/Sistema/Sistema/Sistema-de-Hoteler-a/api/detalleReservacion.php';

const detalleReservacionService = {
  getAll: async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Error al obtener detalles de reservación:', error);
      throw error;
    }
  },

  getById: async (idDetalle) => {
    try {
      const response = await axios.get(`${API_URL}?id=${idDetalle}`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener detalle por ID:', error);
      throw error;
    }
  },

  create: async ({ idReservacion, idHabitacion }) => {
    try {
      const payload = { idReservacion, idHabitacion };
      const response = await axios.post(API_URL, payload, {
        headers: { "Content-Type": "application/json" }
      });
      return response.data;
    } catch (error) {
      console.error('Error al crear detalle:', error);
      throw error;
    }
  },

  update: async ({ idDetalle, idReservacion, idHabitacion }) => {
    try {
      const payload = { idDetalle, idReservacion, idHabitacion };
      const response = await axios.put(API_URL, payload, {
        headers: { "Content-Type": "application/json" }
      });
      return response.data;
    } catch (error) {
      console.error('Error al actualizar detalle:', error);
      throw error;
    }
  },

  remove: async (idDetalle) => {
    try {
      const response = await axios.delete(API_URL, {
        headers: { "Content-Type": "application/json" },
        data: { idDetalle }
      });
      return response.data;
    } catch (error) {
      console.error('Error al eliminar detalle:', error);
      throw error;
    }
  },
};

export default detalleReservacionService;
