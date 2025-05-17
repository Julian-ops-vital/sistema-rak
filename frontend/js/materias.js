// 1) Pide el JSON y dibuja filas en #materiasBody
    async function cargarMaterias() {
    const res = await fetch('/rak/sistema-rak/backend/api/materias/get_materias.php');
    const usuarios = await res.json();
    const tbody = document.getElementById('materiasBody');
    tbody.innerHTML = usuarios.map(u => `
        <tr>
        <td class="text-center">${u.nombre}</td>
        <td class="text-center">
            <button class="btn btn-guinda" onclick="eliminarMateria(${u.id})">
            <img class="icon" src="assets/Basura.svg" alt="Eliminar">
            </button>
        </td>
        </tr>
    `).join('');
    }

let isSubmittingMateria = false;
    // 2) Agrega materia
    async function agregarMateria() {
        if (isSubmitting) return;
        // Lee inputs
        const nombre   = document.getElementById('nombreMateria').value.trim();

        // Validaciones tempranas
        if (!nombre) {
            alert('Introduzca nombre de la materia');
            return;
        }
        
        isSubmittingMateria = true;            // marca envío en curso
        try {
            const payload = {nombre};
            const res = await fetch('/rak/sistema-rak/backend/api/materias/registrar_materia.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const json = await res.json();
            if (json.success) {
                // Limpia campos
                document.getElementById('nombreMateria').value = '';
                // Refresca tabla UNA VEZ
                await cargarMaterias();
                // refresca el select de Actividades
                if (typeof window.cargarMateriasSelect === 'function') {
                await window.cargarMateriasSelect();
                } else {
                console.warn('cargarMateriasSelect() no está definida en window');
                }
            } else {
                alert('Error: ' + (json.error || 'desconocido'));
            }
        } catch (err) {
            console.error(err);
            alert('Ocurrió un error, revisa la consola.');
        } finally {
            isSubmittingMateria = false;
        }
    }

    // 3) Eliminar usuario
    async function eliminarMateria(id) {
    if (!confirm('¿Eliminar esta materia?')) return;
    await fetch(`/rak/sistema-rak/backend/api/materias/eliminar_materia.php?id=${id}`);
    cargarMaterias();
    }

// 4) Descargar lista en PDF
    async function descargarMaterias() {
  // 1) Recuperar datos
  const res = await fetch('/rak/sistema-rak/backend/api/materias/get_materias.php');
  const usuarios = await res.json();

  // 2) Preparar filas para la tabla
  const head = [['Nombre']];
  const body = usuarios.map(u => [
    u.nombre,
  ]);

  // 3) Crear el PDF
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF(); 

  // 4) Añadir un título (opcional)
  doc.setFontSize(18);
  doc.text('Listado de Materias', 14, 22);

  // 5) Dibujar la tabla
  doc.autoTable({
    head: head,
    body: body,
    startY: 30,          // posición vertical donde empieza la tabla
    styles: { fontSize: 10, cellPadding: 3 },
    headStyles: { fillColor: [40, 40, 40] }
  });

  // 6) Guardar/descargar el PDF
  doc.save('Lista_materias.pdf');
}