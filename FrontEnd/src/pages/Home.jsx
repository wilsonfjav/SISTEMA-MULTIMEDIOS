// src/views/Home.jsx
import React from "react";
import { Link } from "react-router-dom";
import "../assets/Home.css";
import reactLogo from "../assets/react.svg";
import viteLogo from "/vite.svg"; // funciona con Vite directamente
import Header from "../components/Header.jsx"; // Importa el componente Header


function Home() {
  console.log("Home cargado");

  return (
    <>
      <Header />

      <div className="home-container">
        <div className="logo-bar">
          <a href="https://vitejs.dev" target="_blank" rel="noopener noreferrer">
            <img src={viteLogo} alt="Vite logo" className="logo-img" />
          </a>
          <a href="https://reactjs.org" target="_blank" rel="noopener noreferrer">
            <img src={reactLogo} alt="React logo" className="logo-img" />
          </a>
        </div>

        <h1>Bienvenido al Sistema Hotelero</h1>
        <p>Selecciona un módulo para comenzar:</p>

        <div className="modulos-grid">
          {[
            { path: "clientes", label: "Clientes" },
            { path: "consumo", label: "Consumo" },
            { path: "detalleReservacion", label: "Detalle Reservación" },
            { path: "habitacion", label: "Habitación" },
            { path: "habitacionPaquete", label: "Habitación-Paquete" },
            { path: "mantenimientoHabitacion", label: "Mantenimiento" },
            { path: "pago", label: "Pago" },
            { path: "paquete", label: "Paquete" },
            { path: "reservacion", label: "Reservación" },
            { path: "servicioExtra", label: "Servicio Extra" },
            { path: "tipoHabitacion", label: "Tipo Habitación" },
            { path: "usuario", label: "Usuario" },
          ].map((item) => (
            <Link to={item.path} className="modulo-link" key={item.path}>
              {item.label}
            </Link>
          ))}
        </div>
      </div>
    </>
  );
}

export default Home;