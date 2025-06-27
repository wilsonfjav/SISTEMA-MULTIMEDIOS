import { useState, useEffect } from "react";
import consumoService from "../services/consumoService";
import { VolverButton } from "../components/Buttons";

const ConsumoPage = () => {
  const [consumos, setConsumos] = useState([]);
  const [nuevoConsumo, setNuevoConsumo] = useState({
    idReservacion: "",
    idServicio: "",
    cantidad: "",
    fecha: ""
  });
  const [modoEdicion, setModoEdicion] = useState(false);
  const [consumoEditando, setConsumoEditando] = useState(null);

  useEffect(() => {
    cargarConsumos();
  }, []);

  const cargarConsumos = () => {
    consumoService.getAll()
      .then((data) => setConsumos(data))
      .catch((error) => console.error("Error al obtener consumos:", error));
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    if (modoEdicion) {
      setConsumoEditando({ ...consumoEditando, [name]: value });
    } else {
      setNuevoConsumo({ ...nuevoConsumo, [name]: value });
    }
  };

  const handleInsert = async () => {
    const { idReservacion, idServicio, cantidad, fecha } = nuevoConsumo;
    if (!idReservacion || !idServicio || !cantidad || !fecha) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await consumoService.create(nuevoConsumo);
      setNuevoConsumo({ idReservacion: "", idServicio: "", cantidad: "", fecha: "" });
      cargarConsumos();
    } catch (error) {
      alert("Error al insertar consumo.");
    }
  };

  const handleDelete = async (idConsumo) => {
    if (!window.confirm("¿Está seguro que desea eliminar este consumo?")) return;
    try {
      await consumoService.remove(idConsumo);
      cargarConsumos();
    } catch (error) {
      alert("Error al eliminar consumo.");
    }
  };

  const iniciarEdicion = (item) => {
    setModoEdicion(true);
    setConsumoEditando({ ...item });
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setConsumoEditando(null);
  };

  const handleUpdate = async () => {
    const { idReservacion, idServicio, cantidad, fecha } = consumoEditando;
    if (!idReservacion || !idServicio || !cantidad || !fecha) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await consumoService.update(consumoEditando);
      cancelarEdicion();
      cargarConsumos();
    } catch (error) {
      alert("Error al actualizar consumo.");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Módulo de Consumo</h2>
      <VolverButton />

      <div style={{ marginBottom: "20px" }}>
        <input
          type="text"
          name="idReservacion"
          placeholder="ID Reservación"
          value={modoEdicion ? consumoEditando.idReservacion : nuevoConsumo.idReservacion}
          onChange={handleChange}
        />
        <input
          type="text"
          name="idServicio"
          placeholder="ID Servicio"
          value={modoEdicion ? consumoEditando.idServicio : nuevoConsumo.idServicio}
          onChange={handleChange}
        />
        <input
          type="number"
          name="cantidad"
          placeholder="Cantidad"
          value={modoEdicion ? consumoEditando.cantidad : nuevoConsumo.cantidad}
          onChange={handleChange}
        />
        <input
          type="date"
          name="fecha"
          placeholder="Fecha"
          value={
            modoEdicion
              ? consumoEditando.fecha?.split(' ')[0] || ''
              : nuevoConsumo.fecha?.split(' ')[0] || ''
          }
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
            <th>Reservación</th>
            <th>Servicio</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {consumos.length > 0 ? (
            consumos.map((item) => (
              <tr key={item.idConsumo}>
                <td>{item.idConsumo}</td>
                <td>{item.idReservacion}</td>
                <td>{item.idServicio}</td>
                <td>{item.cantidad}</td>
                <td>{item.fecha}</td>
                <td>
                  <button onClick={() => iniciarEdicion(item)}>Actualizar</button>
                  <button onClick={() => handleDelete(item.idConsumo)}>Eliminar</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="6">No hay consumos disponibles.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default ConsumoPage;
