import { useState, useEffect } from "react";
import mantenimientoHabitacionService from "../services/mantenimientoHabitacionService";
import { VolverButton } from "../components/Buttons";

const MantenimientoHabitacionPage = () => {
  const [mantenimientos, setMantenimientos] = useState([]);
  const [nuevoMant, setNuevoMant] = useState({
    idHabitacion: "",
    descripcion: "",
    fecha: ""
  });
  const [modoEdicion, setModoEdicion] = useState(false);
  const [mantEditando, setMantEditando] = useState(null);

  useEffect(() => {
    cargarMantenimientos();
  }, []);

  const cargarMantenimientos = () => {
    mantenimientoHabitacionService.getAll()
      .then(data => setMantenimientos(data))
      .catch(err => console.error("Error al obtener mantenimientos:", err));
  };

  const handleChange = e => {
    const { name, value } = e.target;
    if (modoEdicion) {
      setMantEditando({ ...mantEditando, [name]: value });
    } else {
      setNuevoMant({ ...nuevoMant, [name]: value });
    }
  };

  const handleInsert = async () => {
    const { idHabitacion, descripcion, fecha } = nuevoMant;
    if (!idHabitacion || !descripcion || !fecha) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await mantenimientoHabitacionService.create(nuevoMant);
      setNuevoMant({ idHabitacion: "", descripcion: "", fecha: "" });
      cargarMantenimientos();
    } catch (error) {
      alert("Error al insertar mantenimiento.");
    }
  };

  const handleDelete = async idMantenimiento => {
    if (!window.confirm("¿Seguro que desea eliminar este mantenimiento?")) return;
    try {
      await mantenimientoHabitacionService.remove(idMantenimiento);
      cargarMantenimientos();
    } catch (error) {
      alert("Error al eliminar mantenimiento.");
    }
  };

  const iniciarEdicion = item => {
    setModoEdicion(true);
    setMantEditando({ ...item });
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setMantEditando(null);
  };

  const handleUpdate = async () => {
    const { idMantenimiento, idHabitacion, descripcion, fecha } = mantEditando;
    if (!idHabitacion || !descripcion || !fecha) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await mantenimientoHabitacionService.update(mantEditando);
      cancelarEdicion();
      cargarMantenimientos();
    } catch (error) {
      alert("Error al actualizar mantenimiento.");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Módulo de Mantenimiento de Habitaciones</h2>
      <VolverButton />

      <div style={{ marginBottom: "20px" }}>
        <input
          type="text"
          name="idHabitacion"
          placeholder="ID Habitación"
          value={modoEdicion ? mantEditando.idHabitacion : nuevoMant.idHabitacion}
          onChange={handleChange}
        />
        <input
          type="text"
          name="descripcion"
          placeholder="Descripción"
          value={modoEdicion ? mantEditando.descripcion : nuevoMant.descripcion}
          onChange={handleChange}
        />
        <input
          type="date"
          name="fecha"
          placeholder="Fecha"
          value={modoEdicion ? mantEditando.fecha : nuevoMant.fecha}
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
            <th>ID Habitación</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {mantenimientos.length > 0 ? (
            mantenimientos.map(item => (
              <tr key={item.idMantenimiento}>
                <td>{item.idMantenimiento}</td>
                <td>{item.idHabitacion}</td>
                <td>{item.descripcion}</td>
                <td>{item.fecha}</td>
                <td>
                  <button onClick={() => iniciarEdicion(item)}>Actualizar</button>
                  <button onClick={() => handleDelete(item.idMantenimiento)}>Eliminar</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="5">No hay mantenimientos registrados.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default MantenimientoHabitacionPage;
