<?php

namespace Controllers;

use Models\AlumnoModel;
use Controllers\dtos\Alumnos\AlumnoDto;
use Controllers\dtos\Alumnos\AlumnoDtoInsert;
use Models\DB;
use Exception;
use Controllers\dtos\Alumnos\AlumnoDtoUpdate;

class AlumnosController
{	
	public function getAlumno($id): AlumnoDto
    {
        $Model = new AlumnoModel();
        $db = null;
        $Model->Query = "SELECT 
				            e.id_est,
				            e.nombre_est,
				            e.grado_est,
				            e.grupo_est
				        FROM estudiante e
						WHERE e.id_est = $id";
        
        try 
        {
        	$db = new DB();
        	$db->Select($Model);
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
        
        return new AlumnoDto($Model->Data[0]);
    }
    
    public function getAlumnos()
    {
    	$Model = new AlumnoModel();
    	$db = null;
    	$Alumnos = [];
    	$Model->Query = "SELECT
				            e.id_est,
				            e.nombre_est,
				            e.grado_est,
				            e.grupo_est
				        FROM estudiante e";
    	
    	try
    	{
    		$db = new DB();
    		$db->Select($Model);
    		
    		foreach ($Model->Data as $Alumno)
    		{
    			array_push($Alumnos, new AlumnoDto($Alumno));
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
    	
    	return $Alumnos;
    }
    
    public function AddAlumno(AlumnoDtoInsert $Alumno)
    {
    	$Model = new AlumnoModel();
    	$db = null;
    	$Model->UpdateQuery = "Insert Into estudiante (nombre_est, grado_est, grupo_est, id_us)
								Values ('$Alumno->Nombre', '$Alumno->Grado', '$Alumno->Grupo', $Alumno->CreadoPor)";
    	$Model->Query = "SELECT
				            e.id_est,
				            e.nombre_est,
				            e.grado_est,
				            e.grupo_est
				        FROM estudiante e
						WHERE e.id_est = ";
    	
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
    	
    	return new AlumnoDto($Model->Data[0]);
    }
    
    public function UpdateAlumno(AlumnoDtoUpdate $Alumno)
    {
    	$Model = new AlumnoModel();
    	$db = null;
    	$Model->UpdateQuery = "	Update estudiante 
								Set nombre_est = '$Alumno->Nombre', 
									grado_est = '$Alumno->Grado', 
									grupo_est = '$Alumno->Grupo', 
									id_us = $Alumno->CreadoPor
								Where id_est = $Alumno->Id";
    	$Model->Query = "SELECT
				            e.id_est,
				            e.nombre_est,
				            e.grado_est,
				            e.grupo_est
				        FROM estudiante e
						WHERE e.id_est = ";
    	
    	try
    	{
    		$db = new DB();
    		$db->Update($Model, $Alumno->Id);
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
    	
    	return new AlumnoDto($Model->Data[0]);
    }
    
    public function DeleteAlumno(int $id)
    {
    	$Model = new AlumnoModel();
    	$db = null;
       	$Model->Query = "Delete	From estudiante
						WHERE id_est = $id";
    	
    	try
    	{
    		$db = new DB();
    		$db->Delete($Model, $id);
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
    	
    	return $Model->Data[0];
    	
    }
}

