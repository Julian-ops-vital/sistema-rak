<?php
namespace entities;

use entities\core\Entity;

class Alumno extends Entity
{
    public $id_est;
    public $nombre_us;
    public $apellido_us;
    public $grado_est;
    public $grupo_est;
    
    public function __construct()
    {
        parent::__construct();
        $this->Query= "SELECT 
                            e.id_est,
                            u.nombre_us AS nombre,
                            u.apellido_us AS apellido,
                            e.grado_est,
                            e.grupo_est
                        FROM estudiante e";
    }

    public function FetchResults($QueryResults)
    {
        if(count($QueryResults == 1))
        {
            $this->id_est = $QueryResults[0]['id_est'];
            $this->nombre_us = $QueryResults[0]['nombre_us'];
            $this->apellido_us = $QueryResults[0]['apellido_us'];
            $this->grado_est = $QueryResults[0]['grado_est'];
            $this->grupo_est = $QueryResults[0]['grupo_est'];
        }
    }
}