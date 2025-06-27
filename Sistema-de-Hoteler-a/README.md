
# API RESTful - Sistema de Hotelería

## Descripción
Este proyecto implementa una API RESTful usando PHP y MySQL siguiendo la arquitectura MVC para un sistema de hotelería con 12 entidades relacionadas.

## Estructura de carpetas

-**SISTEMA-DE-HOTELERIA-A**: Raiz del proyecto
- **model/**: Clases que representan las entidades.
- **accessData/**: Clases DAO que manejan la lógica de acceso a datos usando PDO y consultas preparadas.
- **controller/**: Controladores que exponen la lógica de negocio y CRUD para cada entidad.
- **api/**: Archivos que actúan como rutas RESTful y reciben las solicitudes HTTP.
- **misc/**: Clases auxiliares como la conexión a la base de datos.
- **config/**: Configuración de conexión a MySQL.

## Endpoints

| Entidad          | URL                                       | Método  | Descripción 
|----------------- |-------------------------------------------|---------|-------------- 
| ClienteH         | `/api/clienteh.php`                       | GET     | Obtener todos los registros. 
| ClienteH         | `/api/clienteh.php?id=1`                  | GET     | Obtener un registro por ID. 
| ClienteH         | `/api/clienteh.php`                       | POST    | Insertar nuevo registro. 
| ClienteH         | `/api/clienteh.php`                       | PUT     | Actualizar registro existente. 
| ClienteH         | `/api/clienteh.php?id=1`                  | DELETE  | Eliminar registro por ID.
| HabitacionH      | `/api/habitacionh.php`                    | GET     | Obtener todos los registros. 
| HabitacionH      | `/api/habitacionh.php?id=1`               | GET     | Obtener un registro por ID. 
| HabitacionH      | `/api/habitacionh.php`                    | POST    | Insertar nuevo registro.
| HabitacionH      | `/api/habitacionh.php`                    | PUT     | Actualizar registro existente.
| HabitacionH      | `/api/habitacionh.php?id=1`               | DELETE  | Eliminar registro por ID.
| ReservacionH     | `/api/reservacionh.php`                   | GET     | Obtener todos los registros.
| ReservacionH     | `/api/reservacionh.php?id=1`              | GET     | Obtener un registro por ID.
| ReservacionH     | `/api/reservacionh.php`                   | POST    | Insertar nuevo registro.
| ReservacionH     | `/api/reservacionh.php`                   | PUT     | Actualizar registro existente.
| ReservacionH     | `/api/reservacionh.php?id=1`              | DELETE  | Eliminar registro por ID.
| UsuarioH         | `/api/usuarioh.php`                       | GET     | Obtener todos los registros.
| UsuarioH         | `/api/usuarioh.php?id=1`                  | GET     | Obtener un registro por ID.
| UsuarioH         | `/api/usuarioh.php`                       | POST    | Insertar nuevo registro.
| UsuarioH         | `/api/usuarioh.php`                       | PUT     | Actualizar registro existente.
| UsuarioH         | `/api/usuarioh.php?id=1`                  | DELETE  | Eliminar registro por ID.
| ConsumoH         | `/api/consumoh.php`                       | GET     | Obtener todos los registros.
| ConsumoH         | `/api/consumoh.php?id=1`                  | GET     | Obtener un registro por ID.
| ConsumoH         | `/api/consumoh.php`                       | POST    | Insertar nuevo registro.
| ConsumoH         | `/api/consumoh.php`                       | PUT     | Actualizar registro existente.
| ConsumoH         | `/api/consumoh.php?id=1`                  | DELETE  | Eliminar registro por ID.
| DetalleReservacionH | `/api/detallereservacionh.php`         | GET     | Obtener todos los registros.
| DetalleReservacionH | `/api/detallereservacionh.php?id=1`    | GET     | Obtener un registro por ID.
| DetalleReservacionH | `/api/detallereservacionh.php`         | POST    | Insertar nuevo registro.
| DetalleReservacionH | `/api/detallereservacionh.php`         | PUT     | Actualizar registro existente.
| DetalleReservacionH | `/api/detallereservacionh.php?id=1`    | DELETE  | Eliminar registro por ID.
| HabitacionPaqueteH  | `/api/habitacionpaqueteh.php`          | GET     | Obtener todos los registros.
| HabitacionPaqueteH  | `/api/habitacionpaqueteh.php?id=1`     | GET     | Obtener un registro por ID.
| HabitacionPaqueteH  | `/api/habitacionpaqueteh.php`          | POST    | Insertar nuevo registro.
| HabitacionPaqueteH  | `/api/habitacionpaqueteh.php`          | PUT     | Actualizar registro existente.
| HabitacionPaqueteH  | `/api/habitacionpaqueteh.php?id=1`     | DELETE  | Eliminar registro por ID.
| MantenimientoHabitacionH | `/api/mantenimientohabitacionh.php`       | GET    | Obtener todos los registros.
| MantenimientoHabitacionH | `/api/mantenimientohabitacionh.php?id=1`  | GET    | Obtener un registro por ID.
| MantenimientoHabitacionH | `/api/mantenimientohabitacionh.php`       | POST   | Insertar nuevo registro.
| MantenimientoHabitacionH | `/api/mantenimientohabitacionh.php`       | PUT    | Actualizar registro existente.
| MantenimientoHabitacionH | `/api/mantenimientohabitacionh.php?id=1`  | DELETE | Eliminar registro por ID.
| PagoH                    | `/api/pagoh.php`                          | GET    | Obtener todos los registros.
| PagoH                    | `/api/pagoh.php?id=1`                     | GET    | Obtener un registro por ID.
| PagoH                    | `/api/pagoh.php`                          | POST   | Insertar nuevo registro.
| PagoH                    | `/api/pagoh.php`                          | PUT    | Actualizar registro existente.
| PagoH                    | `/api/pagoh.php?id=1`                     | DELETE | Eliminar registro por ID.
| PaqueteH                 | `/api/paqueteh.php`                       | GET    | Obtener todos los registros.
| PaqueteH                 | `/api/paqueteh.php?id=1`                  | GET    | Obtener un registro por ID.
| PaqueteH                 | `/api/paqueteh.php`                       | POST   | Insertar nuevo registro.
| PaqueteH                 | `/api/paqueteh.php`                       | PUT    | Actualizar registro existente.
| PaqueteH                 | `/api/paqueteh.php?id=1`                  | DELETE | Eliminar registro por ID.
| ServicioExtraH           | `/api/servicioextrah.php`                 | GET    | Obtener todos los registros.
| ServicioExtraH           | `/api/servicioextrah.php?id=1`            | GET    | Obtener un registro por ID.
| ServicioExtraH           | `/api/servicioextrah.php`                 | POST   | Insertar nuevo registro.
| ServicioExtraH           | `/api/servicioextrah.php`                 | PUT    | Actualizar registro existente.
| ServicioExtraH           | `/api/servicioextrah.php?id=1`            | DELETE | Eliminar registro por ID.
| TipoHabitacionH          | `/api/tipohabitacionh.php`                | GET    | Obtener todos los registros.
| TipoHabitacionH          | `/api/tipohabitacionh.php?id=1`           | GET    | Obtener un registro por ID.
| TipoHabitacionH          | `/api/tipohabitacionh.php`                | POST   | Insertar nuevo registro.
| TipoHabitacionH          | `/api/tipohabitacionh.php`                | PUT    | Actualizar registro existente.
| TipoHabitacionH          | `/api/tipohabitacionh.php?id=1`           | DELETE | Eliminar registro por ID.


## Ejemplo JSON de entrada (POST / PUT)
```json
{
  "campo1": "valor",
  "campo2": "valor",
  "...": "..."
}
```

## Ejemplo de respuesta
```json
[
  {
    "campo1": "valor",
    "campo2": "valor"
  }
]
```

## Instrucciones generales
1. Clonar o copiar el proyecto en la carpeta `htdocs/` de XAMPP.
2. Importar la base de datos `multimedios` usando phpMyAdmin.
3. Configurar las credenciales de la base de datos en `misc/Conexion.php`.
4. Iniciar Apache y MySQL en XAMPP.
5. Probar los endpoints usando Postman o cURL.

## Pruebas
- Se recomienda usar Postman para enviar solicitudes GET, POST, PUT y DELETE.
- Adjuntar capturas de pantalla o exportar la colección Postman como evidencia de pruebas.
## Ejemplo de prueba GET de reservacion

[GET Reservación](screenshots/get_reservacion.jpg)

## Ejemplo de prueba Put  reservacion

[Put Reservación](screenshots/método_Put.png)

## Ejemplo de prueba Delete  reservacion

[Delete Reservación](screenshots/Delete.png)

## Ejemplo de prueba Delete  reservacion

[Post Reservación](screenshots/Post.png)

---
2025 Proyecto API RESTful - Sistema de Hotelería, colaboradores: Brandom, Glenda, Javier Mora
