<?php
namespace Models;

use Models\Interfaces\Model;
use Models\entities\Usuario;

class UsuarioModel extends Model
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
				$Usuario = new Usuario();
				$Usuario->FetchResult($Result);
				array_push($this->Data, $Usuario);
			}
		}
	}
}

