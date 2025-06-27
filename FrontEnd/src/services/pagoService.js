import axios from 'axios';

// URL del endpoint de tu API para pagos
const API_URL = 'http://localhost:8080/2025/Sistema/Sistema/Sistema-de-Hoteler-a/api/pago.php';

const pagoService = {
  // Obtener todos los pagos
  getAll: async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Error al obtener pagos:', error);
      throw error;
    }
  },

  // Obtener pago por ID
  getById: async (idPago) => {
    try {
      const response = await axios.get(`${API_URL}?id=${idPago}`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener pago por ID:', error);
      throw error;
    }
  },

  // Crear nuevo pago
  create: async ({ idReservacion, monto, metodoPago, fechaPago }) => {
    try {
      const payload = { idReservacion, monto, metodoPago, fechaPago };
      const response = await axios.post(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al crear pago:', error);
      throw error;
    }
  },

  // Actualizar pago existente
  update: async ({ idPago, idReservacion, monto, metodoPago, fechaPago }) => {
    try {
      const payload = { idPago, idReservacion, monto, metodoPago, fechaPago };
      const response = await axios.put(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al actualizar pago:', error);
      throw error;
    }
  },

  // Eliminar pago por ID
  remove: async (idPago) => {
    try {
      const response = await axios.delete(API_URL, {
        data: { idPago }
      });
      return response.data;
    } catch (error) {
      console.error('Error al eliminar pago:', error);
      throw error;
    }
  },
};

export default pagoService;
