<?php
namespace Controllers\dtos\Alumnos;

use Controllers\dtos\DtoMain;
use Models\entities\Alumno;

class AlumnoDto extends DtoMain
{
    public $Id;
    public $Nombre;
    public $Grado;
    public $Grupo;
    
    public function __construct(Alumno $Source)
    {
        $this->Id = $Source->id_est;
        $this->Nombre = $Source->nombre_est;
        $this->Grado = $Source->grado_est;
        $this->Grupo = $Source->grupo_est;
    }
}