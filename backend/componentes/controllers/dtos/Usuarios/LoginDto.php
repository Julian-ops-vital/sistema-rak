<?php

namespace Controllers\dtos\Usuarios;

use Controllers\dtos\DtoMain;

class LoginDto extends DtoMain
{
	public $Email;
	public $Password;
	
	public function __construct($Data)
	{
		$this->Email = $Data['Email'];
		$this->Password = $Data['Password'];
	}
	
	public function HashPassword()
	{
		return password_hash($this->password, PASSWORD_DEFAULT);
	}
}

