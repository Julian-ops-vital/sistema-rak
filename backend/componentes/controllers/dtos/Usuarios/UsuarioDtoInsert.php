<?php

namespace Controllers\dtos\Usuarios;

use Controllers\dtos\DtoMain;

class UsuarioDtoInsert extends DtoMain
{
	public $Correo;
	public $Password;
	public $Nombre;
	public $Apellido;
	public $Rol;
	
	public function __construct(array $Data)
	{
		$this->Correo = $Data['Correo'];
		$this->Password = $Data['Password'];
		$this->Nombre = $Data['Nombre'];
		$this->Apellido = $Data['Apellido'];
		$this->Rol = (int)$Data['Rol'];
	}
}