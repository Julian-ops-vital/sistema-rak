<?php
namespace controllers\dtos;

use entities\Alumno;

class AlumnoDto extends DtoMain
{
    public $Id;
    public $Nombre;
    public $Apellido;
    public $Grado;
    public $Grupo;
    
    public function __construct(Alumno $Source)
    {
        $this->Id = $Source->id_est;
        $this->Nombre = $Source->nombre_us;
        $this->Apellido = $Source->apellido_us;
        $this->Grado = $Source->grado_est;
        $this->Grupo = $Source->grupo_est;
    }
}