// 1) Pide el JSON y dibuja filas en #actividadesBody
    async function cargarActividades() {
    const res = await fetch('/rak/sistema-rak/backend/api/actividades/get_actividades.php');
    const usuarios = await res.json();
    const tbody = document.getElementById('actividadesBody');
    tbody.innerHTML = usuarios.map(u => `
        <tr>
        <td class="text-center">${u.materia}</td>
        <td class="text-center">${u.rubrica}</td>
        <td class="text-center">${u.objetivo}</td>
        <td class="text-center">${u.ponderacion}</td>
        <td class="text-center">
            <button class="btn btn-guinda" onclick="eliminarUsuario(${u.id})">
            <img class="icon" src="assets/Basura.svg" alt="Eliminar">
            </button>
        </td>
        </tr>
    `).join('');
    }