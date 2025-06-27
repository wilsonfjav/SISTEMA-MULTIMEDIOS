import { useState, useEffect } from "react";
import servicioExtraService from "../services/servicioExtraService";
import { VolverButton } from "../components/Buttons";

const ServicioExtraPage = () => {
  const [servicios, setServicios] = useState([]);
  const [nuevoServicio, setNuevoServicio] = useState({
    nombre: "",
    descripcion: ""
  });
  const [modoEdicion, setModoEdicion] = useState(false);
  const [servicioEditando, setServicioEditando] = useState(null);

  useEffect(() => {
    cargarServicios();
  }, []);

  const cargarServicios = () => {
    servicioExtraService.getAll()
      .then(data => setServicios(data))
      .catch(err => console.error("Error al obtener servicios extra:", err));
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    if (modoEdicion) {
      setServicioEditando({ ...servicioEditando, [name]: value });
    } else {
      setNuevoServicio({ ...nuevoServicio, [name]: value });
    }
  };

  const handleInsert = async () => {
    const { nombre, descripcion } = nuevoServicio;
    if (!nombre || !descripcion) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await servicioExtraService.create(nuevoServicio);
      setNuevoServicio({ nombre: "", descripcion: "" });
      cargarServicios();
    } catch (error) {
      alert("Error al insertar servicio extra.");
    }
  };

  const handleDelete = async (idServicio) => {
    if (!window.confirm("¿Seguro que desea eliminar este servicio extra?")) return;
    try {
      await servicioExtraService.remove(idServicio);
      cargarServicios();
    } catch (error) {
      alert("Error al eliminar servicio extra.");
    }
  };

  const iniciarEdicion = (item) => {
    setModoEdicion(true);
    setServicioEditando({ ...item });
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setServicioEditando(null);
  };

  const handleUpdate = async () => {
    const { idServicio, nombre, descripcion } = servicioEditando;
    if (!nombre || !descripcion) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await servicioExtraService.update(servicioEditando);
      cancelarEdicion();
      cargarServicios();
    } catch (error) {
      alert("Error al actualizar servicio extra.");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Módulo de Servicios Extra</h2>
      <VolverButton />

      <div style={{ marginBottom: "20px" }}>
        <input
          type="text"
          name="nombre"
          placeholder="Nombre"
          value={modoEdicion ? servicioEditando.nombre : nuevoServicio.nombre}
          onChange={handleChange}
        />
        <input
          type="text"
          name="descripcion"
          placeholder="Descripción"
          value={modoEdicion ? servicioEditando.descripcion : nuevoServicio.descripcion}
          onChange={handleChange}
        />

        {modoEdicion ? (
          <>
            <button onClick={handleUpdate}>Guardar Cambios</button>
            <button onClick={cancelarEdicion}>Cancelar</button>
          </>
        ) : (
          <button onClick={handleInsert}>Insertar</button>
        )}
      </div>

      <table border="1" style={{ margin: "0 auto" }}>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {servicios.length > 0 ? (
            servicios.map(item => (
              <tr key={item.idServicio}>
                <td>{item.idServicio}</td>
                <td>{item.nombre}</td>
                <td>{item.descripcion}</td>
                <td>
                  <button onClick={() => iniciarEdicion(item)}>Actualizar</button>
                  <button onClick={() => handleDelete(item.idServicio)}>Eliminar</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="4">No hay servicios extra disponibles.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default ServicioExtraPage;
