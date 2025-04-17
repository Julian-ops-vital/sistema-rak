<?php
namespace controllers;

use entities\Alumno;
use controllers\dtos\AlumnoDto;

class AlumnoController
{   
    public function getAlumno($id)
    {
        $alumno = new Alumno();
        $filterList = array("id_est = $id");
        $alumno->setSQLFilters($filterList);
        $alumno->RunQuery();
        
        return new AlumnoDto($alumno);
    }
    
}

