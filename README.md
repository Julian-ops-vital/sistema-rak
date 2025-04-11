# Proyecto de sistema rak para secundaria

# Contrato de Trabajo - API Sistema RAK

Este documento define los acuerdos entre el equipo de backend y el equipo de frontend del proyecto **'Sistema RAK'**. Tiene como propósito facilitar el desarrollo paralelo y la integración eficiente entre ambas partes mediante el uso de una API REST.

---

## 1. Estructura General del Proyecto

El proyecto se organiza con la siguiente estructura de carpetas:

- `/frontend/`: Contiene los archivos HTML, CSS, y JavaScript.
- `/backend/`: Contiene la lógica de la API en PHP.
- `/database/`: Contiene el archivo `sistema_rak.sql` y posibles scripts de migración.
- `/docs/`: Documentación del proyecto.
- `README.md`: Instrucciones generales del proyecto.

---

## 2. API REST

La API se encargará de manejar toda la comunicación entre la base de datos y el frontend.  
⚠️ **El equipo de frontend NO debe conectarse directamente a la base de datos**, sino a través de los endpoints definidos.

---

## 3. Endpoints Definidos

A continuación se definen los principales endpoints que usará el sistema:

- `GET /api/alumnos` - Obtener todos los alumnos.
- `GET /api/alumnos/{id}` - Obtener un alumno específico.
- `POST /api/alumnos` - Registrar un nuevo alumno.
- `PUT /api/alumnos/{id}` - Actualizar los datos de un alumno.
- `DELETE /api/alumnos/{id}` - Eliminar un alumno.
- `GET /api/materias` - Obtener lista de materias.
- `POST /api/tareas` - Crear una nueva tarea.
- `GET /api/tareas/{id}` - Obtener detalles de una tarea.
- `POST /api/evaluaciones` - Registrar una evaluación.

---

## 4. Reglas y Compromisos

- El equipo de frontend debe respetar los endpoints definidos y **no modificar las rutas**.
- El equipo de backend debe mantener el formato de respuesta **JSON** y una estructura clara.
- En caso de requerir cambios, deben ser discutidos en **reunión conjunta**.
- Se utilizará **GitHub** como repositorio central del proyecto.

