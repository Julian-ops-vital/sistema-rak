<?php
namespace Models\entities;

use Models\Interfaces\IEntity;

class Alumno implements IEntity
{
    public $id_est;
    public $nombre_est;
    public $grado_est;
    public $grupo_est;

	public function FetchResult($Data)
	{
		if($Data)
		{
			$this->id_est = $Data['id_est'];
			$this->nombre_est = $Data['nombre_est'];
			$this->grado_est = $Data['grado_est'];
			$this->grupo_est = $Data['grupo_est'];
		}
	}
}