// Helpers para JSON fetch/post
async function fetchJSON(url) {
  const res = await fetch(url);
  if (!res.ok) throw new Error(`HTTP ${res.status}`);
  return res.json();
}

// 1) Al cambiar el modo (all / alumno / maestro)
document.getElementById('filterMode').addEventListener('change', async e => {
  const mode = e.target.value;
  const userSel = document.getElementById('userFilter');

  if (mode === 'all') {
    userSel.classList.add('d-none');
  } else {
    // muéstralo y carga la lista adecuada
    userSel.classList.remove('d-none');
    const endpoint = mode === 'maestro'
      ? '/rak/sistema-rak/backend/api/materiaFiltros/get_maestros.php'
      : '/rak/sistema-rak/backend/api/materiaFiltros/get_estudiantes.php';
    const lista = await fetchJSON(endpoint);
    userSel.innerHTML = `<option value="" disabled selected>Seleccione...</option>`
      + lista.map(u => `<option value="${u.id}">${u.nombre}</option>`).join('');
  }
});

// 2) Función que dispara el filtrado
async function aplicarFiltroMaterias() {
  const mode = document.getElementById('filterMode').value;
  if (mode === 'all') {
    return cargarMaterias();
  }
  const uid = document.getElementById('userFilter').value;
  if (!uid) return alert('Elija un ' + mode + '.');

  // escogemos el endpoint según alumno/maestro
  let rows;
  if (mode === 'maestro') {
    rows = await fetchJSON(`/rak/sistema-rak/backend/api/imparte/get_por_maestro.php?id_mae=${uid}`);
  } else {
    rows = await fetchJSON(`/rak/sistema-rak/backend/api/inscripcion/get_por_estudiante.php?id_est=${uid}`);
  }

  // pintamos la tabla con nombre_mat y botón de quitar
  const body = document.getElementById('materiasBody');
  body.innerHTML = rows.map(r => `
    <tr>
      <td class="text-center">${r.nombre_mat}</td>
      <td class="text-center">
        <button class="btn btn-sm btn-guinda" onclick="
          ${mode==='maestro'
            ? `quitarImparte(${r.id_imp});`
            : `quitarInscripcion(${r.id_ins});`
          }
          aplicarFiltroMaterias();
        ">
          <img class="icon" src="assets/Basura.svg" alt="Quitar">
        </button>
      </td>
    </tr>
  `).join('');
}

// 3) Funciones para quitar asignación
async function quitarImparte(id) {
  await fetch(`/rak/sistema-rak/backend/api/imparte/quitar.php?id_imp=${id}`, { method:'DELETE' });
}
async function quitarInscripcion(id) {
  await fetch(`/rak/sistema-rak/backend/api/inscripcion/quitar.php?id_ins=${id}`, { method:'DELETE' });
}

// 5) Captura cambio de modo para inicializar el panel de asignación
document.getElementById('filterMode').addEventListener('change', async e => {
  const mode = e.target.value;
  const panel = document.getElementById('asignacionPanel');
  const label = document.getElementById('asignTypeLabel');
  if (mode === 'all') {
    panel.classList.add('d-none');
  } else {
    panel.classList.remove('d-none');
    label.textContent = mode === 'maestro' ? 'Maestro' : 'Alumno';
    // Carga todas las materias en el <select id="materiaAsign">
    const materias = await fetchJSON('/rak/sistema-rak/backend/api/materias/get_materias.php');
    document.getElementById('materiaAsign').innerHTML =
      '<option value="" disabled selected>Seleccione materia</option>' +
      materias.map(m=>`<option value="${m.id}">${m.nombre}</option>`).join('');
  }
});

// 6) Función para asignar la materia al usuario seleccionado
async function asignarMateria() {
  const mode = document.getElementById('filterMode').value;
  const uid  = document.getElementById('userFilter').value;
  const mid  = document.getElementById('materiaAsign').value;
  if (!uid || !mid) return alert('Complete selección de usuario y materia.');

  const url = mode==='maestro'
    ? '/rak/sistema-rak/backend/api/imparte/crear.php'
    : '/rak/sistema-rak/backend/api/inscripcion/crear.php';

  const res  = await fetch(url, {
    method:'POST',
    headers:{'Content-Type':'application/json'},
    body: JSON.stringify({ id_us: uid, numero_mat: mid })
  });
  const json = await res.json();
  if (json.success) {
    alert('¡Asignación guardada!');
    aplicarFiltroMaterias();  
  } else {
    alert('Error: '+(json.error||'desconocido'));
  }
}
window.asignarMateria = asignarMateria;


// 4) IMPORTANTE: exponer en global para onclick dinámico
window.aplicarFiltroMaterias = aplicarFiltroMaterias;
window.quitarImparte         = quitarImparte;
window.quitarInscripcion     = quitarInscripcion;
