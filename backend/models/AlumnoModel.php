<?php

namespace models;

use models\Interfaces\IModel;
use models\entities\Alumno;

class AlumnoModel implements IModel
{
	public function __construct()
	{
		$this->Data = [];
		$this->NumRows = -1;
		
	}
	
	public function FetchResults($Results)
	{
		if($Results)
		{
			$this->NumRows = $Results->num_rows;
			
			foreach ($Results as $Result)
			{
				$Alumno = new Alumno();
				$Alumno->FetchResult($Result);
				array_push($this->Data, $Alumno);
			}
		}
	}
}