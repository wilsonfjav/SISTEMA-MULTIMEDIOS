import { useState, useEffect } from "react";
import pagoService from "../services/pagoService";
import { VolverButton } from "../components/Buttons";

const PagoPage = () => {
  const [pagos, setPagos] = useState([]);
  const [nuevoPago, setNuevoPago] = useState({
    idReservacion: "",
    monto: "",
    metodoPago: "",
    fechaPago: ""
  });
  const [modoEdicion, setModoEdicion] = useState(false);
  const [pagoEditando, setPagoEditando] = useState(null);

  useEffect(() => {
    cargarPagos();
  }, []);

  const cargarPagos = () => {
    pagoService.getAll()
      .then(data => setPagos(data))
      .catch(err => console.error("Error al obtener pagos:", err));
  };

  const handleChange = e => {
    const { name, value } = e.target;
    if (modoEdicion) {
      setPagoEditando({ ...pagoEditando, [name]: value });
    } else {
      setNuevoPago({ ...nuevoPago, [name]: value });
    }
  };

  const handleInsert = async () => {
    const { idReservacion, monto, metodoPago, fechaPago } = nuevoPago;
    if (!idReservacion || !monto || !metodoPago || !fechaPago) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await pagoService.create(nuevoPago);
      setNuevoPago({ idReservacion: "", monto: "", metodoPago: "", fechaPago: "" });
      cargarPagos();
    } catch (error) {
      alert("Error al insertar pago.");
    }
  };

  const handleDelete = async idPago => {
    if (!window.confirm("¿Seguro que desea eliminar este pago?")) return;
    try {
      await pagoService.remove(idPago);
      cargarPagos();
    } catch (error) {
      alert("Error al eliminar pago.");
    }
  };

  const iniciarEdicion = item => {
    setModoEdicion(true);
    setPagoEditando({ ...item });
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setPagoEditando(null);
  };

  const handleUpdate = async () => {
    const { idPago, idReservacion, monto, metodoPago, fechaPago } = pagoEditando;
    if (!idReservacion || !monto || !metodoPago || !fechaPago) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await pagoService.update(pagoEditando);
      cancelarEdicion();
      cargarPagos();
    } catch (error) {
      alert("Error al actualizar pago.");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Módulo de Pagos</h2>
      <VolverButton />

      <div style={{ marginBottom: "20px" }}>
        <input
          type="text"
          name="idReservacion"
          placeholder="ID Reservación"
          value={modoEdicion ? pagoEditando.idReservacion : nuevoPago.idReservacion}
          onChange={handleChange}
        />
        <input
          type="number"
          name="monto"
          placeholder="Monto"
          value={modoEdicion ? pagoEditando.monto : nuevoPago.monto}
          onChange={handleChange}
        />
        <input
          type="text"
          name="metodoPago"
          placeholder="Método de Pago"
          value={modoEdicion ? pagoEditando.metodoPago : nuevoPago.metodoPago}
          onChange={handleChange}
        />
        <input
          type="date"
          name="fechaPago"
          placeholder="Fecha de Pago"
          value={modoEdicion ? pagoEditando.fechaPago : nuevoPago.fechaPago}
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
            <th>ID Pago</th>
            <th>ID Reservación</th>
            <th>Monto</th>
            <th>Método de Pago</th>
            <th>Fecha de Pago</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {pagos.length > 0 ? (
            pagos.map(item => (
              <tr key={item.idPago}>
                <td>{item.idPago}</td>
                <td>{item.idReservacion}</td>
                <td>{item.monto}</td>
                <td>{item.metodoPago}</td>
                <td>{item.fechaPago}</td>
                <td>
                  <button onClick={() => iniciarEdicion(item)}>Actualizar</button>
                  <button onClick={() => handleDelete(item.idPago)}>Eliminar</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="6">No hay pagos disponibles.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default PagoPage;
