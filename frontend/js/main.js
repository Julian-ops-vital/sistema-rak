document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click',function (e){
        e.preventDefault();

        const target = this.getAttribute('data-section');

        //ocultar todas las secciones
        document.querySelectorAll('.seccion').forEach(sec => sec.hidden = true);

        //Muestra la seccion seleccionada
        const selectedSection = document.getElementById(target);
        if (selectedSection) selectedSection.hidden = false;
    });
});