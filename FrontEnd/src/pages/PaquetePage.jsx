import { useState, useEffect } from "react";
import paqueteService from "../services/paqueteService";
import { VolverButton } from "../components/Buttons";

const PaquetePage = () => {
  const [paquetes, setPaquetes] = useState([]);
  const [nuevoPaquete, setNuevoPaquete] = useState({
    nombre: "",
    descripcion: "",
    precio: ""
  });
  const [modoEdicion, setModoEdicion] = useState(false);
  const [paqueteEditando, setPaqueteEditando] = useState(null);

  useEffect(() => {
    cargarPaquetes();
  }, []);

  const cargarPaquetes = () => {
    paqueteService.getAll()
      .then((data) => setPaquetes(data))
      .catch((error) => console.error("Error al obtener paquetes:", error));
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    if (modoEdicion) {
      setPaqueteEditando({ ...paqueteEditando, [name]: value });
    } else {
      setNuevoPaquete({ ...nuevoPaquete, [name]: value });
    }
  };

  const handleInsert = async () => {
    const { nombre, descripcion, precio } = nuevoPaquete;
    if (!nombre || !descripcion || !precio) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await paqueteService.create(nuevoPaquete);
      setNuevoPaquete({ nombre: "", descripcion: "", precio: "" });
      cargarPaquetes();
    } catch (error) {
      alert("Error al insertar paquete.");
    }
  };

  const handleDelete = async (idPaquete) => {
    if (!window.confirm("¿Seguro que desea eliminar este paquete?")) return;
    try {
      await paqueteService.remove(idPaquete);
      cargarPaquetes();
    } catch (error) {
      alert("Error al eliminar paquete.");
    }
  };

  const iniciarEdicion = (item) => {
    setModoEdicion(true);
    setPaqueteEditando({ ...item });
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setPaqueteEditando(null);
  };

  const handleUpdate = async () => {
    const { idPaquete, nombre, descripcion, precio } = paqueteEditando;
    if (!nombre || !descripcion || !precio) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await paqueteService.update(paqueteEditando);
      cancelarEdicion();
      cargarPaquetes();
    } catch (error) {
      alert("Error al actualizar paquete.");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Módulo de Paquetes</h2>
      <VolverButton />

      <div style={{ marginBottom: "20px" }}>
        <input
          type="text"
          name="nombre"
          placeholder="Nombre"
          value={modoEdicion ? paqueteEditando.nombre : nuevoPaquete.nombre}
          onChange={handleChange}
        />
        <input
          type="text"
          name="descripcion"
          placeholder="Descripción"
          value={modoEdicion ? paqueteEditando.descripcion : nuevoPaquete.descripcion}
          onChange={handleChange}
        />
        <input
          type="number"
          name="precio"
          placeholder="Precio"
          value={modoEdicion ? paqueteEditando.precio : nuevoPaquete.precio}
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
            <th>Precio</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {paquetes.length > 0 ? (
            paquetes.map((item) => (
              <tr key={item.idPaquete}>
                <td>{item.idPaquete}</td>
                <td>{item.nombre}</td>
                <td>{item.descripcion}</td>
                <td>{item.precio}</td>
                <td>
                  <button onClick={() => iniciarEdicion(item)}>Actualizar</button>
                  <button onClick={() => handleDelete(item.idPaquete)}>Eliminar</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="5">No hay paquetes disponibles.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default PaquetePage;
