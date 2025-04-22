<?php
namespace models\entities;

use models\Interfaces\IEntity;

class Alumno implements IEntity
{
    public $id_est;
    public $nombre_us;
    public $apellido_us;
    public $grado_est;
    public $grupo_est;

	public function FetchResult($Data)
	{
		if($Data)
		{
			$this->id_est = $Data['id_est'];
			$this->nombre_us = $Data['nombre_us'];
			$this->apellido_us = $Data['apellido_us'];
			$this->grado_est = $Data['grado_est'];
			$this->grupo_est = $Data['grupo_est'];
		}
	}

}