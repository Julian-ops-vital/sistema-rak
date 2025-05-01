<?php

namespace Controllers\dtos;

class AlumnoDtoUpdate extends AlumnoDtoInsert
{
	public $Id;
	
	public function __construct(array $Data, int $Id)
	{
		parent::__construct ( $Data );
		$this->Id = $Id;
	}
}