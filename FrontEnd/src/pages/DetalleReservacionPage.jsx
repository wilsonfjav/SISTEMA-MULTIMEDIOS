import { useState, useEffect } from "react";
import detalleReservacionService from "../services/detalleReservacionService";
import { VolverButton } from "../components/Buttons";

const DetalleReservacionPage = () => {
  const [detalles, setDetalles] = useState([]);
  const [nuevoDetalle, setNuevoDetalle] = useState({
    idReservacion: "",
    idHabitacion: ""
  });
  const [modoEdicion, setModoEdicion] = useState(false);
  const [detalleEditando, setDetalleEditando] = useState(null);

  useEffect(() => {
    cargarDetalles();
  }, []);

  const cargarDetalles = () => {
    detalleReservacionService.getAll()
      .then((data) => setDetalles(data))
      .catch((error) => console.error("Error al obtener detalles:", error));
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    if (modoEdicion) {
      setDetalleEditando({ ...detalleEditando, [name]: value });
    } else {
      setNuevoDetalle({ ...nuevoDetalle, [name]: value });
    }
  };

  const handleInsert = async () => {
    const { idReservacion, idHabitacion } = nuevoDetalle;
    if (!idReservacion || !idHabitacion) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await detalleReservacionService.create(nuevoDetalle);
      setNuevoDetalle({ idReservacion: "", idHabitacion: "" });
      cargarDetalles();
    } catch (error) {
      alert("Error al insertar detalle de reservación.");
    }
  };

  const handleDelete = async (idDetalle) => {
    if (!window.confirm("¿Seguro que desea eliminar este detalle?")) return;
    try {
      await detalleReservacionService.remove(idDetalle);
      cargarDetalles();
    } catch (error) {
      alert("Error al eliminar detalle de reservación.");
    }
  };

  const iniciarEdicion = (item) => {
    setModoEdicion(true);
    setDetalleEditando({ ...item });
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setDetalleEditando(null);
  };

  const handleUpdate = async () => {
    const { idDetalle, idReservacion, idHabitacion } = detalleEditando;
    if (!idReservacion || !idHabitacion) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await detalleReservacionService.update(detalleEditando);
      cancelarEdicion();
      cargarDetalles();
    } catch (error) {
      alert("Error al actualizar detalle de reservación.");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Módulo de Detalle de Reservación</h2>
      <VolverButton />

      <div style={{ marginBottom: "20px" }}>
        <input
          type="text"
          name="idReservacion"
          placeholder="ID Reservación"
          value={modoEdicion ? detalleEditando.idReservacion : nuevoDetalle.idReservacion}
          onChange={handleChange}
        />
        <input
          type="text"
          name="idHabitacion"
          placeholder="ID Habitación"
          value={modoEdicion ? detalleEditando.idHabitacion : nuevoDetalle.idHabitacion}
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
            <th>ID Detalle</th>
            <th>ID Reservación</th>
            <th>ID Habitación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {detalles.length > 0 ? (
            detalles.map((item) => (
              <tr key={item.idDetalle}>
                <td>{item.idDetalle}</td>
                <td>{item.idReservacion}</td>
                <td>{item.idHabitacion}</td>
                <td>
                  <button onClick={() => iniciarEdicion(item)}>Actualizar</button>
                  <button onClick={() => handleDelete(item.idDetalle)}>Eliminar</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="4">No hay detalles de reservación disponibles.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default DetalleReservacionPage;
