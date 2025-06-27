// src/service/usuarioService.js

import axios from 'axios';

const API_URL = 'http://localhost:8080/2025/Sistema/Sistema/Sistema-de-Hoteler-a/api/usuario.php';

const usuarioService = {

  // Obtener todos los usuarios
  getAll: async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Error al obtener usuarios:', error);
      throw error;
    }
  },

  // Obtener un usuario por ID
  getById: async (idUsuario) => {
    try {
      const response = await axios.get(`${API_URL}?id=${idUsuario}`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener usuario por ID:', error);
      throw error;
    }
  },

  // Crear un usuario nuevo
  create: async ({ nombreUsuario, claveHash, rol, estado }) => {
    try {
      const payload = { nombreUsuario, claveHash, rol, estado };
      const response = await axios.post(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al crear usuario:', error);
      throw error;
    }
  },

  // Modificar un usuario existente
  update: async ({ idUsuario, nombreUsuario, claveHash, rol, estado }) => {
    try {
      const payload = { idUsuario, nombreUsuario, claveHash, rol, estado };
      const response = await axios.put(API_URL, payload);
      return response.data;
    } catch (error) {
      console.error('Error al actualizar usuario:', error);
      throw error;
    }
  },

  // Eliminar un usuario por ID
  remove: async (idUsuario) => {
    try {
      const response = await axios.delete(API_URL, {
        data: { idUsuario }
      });
      return response.data;
    } catch (error) {
      console.error('Error al eliminar usuario:', error);
      throw error;
    }
  },

};

export default usuarioService;
