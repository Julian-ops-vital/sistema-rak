<?php
namespace Models;

use Models\Interfaces\Model;
use Models\entities\Alumno;

class AlumnoModel extends Model
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
			foreach ($Results as $Result)
			{
				$Alumno = new Alumno();
				$Alumno->FetchResult($Result);
				array_push($this->Data, $Alumno);
			}
		}
	}
}