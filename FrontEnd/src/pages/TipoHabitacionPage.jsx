import { useState, useEffect } from "react";
import tipoHabitacionService from "../services/tipoHabitacionService";
import { VolverButton } from "../components/Buttons";

const TipoHabitacionPage = () => {
  const [tipos, setTipos] = useState([]);
  const [nuevoTipo, setNuevoTipo] = useState({ nombre: "", descripcion: "" });
  const [modoEdicion, setModoEdicion] = useState(false);
  const [tipoEditando, setTipoEditando] = useState(null);

  useEffect(() => {
    cargarTipos();
  }, []);

  const cargarTipos = () => {
    tipoHabitacionService.getAll()
      .then(data => setTipos(data))
      .catch(err => console.error("Error al obtener tipos de habitación:", err));
  };

  const handleChange = e => {
    const { name, value } = e.target;
    if (modoEdicion) {
      setTipoEditando({ ...tipoEditando, [name]: value });
    } else {
      setNuevoTipo({ ...nuevoTipo, [name]: value });
    }
  };

  const handleInsert = async () => {
    const { nombre, descripcion } = nuevoTipo;
    if (!nombre || !descripcion) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await tipoHabitacionService.create(nuevoTipo);
      setNuevoTipo({ nombre: "", descripcion: "" });
      cargarTipos();
    } catch {
      alert("Error al insertar tipo de habitación.");
    }
  };

  const handleDelete = async idTipo => {
    if (!window.confirm("¿Seguro que desea eliminar este tipo de habitación?")) return;
    try {
      await tipoHabitacionService.remove(idTipo);
      cargarTipos();
    } catch {
      alert("Error al eliminar tipo de habitación.");
    }
  };

  const iniciarEdicion = item => {
    setModoEdicion(true);
    setTipoEditando({ ...item });
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setTipoEditando(null);
  };

  const handleUpdate = async () => {
    const { idTipo, nombre, descripcion } = tipoEditando;
    if (!nombre || !descripcion) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await tipoHabitacionService.update(tipoEditando);
      cancelarEdicion();
      cargarTipos();
    } catch {
      alert("Error al actualizar tipo de habitación.");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Módulo de Tipos de Habitación</h2>
      <VolverButton />

      <div style={{ marginBottom: "20px" }}>
        <input
          type="text"
          name="nombre"
          placeholder="Nombre"
          value={modoEdicion ? tipoEditando.nombre : nuevoTipo.nombre}
          onChange={handleChange}
        />
        <input
          type="text"
          name="descripcion"
          placeholder="Descripción"
          value={modoEdicion ? tipoEditando.descripcion : nuevoTipo.descripcion}
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
          {tipos.length > 0 ? (
            tipos.map(item => (
              <tr key={item.idTipo}>
                <td>{item.idTipo}</td>
                <td>{item.nombre}</td>
                <td>{item.descripcion}</td>
                <td>
                  <button onClick={() => iniciarEdicion(item)}>Actualizar</button>
                  <button onClick={() => handleDelete(item.idTipo)}>Eliminar</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="4">No hay tipos de habitación disponibles.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default TipoHabitacionPage;
