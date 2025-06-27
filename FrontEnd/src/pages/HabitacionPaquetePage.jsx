import { useState, useEffect } from "react";
import habitacionPaqueteService from "../services/habitacionPaqueteService";
import { VolverButton } from "../components/Buttons";

const HabitacionPaquetePage = () => {
  const [habitacionPaquetes, setHabitacionPaquetes] = useState([]);
  const [nuevoHP, setNuevoHP] = useState({
    idHabitacion: "",
    idPaquete: ""
  });
  const [modoEdicion, setModoEdicion] = useState(false);
  const [hpEditando, setHpEditando] = useState(null);

  useEffect(() => {
    cargarHP();
  }, []);

  const cargarHP = () => {
    habitacionPaqueteService.getAll()
      .then((data) => setHabitacionPaquetes(data))
      .catch((error) => console.error("Error al obtener habitación-paquetes:", error));
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    if (modoEdicion) {
      setHpEditando({ ...hpEditando, [name]: value });
    } else {
      setNuevoHP({ ...nuevoHP, [name]: value });
    }
  };

  const handleInsert = async () => {
    const { idHabitacion, idPaquete } = nuevoHP;
    if (!idHabitacion || !idPaquete) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await habitacionPaqueteService.create(nuevoHP);
      setNuevoHP({ idHabitacion: "", idPaquete: "" });
      cargarHP();
    } catch (error) {
      alert("Error al insertar registro.");
    }
  };

  const handleDelete = async (idHabitacionPaquete) => {
    if (!window.confirm("¿Seguro que desea eliminar este registro?")) return;
    try {
      await habitacionPaqueteService.remove(idHabitacionPaquete);
      cargarHP();
    } catch (error) {
      alert("Error al eliminar registro.");
    }
  };

  const iniciarEdicion = (item) => {
    setModoEdicion(true);
    setHpEditando({ ...item });
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setHpEditando(null);
  };

  const handleUpdate = async () => {
    const { idHabitacionPaquete, idHabitacion, idPaquete } = hpEditando;
    if (!idHabitacion || !idPaquete) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await habitacionPaqueteService.update(hpEditando);
      cancelarEdicion();
      cargarHP();
    } catch (error) {
      alert("Error al actualizar registro.");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Módulo de Habitación-Paquete</h2>
      <VolverButton />

      <div style={{ marginBottom: "20px" }}>
        <input
          type="text"
          name="idHabitacion"
          placeholder="ID Habitación"
          value={modoEdicion ? hpEditando.idHabitacion : nuevoHP.idHabitacion}
          onChange={handleChange}
        />
        <input
          type="text"
          name="idPaquete"
          placeholder="ID Paquete"
          value={modoEdicion ? hpEditando.idPaquete : nuevoHP.idPaquete}
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
            <th>ID Paquete</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {habitacionPaquetes.length > 0 ? (
            habitacionPaquetes.map((item) => (
              <tr key={item.idHabitacionPaquete}>
                <td>{item.idHabitacionPaquete}</td>
                <td>{item.idHabitacion}</td>
                <td>{item.idPaquete}</td>
                <td>
                  <button onClick={() => iniciarEdicion(item)}>Actualizar</button>
                  <button onClick={() => handleDelete(item.idHabitacionPaquete)}>Eliminar</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="4">No hay registros disponibles.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default HabitacionPaquetePage;
