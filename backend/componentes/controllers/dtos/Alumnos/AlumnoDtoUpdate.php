<?php

namespace Controllers\dtos\Alumnos;

class AlumnoDtoUpdate extends AlumnoDtoInsert
{
	public $Id;
	
	public function __construct(array $Data, int $Id)
	{
		parent::__construct ( $Data );
		$this->Id = $Id;
	}
}