/**
 * Carga las materias desde el servidor y las inserta en
 * el <select id="materiaActividad"> como <option>.
 */
async function cargarMateriasSelect() {
  try {
    const select = document.getElementById('idEstudianteTarea');
    // 1) Guarda el valor que estaba antes (puede ser "" si no ha elegido nada)
    const previo = select.value;

    // 2) Recupera las materias
    const res = await fetch('/rak/sistema-rak/backend/api/materias/get_materias.php');
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    const materias = await res.json();

    // 3) Repuebla el select
    select.innerHTML = '<option value="" disabled>Materia</option>';
    materias.forEach(m => {
      const opt = document.createElement('option');
      opt.value = m.id;
      opt.textContent = m.nombre;
      select.appendChild(opt);
    });

    // 4) Restaura la selección anterior si sigue existiendo
    if (previo && Array.from(select.options).some(o => o.value === previo)) {
      select.value = previo;
    } else {
      // Si no existía o era el placeholder, vuelve a ponerlo seleccionado
      select.value = '';
    }

  } catch (err) {
    console.error('Error cargando materias para el select:', err);
  }
}
window.cargarMateriasSelect = cargarMateriasSelect;


// 1) Pide el JSON y dibuja filas en #actividadesBody
    async function cargarActividades() {
    const res = await fetch('/rak/sistema-rak/backend/api/actividades/get_actividades.php');
    const actividades = await res.json();
    const tbody = document.getElementById('actividadesBody');
    tbody.innerHTML = actividades.map(u => `
        <tr>
        <td class="text-center">${u.materia}</td>
        <td class="text-center">${u.rubrica}</td>
        <td class="text-center">${u.objetivo}</td>
        <td class="text-center">${u.ponderacion}</td>
        <td class="text-center">
            <button class="btn btn-guinda" onclick="eliminarActividad(${u.id})">
            <img class="icon" src="assets/Basura.svg" alt="Eliminar">
            </button>
        </td>
        </tr>
    `).join('');
    }

let isSubmittingActividad = false;
    // 2) Agrega actividad con validacion de campos
    async function agregarActividad() {
        if (isSubmittingActividad) return;
        // Lee inputs
        const materia     = document.getElementById('materiaActividad').value;
        const rubrica     = document.getElementById('rubricaActividad').value.trim();
        const objetivo    = document.getElementById('objetivoActividad').value.trim();
        const ponderacion = document.getElementById('ponderacionActividad').value;

        // Validaciones tempranas
        if (!materia || !rubrica || !objetivo || !ponderacion) {
            alert('Complete todos los campos.');
            return;
        }
        isSubmittingActividad = true;                   //  ◀ marcar envío en curso
        try {
            const payload = { materia, rubrica, objetivo, ponderacion };
            const res = await fetch('/rak/sistema-rak/backend/api/actividades/registrar_actividad.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const json = await res.json();
            if (json.success) {
                // Limpiar campos
                document.getElementById('materiaActividad').selectedIndex = 0;
                document.getElementById('rubricaActividad').value = '';
                document.getElementById('objetivoActividad').value = '';
                document.getElementById('ponderacionActividad').selectedIndex = 0;
                // Refrescar tabla UNA VEZ
                await cargarActividades();
            } else {
                alert('Error: ' + (json.error || 'desconocido'));
            }
        } catch (err) {
            console.error(err);
            alert('Ocurrió un error, revisa la consola.');
        } finally {
            isSubmittingActividad = false;
        }
    }

    // 3) Eliminar actividad
    async function eliminarActividad(id) {
    if (!confirm('¿Eliminar esta Actividad?')) return;
    await fetch(`/rak/sistema-rak/backend/api/actividades/eliminar_actividad.php?id=${id}`);
    cargarActividades();
    }

    document.addEventListener('DOMContentLoaded', () => {
    cargarMateriasSelect();
    cargarActividades();
    });

// 4) Descargar lista en PDF
    async function descargarActividades() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

      // 1) Clonar la tabla
        const original = document.getElementById('actividadesTable');
        const clone = original.cloneNode(true);

      // 2) En cada fila del <thead> y <tbody> quita la última <th> o <td>
        clone.querySelectorAll('thead tr, tbody tr').forEach(tr => {
            const last = tr.lastElementChild;
            if (last) tr.removeChild(last);
        });

      // 3) Título
        doc.setFontSize(16);
        doc.text('Listado de Actividades', 14, 20);

      // 4) autoTable con el clon (sin la columna “Eliminar”)
        doc.autoTable({
        html: clone,
        startY: 30,
        styles: { fontSize: 10, cellPadding: 3 },
        headStyles: { fillColor: [40, 40, 40] }
        });

      // 5) Descargar
        doc.save('Actividades.pdf');
    }
