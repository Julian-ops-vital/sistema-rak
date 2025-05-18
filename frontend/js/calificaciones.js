// calificaciones.js
async function fetchJSON(url, opts){
  const res = await fetch(url, opts);
  if(!res.ok){
    const txt = await res.text();
    console.error(`HTTP ${res.status}:`, txt);
    throw new Error(`Status ${res.status}`);
  }
  return res.json();
}

// 1) Al cargar la sección, llenamos Grupos
document.addEventListener('DOMContentLoaded', async ()=>{
  // 1.1) Llenar selector de grupos
  const grupos = await fetchJSON('/rak/sistema-rak/backend/api/calificaciones/grupos.php');
  const gsel = document.getElementById('grupoCalif');
  grupos.forEach(g=>{
    const o = document.createElement('option');
    o.value = g;
    o.textContent = g;
    gsel.appendChild(o);
  });
  gsel.addEventListener('change', onGrupoChange);
});

// 2) Cuando cambia el grupo, llenamos alumnos
async function onGrupoChange(){
  const grupo = document.getElementById('grupoCalif').value;
  if(!grupo) return;
  const lista = await fetchJSON(`/rak/sistema-rak/backend/api/calificaciones/estudiantes.php?grupo=${encodeURIComponent(grupo)}`);
  const asal = document.getElementById('alumnoCalif');
  asal.innerHTML = '<option value="" disabled selected>Seleccione Alumno</option>';
  lista.forEach(u=>{
    const o = document.createElement('option');
    o.value = u.id;
    o.textContent = `${u.nombre} ${u.apellido}`;
    asal.appendChild(o);
  });
  asal.disabled = false;
}

// 3) Cuando eliges alumno, traes sus tareas
async function onAlumnoChange(){
  const id = document.getElementById('alumnoCalif').value;
  if(!id) return alert('Seleccione un alumno');
  // 3.1) Descargar tareas individuales
  const tareas = await fetchJSON(`/rak/sistema-rak/backend/api/calificaciones/tareas.php?id_est=${id}`);
  const tbody = document.getElementById('tareasBody');
  tbody.innerHTML = tareas.map(t=>`
    <tr>
      <td class="text-center">${t.materia}</td>
      <td class="text-center">${t.rubrica}</td>
      <td class="text-center">${t.ponderacion}%</td>
      <td class="text-center">
        <input type="number" min="0" max="100" value="${t.calificacion??''}" id="calif_${t.id_ins}">
      </td>
      <td class="text-center">
        <button class="btn btn-sm btn-guinda" onclick="guardarCalificacion(${t.id_ins})">✓</button>
      </td>
    </tr>
  `).join('');

  // 3.2) Descargar promedio global de ESTE alumno, para mostrarlo en la tabla global (fila única)
  const prom = await fetchJSON(`/rak/sistema-rak/backend/api/calificaciones/get_promedios_grupo.php?grupo=${encodeURIComponent(document.getElementById('grupoCalif').value)}`);
  // filtramos solo el seleccionado:
  const sel = prom.find(r=>r.id_est==id);
  const gbody = document.getElementById('globalBody');
  gbody.innerHTML = `
    <tr>
      <td class="text-center">${sel.nombre} ${sel.apellido}</td>
      <td class="text-center">${sel.promedio}</td>
      <td class="text-center">
        <button class="btn btn-sm btn-guinda" onclick="descargarDetallePDF(${id})">📄</button>
      </td>
    </tr>
  `;
}

// 4) Guardar una calificación
async function guardarCalificacion(id_ins){
  const val = document.getElementById(`calif_${id_ins}`).value;
  if(val===''|| val<0 || val>100) return alert('Calificación inválida');
  await fetchJSON('/rak/sistema-rak/backend/api/calificaciones/calificar.php', {
    method:'POST',
    headers:{'Content-Type':'application/json'},
    body: JSON.stringify({ id_ins, calificacion: val })
  });
  alert('Calificación guardada');
}

// 5) Descargar PDF global de TODO el grupo
async function descargarGlobalPDF(){
  const grupo = document.getElementById('grupoCalif').value;
  if(!grupo) return alert('Seleccione grupo');
  // Aquí podrías reusar jsPDF+autoTable con la tabla “globalTable”
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.setFontSize(16);
  doc.text(`Boleta Global Grupo ${grupo}`, 14, 20);
  doc.autoTable({ html:'#globalTable', startY:30 });
  doc.save(`Global_Grupo_${grupo}.pdf`);
}

// 6) Descargar PDF detalle por alumno
async function descargarDetallePDF(id_est){
  const alumno = document.getElementById('alumnoCalif').selectedOptions[0].text;
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.setFontSize(16);
  doc.text(`Detalle Calificaciones: ${alumno}`, 14, 20);
  doc.autoTable({ html:'#tareasTable', startY:30 });
  doc.save(`Detalle_${alumno.replace(' ','_')}.pdf`);
}
