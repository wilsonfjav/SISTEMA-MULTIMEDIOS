import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import '../assets/Header.css';

export default function Header() {
    const [mostrarMenu, setMostrarMenu] = useState(false);

    const modulos = [
        { path: 'clientes', label: 'Clientes' },
        { path: 'consumo', label: 'Consumo' },
        { path: 'detalleReservacion', label: 'Detalle Reservación' },
        { path: 'habitacion', label: 'Habitación' },
        { path: 'habitacionPaquete', label: 'Habitación-Paquete' },
        { path: 'mantenimientoHabitacion', label: 'Mantenimiento' },
        { path: 'pago', label: 'Pago' },
        { path: 'paquete', label: 'Paquete' },
        { path: 'reservacion', label: 'Reservación' },
        { path: 'servicioExtra', label: 'Servicio Extra' },
        { path: 'tipoHabitacion', label: 'Tipo Habitación' },
        { path: 'usuario', label: 'Usuario' },
    ];

    return (
        <header className="header">
            <h1>Magic Life</h1>
            <nav>
                <ul>
                    <li><Link to="/">Inicio</Link></li>
                    <li
                        className="modulos-menu"
                        onClick={() => setMostrarMenu(!mostrarMenu)}
                    >
                        Módulos
                        {mostrarMenu && (
                            <ul className="dropdown">
                                {modulos.map((mod, idx) => (
                                    <li key={idx}>
                                        <Link to={`/${mod.path}`}>{mod.label}</Link>
                                    </li>
                                ))}
                            </ul>
                        )}
                    </li>
                    <li><Link to="/contacto">Contacto</Link></li>
                </ul>
            </nav>
        </header>
    );
}
