import { useState, useEffect } from "react";
import usuarioService from "../services/usuarioService";
import { VolverButton } from "../components/Buttons";

const UsuarioPage = () => {
  const [usuarios, setUsuarios] = useState([]);
  const [nuevoUsuario, setNuevoUsuario] = useState({
    nombreUsuario: "",
    claveHash: "",
    rol: "",
    estado: ""
  });
  const [modoEdicion, setModoEdicion] = useState(false);
  const [usuarioEditando, setUsuarioEditando] = useState(null);

  useEffect(() => {
    cargarUsuarios();
  }, []);

  const cargarUsuarios = () => {
    usuarioService.getAll()
      .then(data => setUsuarios(data))
      .catch(err => console.error("Error al obtener usuarios:", err));
  };

  const handleChange = e => {
    const { name, value } = e.target;
    if (modoEdicion) {
      setUsuarioEditando({ ...usuarioEditando, [name]: value });
    } else {
      setNuevoUsuario({ ...nuevoUsuario, [name]: value });
    }
  };

  const handleInsert = async () => {
    const { nombreUsuario, claveHash, rol, estado } = nuevoUsuario;
    if (!nombreUsuario || !claveHash || !rol || !estado) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await usuarioService.create(nuevoUsuario);
      setNuevoUsuario({ nombreUsuario: "", claveHash: "", rol: "", estado: "" });
      cargarUsuarios();
    } catch {
      alert("Error al insertar usuario.");
    }
  };

  const handleDelete = async idUsuario => {
    if (!window.confirm("¿Seguro que desea eliminar este usuario?")) return;
    try {
      await usuarioService.remove(idUsuario);
      cargarUsuarios();
    } catch {
      alert("Error al eliminar usuario.");
    }
  };

  const iniciarEdicion = item => {
    setModoEdicion(true);
    setUsuarioEditando({ ...item });
  };

  const cancelarEdicion = () => {
    setModoEdicion(false);
    setUsuarioEditando(null);
  };

  const handleUpdate = async () => {
    const { idUsuario, nombreUsuario, claveHash, rol, estado } = usuarioEditando;
    if (!nombreUsuario || !claveHash || !rol || !estado) {
      alert("Debe completar todos los campos.");
      return;
    }
    try {
      await usuarioService.update(usuarioEditando);
      cancelarEdicion();
      cargarUsuarios();
    } catch {
      alert("Error al actualizar usuario.");
    }
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Módulo de Usuarios</h2>
      <VolverButton />

      <div style={{ marginBottom: "20px" }}>
        <input
          type="text"
          name="nombreUsuario"
          placeholder="Nombre de Usuario"
          value={modoEdicion ? usuarioEditando.nombreUsuario : nuevoUsuario.nombreUsuario}
          onChange={handleChange}
        />
        <input
          type="text"
          name="claveHash"
          placeholder="Clave (Hash)"
          value={modoEdicion ? usuarioEditando.claveHash : nuevoUsuario.claveHash}
          onChange={handleChange}
        />
        <input
          type="text"
          name="rol"
          placeholder="Rol"
          value={modoEdicion ? usuarioEditando.rol : nuevoUsuario.rol}
          onChange={handleChange}
        />
        <input
          type="text"
          name="estado"
          placeholder="Estado"
          value={modoEdicion ? usuarioEditando.estado : nuevoUsuario.estado}
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
            <th>Nombre de Usuario</th>
            <th>Clave (Hash)</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {usuarios.length > 0 ? (
            usuarios.map(item => (
              <tr key={item.idUsuario}>
                <td>{item.idUsuario}</td>
                <td>{item.nombreUsuario}</td>
                <td>{item.claveHash}</td>
                <td>{item.rol}</td>
                <td>{item.estado}</td>
                <td>
                  <button onClick={() => iniciarEdicion(item)}>Actualizar</button>
                  <button onClick={() => handleDelete(item.idUsuario)}>Eliminar</button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="6">No hay usuarios disponibles.</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default UsuarioPage;
