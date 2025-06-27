import { useState, useEffect } from "react";
import reservacionService from "../services/reservacionService";
import { VolverButton } from "../components/Buttons";

const ReservacionPage = () => {
  const [reservaciones, setReservaciones] = useState([]);
  const [nuevaReserva, setNuevaReserva] = useState({
    idCliente: "",
    fechaInicio: "",
    fechaFin: "",
    estado: ""
  });
  const [modoEdicion, setModoEdicion] = useState(false);
  const [reservaEditando, setReservaEditando] = useState(null);

  useEffect(() => {
    cargarReservaciones();
  }, []);

  const cargarReservaciones = () => {
    reservacionService.getAll()
      .then(data => setReservaciones(data))
      .catch(err => console.error("Error al obtener reservaciones:", err));
  };

  const handleChange = e => {
    const { name, value } = e.target;
    if (modoEdicion) {
      setReservaEditando({ ...reservaEditando, [name]: value });
    } else {
      setNuevaReserva({ ...nuevaReserva, [name]: value });
    }
  };

  const handleInsert = async () => {
    const { idCliente, fechaInicio, fechaFin, estado } = nuevaReserva;
    if (!idCliente || !fechaInicio || !fechaFin || !estado) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await reservacionService.create(nuevaReserva);
      setNuevaReserva({ idCliente: "", fechaInicio: "", fechaFin: "", estado: "" });
      cargarReservaciones();
    } catch (error) {
      alert("Error al insertar reservación.");
    }
  };

  const handleDelete = async idReservacion => {
    if (!window.confirm("¿Seguro que desea eliminar esta reservación?")) return;
    try {
      await reservacionService.remove(idReservacion);
      cargarReservaciones();
    } catch (error) {
      alert("Error al eliminar reservación.");
    }
  };

  const iniciarEdicion = item => {
    setModoEdicion(true);
    setReservaEditando({ ...item });
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setReservaEditando(null);
  };

  const handleUpdate = async () => {
    const { idReservacion, idCliente, fechaInicio, fechaFin, estado } = reservaEditando;
    if (!idCliente || !fechaInicio || !fechaFin || !estado) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await reservacionService.update(reservaEditando);
      cancelarEdicion();
      cargarReservaciones();
    } catch (error) {
      alert("Error al actualizar reservación.");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Módulo de Reservaciones</h2>
      <VolverButton />

      <div style={{ marginBottom: "20px" }}>
        <input
          type="text"
          name="idCliente"
          placeholder="ID Cliente"
          value={modoEdicion ? reservaEditando.idCliente : nuevaReserva.idCliente}
          onChange={handleChange}
        />
        <input
          type="date"
          name="fechaInicio"
          placeholder="Fecha Inicio"
          value={modoEdicion ? reservaEditando.fechaInicio : nuevaReserva.fechaInicio}
          onChange={handleChange}
        />
        <input
          type="date"
          name="fechaFin"
          placeholder="Fecha Fin"
          value={modoEdicion ? reservaEditando.fechaFin : nuevaReserva.fechaFin}
          onChange={handleChange}
        />
        <input
          type="text"
          name="estado"
          placeholder="Estado"
          value={modoEdicion ? reservaEditando.estado : nuevaReserva.estado}
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
            <th>ID Cliente</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {reservaciones.length > 0 ? (
            reservaciones.map(item => (
              <tr key={item.idReservacion}>
                <td>{item.idReservacion}</td>
                <td>{item.idCliente}</td>
                <td>{item.fechaInicio}</td>
                <td>{item.fechaFin}</td>
                <td>{item.estado}</td>
                <td>
                  <button onClick={() => iniciarEdicion(item)}>Actualizar</button>
                  <button onClick={() => handleDelete(item.idReservacion)}>Eliminar</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="6">No hay reservaciones disponibles.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default ReservacionPage;
