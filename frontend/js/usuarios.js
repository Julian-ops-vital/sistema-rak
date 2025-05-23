/**
 * Carga usuarios de cualquier endpoint y pinta la tabla.
 * @param {string} endpoint — nombre del archivo PHP en /api/usuarios/
 */

// 0) Funcion pasar de número a texto
function getRoleName(rol) {
  switch (rol) {
    case '1': case 1: return 'Administrador';
    case '2': case 2: return 'Maestro';
    case '3': case 3: return 'Alumno';
    default:          return 'Desconocido';
  }
}

// 1) Pide el JSON y dibuja filas en #usuariosBody
    async function cargarUsuariosDesde(endpoint) {
    try{
        const res = await fetch(`/rak/sistema-rak/backend/api/usuarios/${endpoint}`);
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const usuarios = await res.json();
        const tbody = document.getElementById('usuariosBody');
        tbody.innerHTML = usuarios.map(u => `
            <tr>
            <td class="text-center">${u.nombre}</td>
            <td class="text-center">${u.apellido}</td>
            <td class="text-center">${u.correo}</td>
            <td class="text-center">${getRoleName(u.rol)}</td>
            <td class="text-center">
                <button class="btn btn-guinda" onclick="eliminarUsuario(${u.id})">
                <img class="icon" src="assets/Basura.svg" alt="Eliminar">
                </button>
            </td>
            </tr>
        `).join('');
    } catch(err) {
        console.error(`Error cargando ${endpoint}:`, err);
    }
    }
    
    // 1.1) Filtros
        function cargarUsuarios(){
            cargarUsuariosDesde('get_usuarios.php')
    }
        function cargarAlumnos(){
            cargarUsuariosDesde('get_alumnos.php')
    }
        function cargarMaestros(){
            cargarUsuariosDesde('get_maestros.php')
    }
        function cargarAdministradores(){
            cargarUsuariosDesde('get_administradores.php')
    }


let isSubmitting = false;
    // 2) Agrega usuario con validacion de campos y contraseña
    async function agregarUsuario() {
        if (isSubmitting) return;
        // Lee inputs
        const nombre   = document.getElementById('nombreUsuario').value.trim();
        const apellido = document.getElementById('ApellidoUsuario').value.trim();
        const correo   = document.getElementById('correoUsuario').value.trim();
        const password = document.getElementById('contraseñaUsuario').value;
        const confirm  = document.getElementById('contraseñaConfirmUsuario').value;
        const rol      = document.getElementById('rolUsuario').value;
        const payload  = {nombre, apellido, correo, password, rol}

        // Validaciones tempranas
        if (!nombre || !apellido || !correo || !password || !confirm || !rol) {
            alert('Complete todos los campos.');
            return;
        }
        if (password !== confirm) {
            alert('Las contraseñas no coinciden.');
            return;
        }
        // Si es alumno, agrega el grupo
        if (rol === '3') {
            const grupo = document.getElementById('grupoUsuario').value.trim();
            if (!grupo) {
                alert('Para alumnos debes indicar un grupo.');
                return;
            }
            payload.grupo = grupo;
            document.getElementById('grupoUsuario').style.display = 'none';
        }
        isSubmitting = true;                   //  ◀ marcar envío en curso
        try {
            const res = await fetch('/rak/sistema-rak/backend/api/usuarios/registrar_usuario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const json = await res.json();
            if (json.success) {
                // Limpiar campos
                document.getElementById('nombreUsuario').value = '';
                document.getElementById('ApellidoUsuario').value = '';
                document.getElementById('correoUsuario').value = '';
                document.getElementById('contraseñaUsuario').value = '';
                document.getElementById('contraseñaConfirmUsuario').value = '';
                document.getElementById('rolUsuario').selectedIndex = 0;
                document.getElementById('grupoUsuario').value = '';
                // Refrescar tabla UNA VEZ
                await cargarUsuarios();
            } else {
                alert('Error: ' + (json.error || 'desconocido'));
            }
        } catch (err) {
            console.error(err);
            alert('Ocurrió un error, revisa la consola.');
        } finally {
            isSubmitting = false;
        }
    }

    // 3) Eliminar usuario
    async function eliminarUsuario(id) {
    if (!confirm('¿Eliminar este usuario?')) return;
    await fetch(`/rak/sistema-rak/backend/api/usuarios/eliminar_usuario.php?id=${id}`);
    cargarUsuarios();
    }

// 4) Descargar lista en PDF
    async function descargarUsuarios() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

      // 1) Clonar la tabla
        const original = document.getElementById('usuariosTable');
        const clone = original.cloneNode(true);

      // 2) En cada fila del <thead> y <tbody> quita la última <th> o <td>
        clone.querySelectorAll('thead tr, tbody tr').forEach(tr => {
            const last = tr.lastElementChild;
            if (last) tr.removeChild(last);
        });

      // 3) Título
        doc.setFontSize(16);
        doc.text('Listado de Usuarios', 14, 20);

      // 4) autoTable con el clon (sin la columna “Eliminar”)
        doc.autoTable({
        html: clone,
        startY: 30,
        styles: { fontSize: 10, cellPadding: 3 },
        headStyles: { fillColor: [40, 40, 40] }
        });

      // 5) Descargar
        doc.save('usuarios.pdf');
    }

    // Cuando cambie el rol, mostramos o escondemos el campo de grupo
document.getElementById('rolUsuario').addEventListener('change', function() {
  const grupoInput = document.getElementById('grupoUsuario');
  if (this.value === '3') {
    grupoInput.style.display = 'block';
  } else {
    grupoInput.style.display = 'none';
  }
});
