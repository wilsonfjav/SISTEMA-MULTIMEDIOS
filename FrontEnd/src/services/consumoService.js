import axios from 'axios';

// Ajusta esta URL a tu ruta real de la API PHP
const API_URL = 'http://localhost/SISTEMA-MULTIMEDIOS/Sistema-de-Hoteler-a/api/consumo.php';

const consumoService = {

  // Obtener todos los registros de consumo
  getAll: async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data; // Asegúrate de que la API devuelva un array
    } catch (error) {
      console.error('Error al obtener consumos:', error);
      throw error;
    }
  },

  // Obtener un consumo por ID
  getById: async (idConsumo) => {
    try {
      const response = await axios.get(`${API_URL}?id=${idConsumo}`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener consumo por ID:', error);
      throw error;
    }
  },

  // Crear un nuevo consumo
  create: async ({ idReservacion, idServicio, cantidad, fecha }) => {
    try {
      const payload = { idReservacion, idServicio, cantidad, fecha };
      const response = await axios.post(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al crear consumo:', error);
      throw error;
    }
  },

  // Actualizar un consumo existente
  update: async ({ idConsumo, idReservacion, idServicio, cantidad, fecha }) => {
    try {
      const payload = { idConsumo, idReservacion, idServicio, cantidad, fecha };
      const response = await axios.put(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al actualizar consumo:', error);
      throw error;
    }
  },

  // Eliminar un consumo por ID
  remove: async (idConsumo) => {
    return axios.delete(API_URL, {
      headers: { "Content-Type": "application/json" },
      data: { idConsumo }
    }).then(res => res.data);
  },

};

export default consumoService;
