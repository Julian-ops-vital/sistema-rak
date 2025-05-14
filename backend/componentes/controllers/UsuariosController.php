<?php

namespace Controllers;

use Controllers\dtos\Usuarios\LoginDto;
use Controllers\dtos\Usuarios\UsuarioDto;
use Controllers\dtos\Usuarios\UsuarioDtoUpdate;
use Models\DB;
use Models\UsuarioModel;
use Exception;
use Controllers\dtos\Usuarios\UsuarioDtoInsert;

class UsuariosController
{
	public function Login(LoginDto $LoginInfo)
	{
		$result = null;
		$Model = new UsuarioModel();
		$db = null;
		$Model->Query = "SELECT *
				        	FROM usuario u
							WHERE u.email_us = '$LoginInfo->Email'
							AND u.contraseña_us = '$LoginInfo->Password'";
		
		try
		{
			$db = new DB();
			$db->Select($Model);
			
			if($Model->NumRows > 0)
			{
				$result = new UsuarioDto($Model->Data[0]);
			}
		}
		catch (Exception $e)
		{
			throw new Exception("Se encontró el siguiente error: $e->getMessage()");
		}
		finally
		{
			if($db)
			{
				$db->__destruct();
			}
		}
		
		return $result;
	}
	
	public function AddUsuario(UsuarioDtoInsert $Usuario)
	{
		$Model = new UsuarioModel();
		$db = null;
		$Model->UpdateQuery = "Insert Into usuario (numero_rol, email_us, contraseña_us, nombre_us, apellido_us)
								Values ($Usuario->Rol, '$Usuario->Correo', '$Usuario->Password', '$Usuario->Nombre', '$Usuario->Apellido')";
		$Model->Query = "SELECT
				            u.id_us,
				            u.numero_rol,
				            u.email_us,
							u.nombre_us,
							u.apellido_us
				        FROM usuario u
						WHERE u.id_us = ";
		
		try
		{
			$db = new DB();
			$db->Insert($Model);
		}
		catch (Exception $e)
		{
			throw new Exception("Se encontró el siguiente error: $e->getMessage()");
		}
		finally
		{
			if($db)
			{
				$db->__destruct();
			}
		}
		
		return new UsuarioDto($Model->Data[0]);
	}
		
	public function UpdateUsuario(UsuarioDtoUpdate $Usuario)
	{
		$Model = new UsuarioModel();
		$db = null;
		$Model->UpdateQuery = "	Update usuario
								Set nombre_us = '$Usuario->Nombre',
									apellido_us = '$Usuario->Apellido',
									numero_rol = '$Usuario->Rol',
								Where id_us = $Usuario->Id";
		$Model->Query = "SELECT
				            u.id_us,
				            u.numero_rol,
				            u.email_us,
							u.contraseña_us,
							u.nombre_us,
							u.apellido_us
				        FROM usuario u
						WHERE u.id_us = ";
		
		try
		{
			$db = new DB();
			$db->Update($Model, $Usuario->Id);
		}
		catch (Exception $e)
		{
			throw new Exception("Se encontró el siguiente error: $e->getMessage()");
		}
		finally
		{
			if($db)
			{
				$db->__destruct();
			}
		}
		
		return new UsuarioDto($Model->Data[0]);
	}
	
	public function CambiarPassword($Id, $Password)
	{
		$Model = new UsuarioModel();
		$db = null;
		$Model->UpdateQuery = "	Update usuario
								Set contraseña_us = '$Password'
								Where id_us = $Id";

		$Model->Query = "SELECT
				            u.id_us,
				            u.numero_rol,
				            u.email_us,
							u.contraseña_us,
							u.nombre_us,
							u.apellido_us
				        FROM usuario u
						WHERE u.id_us = ";
		
		try
		{
			$db = new DB();
			$db->Update($Model, $Id);
		}
		catch (Exception $e)
		{
			throw new Exception("Se encontró el siguiente error: $e->getMessage()");
		}
		finally
		{
			if($db)
			{
				$db->__destruct();
			}
		}
		
		return new UsuarioDto($Model->Data[0]);
		
	}
}

