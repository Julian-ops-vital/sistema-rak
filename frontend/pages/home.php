<?php
session_start();
// Si no hay usuario en sesión, redirige al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /rak/sistema-rak/frontend/pages/login.html");
    exit();
}
    $rol = $_SESSION['usuario_rol'];  // asumo que guardas aquí el número 1, 2 ó 3
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Menu RAK</title>
  <link rel="stylesheet" href="/rak/sistema-rak/frontend/css/css/bootstrap.css">
  <link rel="stylesheet" href="/rak/sistema-rak/frontend/css/dashboard.css">
  <script>
    // numérico, no string
    window.USER_ROLE = <?= json_encode($_SESSION['usuario_rol'], JSON_NUMERIC_CHECK) ?>;
  </script>
<body>
  <input type="checkbox" id="menu-toggle" checked>
  
  <!-- Header -->
  <header class="header d-flex justify-content-between align-items-center px-3 bg-secondary">
    <label for="menu-toggle" class="menu-icon"><img id="icon-header" src="assets/secundaria-tecnica.png"></label>
    <div class="user-info d-flex align-items-center">
      <span class="me-2 fw-bold">Administrador</span>
      <div class="user-avatar rounded-circle bg-primary text-white d-flex justify-content-center align-items-center">
        <i class="bi bi-person"></i>
      </div>
    </div>
  </header>

  <!-- Sidebar -->
  <div class="sidebar bg-primary">
    <h2 class="text-white">Secundaria Tecnica #93</h2>
    <ul class="list-unstyled">
      <li><a href="#" class="nav-link" data-section="materias"><img class="icon" src="assets/libros.svg" alt="Libro"> Materias</a></li>
      <li><a href="#" class="nav-link" data-section="actividades"><img class="icon" src="assets/actividades.svg" alt="Documento"> Actividades</a></li>
      <li><a href="#" class="nav-link" data-section="calificaciones"><img class="icon" src="assets/Calificaciones.svg" alt="calificaciones"> Calificaciones</a></li>
      <li><a href="#" class="nav-link" data-section="asignaciones"><img class="icon" src="assets/listamateria.svg" alt="Imparte"> Horario</a></li>
      <li><a href="#" class="nav-link" data-section="usuarios"><img class="icon" src="assets/usuarios.svg" alt="usuarios"> Usuarios</a></li>
    </ul>
    <!-- Botón de logout al fondo -->
    <div class="mb-3 p-3" id="logout-button">
    <a href="../../backend/api/logout.php" class="btn btn-danger w-100 d-flex align-items-center justify-content-between">
      <img src="assets/logout.svg" alt="Equis" class="icon">Cerrar sesión
    </a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content bg-secondary">
    <!--Bienvenida section-->
    <section id="bienvenida" class="seccion">
      <div class="container-fluid">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_name'], ENT_QUOTES, 'UTF-8'); ?>!</h1>
        <p class="text-muted">Panel de control central del sistema RAK.</p>

        <div class="row mt-4 justify-content-center">
        <div class="col-md-4">
          <div class="card p-3 shadow-sm">
            <h5>Maestros</h5>
            <p>30 maestros activos</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card p-3 shadow-sm">
            <h5>Alumnos</h5>
            <p>200 alumnos inscritos</p>
          </div>
        </div>
        </div>
      </div>
    </section>
    <!--Materias section-->
    <section id="materias" class="seccion" hidden>
      <div class="container-fluid">
          <div class="container-fluid text-center" >
            <h1 class="mt-3 mb-4">Gestión de Materias</h1>
          </div>
          <div class="mb-3 d-flex gap-2">
            <input type="text" id="nombreMateria" class="form-control" placeholder="Nombre de la materia">
            <button class="btn btn-guinda" onclick="agregarMateria()">Agregar Materia</button>
          </div>
          <div class="container-fluid refresh-btn text-start mb-4">
            <h3>Buscar:</h3>
            <button class="btn btn-guinda" onclick="cargarMaterias()">Todos</button>
            <button class="btn btn-guinda" onclick="mostrarFiltroAlumno()">Alumno</button>
            <button class="btn btn-guinda" onclick="mostrarFiltroMaestro()">Maestro</button>
          </div>
          <div class="mb-3 d-flex gap-2 text-center" id="filtroAlumno">
            <select id="materiaAlumno" class="form-select text-center" onfocus="cargarAlumnosSelect()" style="display:none;">
            <option value="" disabled selected>Alumno</option>
            <!--Funcion para desplegar todas los alumnos disponibles -->
            </select>
            <select id="materiaMaestro" class="form-select text-center" onfocus="cargarMaestroSelect()" style="display:none;>
              <option value="" disabled selected>Maestro</option>
            </select>
          </div>
          <div class="table-responsive table-hover" id="tabla-materias">
            <table class="table">
              <thead class="text-muted">
                <th class="text-center">Nombre</th>
                <th class="text-center ">Eliminar</th>
              </thead>
              <tbody id=materiasBody>
              </tbody>
            </table>
            <button class="btn btn-guinda" onclick="descargarMaterias()">Descargar lista</button>
          </div>  
      </div>
    </section>
    <!--Actividades section-->
    <section id="actividades" class="seccion" hidden>
      <div class="container-fluid text-center">
        <h1 class="mt-3 mb-3">Gestion de Actividades</h1>
        <div class="mb-3 d-flex gap-2">
          <select id="materiaActividad" class="form-select text-center" onfocus="cargarMateriasSelect()">
            <option value="" disabled selected>Materia</option>
            <!--Funcion para desplegar todas las materias disponibles -->
          </select>
          <input type="text" id="rubricaActividad" class="form-control" placeholder="Rubrica">
          <input type="text" id="objetivoActividad" class="form-control" placeholder="Objetivo">
          <!--Ponderación sera un desplegable en el cual podras escoger algunas opciones-->
          <select id="ponderacionActividad" class="form-select text-center" style="width: 40%;">
            <option value="" disabled selected>Ponderacion</option>
            <option value="10">10%</option>
            <option value="15">15%</option>
            <option value="20">20%</option>
            <option value="25">25%</option>
            <option value="50">50%</option>
          </select>
          <button class="btn btn-guinda" onclick="agregarActividad()">Agregar Actividad</button>
        </div>
        <div class="container-fluid refresh-btn text-end">
            <button class="btn btn-guinda" onclick="cargarActividades()"><img class="icon" src="assets/refresh.svg" alt="Eliminar"></button>
        </div>
        <div class="table-responsive table-hover" id="tabla-materias">
          <table class="table" id="actividadesTable">
            <thead class="text-muted">
              <th class="text-center">Materia</th>
              <th class="text-center">Rubrica</th>
              <th class="text-center">Objetivo</th>
              <th class="text-center">Ponderación</th>
              <th class="text-center">Eliminar</th>
            </thead>
            <tbody id="actividadesBody">
            </tbody>
          </table>
          <button class="btn btn-guinda" onclick="descargarActividades()">Descargar lista</button>
      </div>
      <div class="container-fluid text-center mt-5">
        <h1 class="mt-3 mb-3">Subir Tareas</h1>
        <div class="mb-3 d-flex gap-2">
          <select id="grupoEstudianteTarea" class="form-select text-center" onfocus="cargarAlumnosSelect()">
            <option value="" disabled selected>Grupo</option>
            <!--Se despliegan todos los grupos disponibles -->
          </select>
          <select id="numeroActividadTarea" class="form-select text-center" onfocus="cargarActividadesSelect()">
            <option value="" disabled selected>Actividad</option>
            <!--Se despliegan todos las actividades disponibles -->
          </select>
          <input type="date" id="FechaFin" class="form-control" placeholder="Fecha limite">
          <button class="btn btn-guinda" onclick="agregarTarea()">Agregar Actividad</button>
        </div>
    </section>
    <!--Calificaciones section-->
    <section id="calificaciones" class="seccion" hidden>
        <div id="alumnoScreen" class="hidden">
          <h2 class="mb-4">Gestión de Alumnos y Calificaciones</h2>
          <p><strong>Grupo Seleccionado:</strong> <span id="grupoActual"></span></p>
      
          <table class="table table-bordered align-middle">
            <thead class="table-guinda text-white" style="background-color:#800020;">
              <tr>
                <th>Nombre</th>
                <th>Tarea 1</th>
                <th>Tarea 2</th>
                <th>Examen</th>
                <th>Promedio</th>
              </tr>
            </thead>
            <tbody id="tablaAlumnos">
            </tbody>
          </table>
      
          <div class="d-flex gap-2 mb-3">
            <input type="text" id="nombreAlumno" class="form-control" placeholder="Nombre del alumno">
              <button class="btn btn-guinda" onclick="calcularPromedios()">Guardar Tabla</button>
          <button class="btn btn-guinda" onclick="calcularPromedios()">Sacar Promedio</button>
        </div>
      </div>    
      <!-- <div class="container-fluid">
        <h2 class="mb-4">Consulta de Calificaciones</h2>
        <div class="mb-3">
          <label for="grupoSelect" class="form-label">Selecciona tu grupo:</label>
          <select id="grupoSelect" class="form-select">
            <option value="">-- Selecciona grupo --</option>
            <option value="Grupo 1">Grupo 1</option>
            <option value="Grupo 2">Grupo 2</option>
          </select>
        </div> 
      
        <div class="mb-3">
          <label for="materiaSelect" class="form-label">Selecciona la materia:</label>
          <select id="materiaSelect" class="form-select">
            <option value="">-- Selecciona materia --</option>
            <option value="Matemáticas">Matemáticas</option>
            <option value="Español">Español</option>
          </select>
        </div>
      </div>
      <button class="btn btn-guinda mb-4" onclick="mostrarCalificaciones()">Ver Calificaciones</button>
      -->
    </section>
    <!-- Imparte Section -->
    <section id="asignaciones" class="seccion" hidden>
      <div class="container-fluid text-center">
        <h1 class="mt-3 mb-4">Materias que lleva</h1>
        <div class="container-fluid refresh-btn text-start mb-3">
          <button class="btn btn-guinda" onclick="cargarMaterias()">Todos</button>
        </div>
        <div class="table-responsive">
          <table class="table" id="asignacionTable">
            <thead>
              <tr>
                <th>Materia</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody id="asignacionBody"></tbody>
          </table>
        </div>
      </div>
    </section>
    <!--Usuarios section-->
    <section id="usuarios" class="seccion" hidden>
      <div class="container-fluid text-center">
        <h1 class="mt-3 mb-4">Gestion de Usuarios</h1>
        <div class="mb-3 d-flex gap-2">
          <input type="text" id="nombreUsuario" class="form-control" placeholder="Nombre">
          <input type="text" id="ApellidoUsuario" class="form-control" placeholder="Apellidos">
          <input type="text" id="correoUsuario" class="form-control" placeholder="Correo Electronico">
          <input type="text" id="contraseñaUsuario" class="form-control" placeholder="Contraseña">
          <input type="text" id="contraseñaConfirmUsuario" class="form-control" placeholder="Confirmar contraseña">
          <select id="rolUsuario" class="form-select text-center w-25">
            <option value="" disabled selected>Rol</option>
            <option value="1">1 Administrador</option>
            <option value="2">2 Maestro</option>
            <option value="3">3 Alumno</option>
          </select>
          <input type="text" id="grupoUsuario" class="form-control" placeholder="Grupo" style="display:none;">
          <button class="btn btn-guinda" onclick="agregarUsuario()">Agregar Usuario</button>
        </div>
        <div class="container-fluid refresh-btn text-start mb-3">
          <button class="btn btn-guinda" onclick="cargarUsuarios()">Todos</button>
          <button class="btn btn-guinda" onclick="cargarAlumnos()">Listar Alumnos</button>
          <button class="btn btn-guinda" onclick="cargarMaestros()">Listar Maestros</button>
          <button class="btn btn-guinda" onclick="cargarAdministradores()">Listar Administradores</button>
        </div>
        <div class="table-responsive table-hover">
          <table class="table" id="usuariosTable">
            <thead class="text-muted">
              <th class="text-center">Nombre</th>
              <th class="text-center">Apellidos</th>
              <th class="text-center">Correo Electronico</th>
              <th class="text-center">Rol</th>
              <th class="text-center">Eliminar</th>
            </thead>
            <tbody id="usuariosBody">
            </tbody>
          </table>
          <button class="btn btn-guinda" onclick="descargarUsuarios()">Descargar lista</button>
        </div>
      </div>
    </section>
  </div>

  <script src="../js/main.js"></script>
  <script src="../js/usuarios.js"></script>
  <script src="../js/actividades.js"></script>
  <!-- <script src="../js/tareas.js"></script> -->
  <script src="../js/materias.js"></script>
  <script src="../js/js/bootstrap.bundle.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
</body>
</html>
