import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";



// Componentes
import Header from "./components/Header"; 

// Páginas
import Home from "./pages/Home";
import ClientePage from "./pages/ClientePage";
import ConsumoPage from "./pages/ConsumoPage";
import DetalleReservacionPage from "./pages/DetalleReservacionPage";
import HabitacionPage from "./pages/HabitacionPage";
import HabitacionPaquetePage from "./pages/HabitacionPaquetePage";
import MantenimientoHabitacionPage from "./pages/MantenimientoHabitacionPage";
import PagoPage from "./pages/PagoPage";
import PaquetePage from "./pages/PaquetePage";
import ReservacionPage from "./pages/ReservacionPage";
import ServicioExtraPage from "./pages/ServicioExtraPage";
import TipoHabitacionPage from "./pages/TipoHabitacionPage";
import UsuarioPage from "./pages/UsuarioPage";

function App() {
  return (
    <Router>
      <Header /> {/* 👈 Aquí lo usamos */}
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/clientes" element={<ClientePage />} />
        <Route path="/consumo" element={<ConsumoPage />} />
        <Route path="/detalle-reservacion" element={<DetalleReservacionPage />} />
        <Route path="/habitacion" element={<HabitacionPage />} />
        <Route path="/habitacion-paquete" element={<HabitacionPaquetePage />} />
        <Route path="/mantenimiento-habitacion" element={<MantenimientoHabitacionPage />} />
        <Route path="/pago" element={<PagoPage />} />
        <Route path="/paquete" element={<PaquetePage />} />
        <Route path="/reservacion" element={<ReservacionPage />} />
        <Route path="/servicio-extra" element={<ServicioExtraPage />} />
        <Route path="/tipo-habitacion" element={<TipoHabitacionPage />} />
        <Route path="/usuario" element={<UsuarioPage />} />
      </Routes>
    </Router>
  );
}

export default App;
