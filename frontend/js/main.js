// main.js

// 0) Lee USER_ROLE y mapea cada rol a sus secciones
console.log('🔥 USER_ROLE =', window.USER_ROLE);  // para debug
const SECCIONES_POR_ROL = {
  1: ['bienvenida','materias','usuarios','actividades','calificaciones', 'asignaciones'], // Admin
  2: ['bienvenida','actividades','calificaciones'],                               // Maestro
  3: ['bienvenida','calificaciones']                                               // Alumno
};

document.addEventListener('DOMContentLoaded', () => {
  const rol = window.USER_ROLE;
  const permitidas = SECCIONES_POR_ROL[rol] || [];
  console.log('🔑 Secciones permitidas:', permitidas); // para debug

  // 1) Oculta <li> del menú
  document.querySelectorAll('.sidebar .nav-link').forEach(link => {
    const sec = link.dataset.section;
    if (!permitidas.includes(sec)) {
      const li = link.closest('li');
      if (li) li.style.display = 'none';
    }
  });

  // 2) Oculta las <section>
  document.querySelectorAll('.seccion').forEach(sec => {
    if (!permitidas.includes(sec.id)) {
      sec.hidden = true;
    }
  });

  // 3) Muestra sección por defecto (bienvenida o la primera permitida)
  let defecto = permitidas.includes('bienvenida')
              ? 'bienvenida'
              : permitidas[0];
  if (defecto) {
    document.getElementById(defecto).hidden = false;
    location.hash = defecto;
  }
});

// 4) Listener de click: sólo deja navegar a pestañas permitidas
document.querySelectorAll('.sidebar .nav-link').forEach(link => {
  link.addEventListener('click', e => {
    e.preventDefault();
    const target = link.dataset.section;
    const permitidas = SECCIONES_POR_ROL[window.USER_ROLE] || [];
    if (!permitidas.includes(target)) return; // no está permitido

    // oculta todas y muestra la elegida
    document.querySelectorAll('.seccion').forEach(sec => sec.hidden = true);
    document.getElementById(target).hidden = false;
    location.hash = target;
  });
});
