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
    async function cargarUsuarios() {
    const res = await fetch('/rak/sistema-rak/backend/api/usuarios/get_usuarios.php');
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

        // Validaciones tempranas
        if (!nombre || !apellido || !correo || !password || !confirm || !rol) {
            alert('Complete todos los campos.');
            return;
        }
        if (password !== confirm) {
            alert('Las contraseñas no coinciden.');
            return;
        }
        isSubmitting = true;                   //  ◀ marcar envío en curso
        try {
            const payload = { nombre, apellido, correo, password, rol };
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
  // 1) Recuperar datos
  const res = await fetch('/rak/sistema-rak/backend/api/usuarios/get_usuarios.php');
  const usuarios = await res.json();

  // 2) Preparar filas para la tabla
  const head = [['Nombre','Apellido','Correo','Rol']];
  const body = usuarios.map(u => [
    u.nombre,
    u.apellido,
    u.correo,
    getRoleName(u.rol)
  ]);

  // 3) Crear el PDF
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF(); 

  // 4) Añadir un título (opcional)
  doc.setFontSize(18);
  doc.text('Listado de Usuarios', 14, 22);

  // 5) Dibujar la tabla
  doc.autoTable({
    head: head,
    body: body,
    startY: 30,          // posición vertical donde empieza la tabla
    styles: { fontSize: 10, cellPadding: 3 },
    headStyles: { fillColor: [40, 40, 40] }
  });

  // 6) Guardar/descargar el PDF
  doc.save('usuarios.pdf');
}

    // 5) Al cargar la página, pinta la tabla
    document.addEventListener('DOMContentLoaded', cargarUsuarios);
