<?php

namespace Controllers\dtos\Alumnos;

use Controllers\dtos\DtoMain;

class AlumnoDtoInsert extends DtoMain
{
	public $Nombre;
	public $Grado;
	public $Grupo;
	public $CreadoPor;
	
	public function __construct(array $Data)
	{
		$this->Nombre = $Data['Nombre'];
		$this->Grado = $Data['Grado'];
		$this->Grupo = $Data['Grupo'];
		$this->CreadoPor = $Data['CreadoPor'];
	}
}