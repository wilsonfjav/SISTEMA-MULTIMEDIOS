import { useState, useEffect } from "react";
import clientesService from "../services/clientesService";
import { VolverButton } from "../components/Buttons";


const ClientePage = () => {
  const [clientes, setClientes] = useState([]);
  const [nuevoCliente, setNuevoCliente] = useState({ nombre: "", correo: "" });
  const [modoEdicion, setModoEdicion] = useState(false);
  const [clienteEditando, setClienteEditando] = useState(null);

  useEffect(() => {
    cargarClientes();
  }, []);

  const cargarClientes = () => {
    clientesService.getAll()
      .then((data) => setClientes(data))
      .catch((error) => console.error("Error al obtener clientes:", error));
  };

  const handleChange = (e) => {
    const { name, value } = e.target;

    if (modoEdicion) {
      setClienteEditando({ ...clienteEditando, [name]: value });
    } else {
      setNuevoCliente({ ...nuevoCliente, [name]: value });
    }
  };

  const handleInsert = async () => {
    if (!nuevoCliente.nombre || !nuevoCliente.correo) {
      alert("Debe ingresar nombre y correo.");
      return;
    }

    try {
      await clientesService.create(nuevoCliente);
      setNuevoCliente({ nombre: "", correo: "" });
      cargarClientes();
    } catch (error) {
      alert("Error al insertar cliente.");
    }
  };

  const handleDelete = async (idCliente) => {
    if (!window.confirm("¿Está seguro que desea eliminar este cliente?")) return;

    try {
      await clientesService.remove(idCliente);
      cargarClientes();
    } catch (error) {
      alert("Error al eliminar cliente.");
    }
  };

  const iniciarEdicion = (cliente) => {
    setModoEdicion(true);
    setClienteEditando({ ...cliente });
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setClienteEditando(null);
  };

  const handleUpdate = async () => {
    if (!clienteEditando.nombre || !clienteEditando.correo) {
      alert("Debe ingresar nombre y correo.");
      return;
    }

    try {
      await clientesService.update(clienteEditando);
      cancelarEdicion();
      cargarClientes();
    } catch (error) {
      alert("Error al actualizar cliente.");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Módulo de Clientes</h2>
      <VolverButton />

      <div style={{ marginBottom: "20px" }}>
        <input
          type="text"
          name="nombre"
          placeholder="Nombre"
          value={modoEdicion ? clienteEditando?.nombre : nuevoCliente.nombre}
          onChange={handleChange}
        />
        <input
          type="email"
          name="correo"
          placeholder="Correo"
          value={modoEdicion ? clienteEditando?.correo : nuevoCliente.correo}
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
            <th>Correo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {clientes.length > 0 ? (
            clientes.map((item) => (
              <tr key={item.idCliente}>
                <td>{item.idCliente}</td>
                <td>{item.nombre}</td>
                <td>{item.correo}</td>
                <td>
                  <button onClick={() => iniciarEdicion(item)}>Actualizar</button>
                  <button onClick={() => handleDelete(item.idCliente)}>Eliminar</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="4">No hay clientes disponibles.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default ClientePage;