import { useState, useEffect } from "react";
import habitacionService from "../services/habitacionService";
import { VolverButton } from "../components/Buttons";

const HabitacionPage = () => {
  const [habitaciones, setHabitaciones] = useState([]);
  const [nuevaHabitacion, setNuevaHabitacion] = useState({
    numero: "",
    idTipo: "",
    precio: ""
  });
  const [modoEdicion, setModoEdicion] = useState(false);
  const [habitacionEditando, setHabitacionEditando] = useState(null);

  useEffect(() => {
    cargarHabitaciones();
  }, []);

  const cargarHabitaciones = () => {
    habitacionService.getAll()
      .then((data) => setHabitaciones(data))
      .catch((error) => console.error("Error al obtener habitaciones:", error));
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    if (modoEdicion) {
      setHabitacionEditando({ ...habitacionEditando, [name]: value });
    } else {
      setNuevaHabitacion({ ...nuevaHabitacion, [name]: value });
    }
  };

  const handleInsert = async () => {
    const { numero, idTipo, precio } = nuevaHabitacion;
    if (!numero || !idTipo || !precio) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await habitacionService.create(nuevaHabitacion);
      setNuevaHabitacion({ numero: "", idTipo: "", precio: "" });
      cargarHabitaciones();
    } catch (error) {
      alert("Error al insertar habitación.");
    }
  };

  const handleDelete = async (idHabitacion) => {
    if (!window.confirm("¿Seguro que desea eliminar esta habitación?")) return;
    try {
      await habitacionService.remove(idHabitacion);
      cargarHabitaciones();
    } catch (error) {
      alert("Error al eliminar habitación.");
    }
  };

  const iniciarEdicion = (item) => {
    setModoEdicion(true);
    setHabitacionEditando({ ...item });
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setHabitacionEditando(null);
  };

  const handleUpdate = async () => {
    const { idHabitacion, numero, idTipo, precio } = habitacionEditando;
    if (!numero || !idTipo || !precio) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await habitacionService.update(habitacionEditando);
      cancelarEdicion();
      cargarHabitaciones();
    } catch (error) {
      alert("Error al actualizar habitación.");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Módulo de Habitaciones</h2>
      <VolverButton />

      <div style={{ marginBottom: "20px" }}>
        <input
          type="text"
          name="numero"
          placeholder="Número"
          value={modoEdicion ? habitacionEditando.numero : nuevaHabitacion.numero}
          onChange={handleChange}
        />
        <input
          type="text"
          name="idTipo"
          placeholder="ID Tipo"
          value={modoEdicion ? habitacionEditando.idTipo : nuevaHabitacion.idTipo}
          onChange={handleChange}
        />
        <input
          type="number"
          name="precio"
          placeholder="Precio"
          value={modoEdicion ? habitacionEditando.precio : nuevaHabitacion.precio}
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
            <th>Número</th>
            <th>ID Tipo</th>
            <th>Precio</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {habitaciones.length > 0 ? (
            habitaciones.map((item) => (
              <tr key={item.idHabitacion}>
                <td>{item.idHabitacion}</td>
                <td>{item.numero}</td>
                <td>{item.idTipo}</td>
                <td>{item.precio}</td>
                <td>
                  <button onClick={() => iniciarEdicion(item)}>Actualizar</button>
                  <button onClick={() => handleDelete(item.idHabitacion)}>Eliminar</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="5">No hay habitaciones disponibles.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default HabitacionPage;
