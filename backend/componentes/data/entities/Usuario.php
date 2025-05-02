<?php

namespace Models\entities;

use Models\Interfaces\IEntity;

class Usuario implements IEntity
{
	public $id_us;
	public $numero_rol;
	public $email_us;
	public $contraseña_us;
	public $nombre_us;
	public $apellido_us;
	
	public function FetchResult($Data)
	{
		if($Data)
		{
			$this->id_us = $Data['id_us'];
			$this->numero_rol = $Data['numero_rol'];
			$this->email_us = $Data['email_us'];
			$this->contraseña_us = $Data['contraseña_us'];
			$this->nombre_us = $Data['nombre_us'];
			$this->apellido_us = $Data['apellido_us'];
		}
	}
}

