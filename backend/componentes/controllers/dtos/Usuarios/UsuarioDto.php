<?php

namespace Controllers\dtos\Usuarios;

use Controllers\dtos\DtoMain;
use Models\entities\Usuario;

class UsuarioDto extends DtoMain
{
	public $ID;
	public $Correo;
	public $Rol;
	public $Nombre;
	public $Apellido;
	
	public function __construct(Usuario $source)
	{
		$this->ID = $source->id_us;
		$this->Correo = $source->email_us;
		$this->Nombre = $source->nombre_us;
		$this->Apellido = $source->apellido_us;
		$this->Rol = $source->numero_rol;
	}
}

