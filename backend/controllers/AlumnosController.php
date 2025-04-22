<?php
namespace controllers;

use controllers\dtos\AlumnoDto;
use models\AlumnoModel;
use data\DB;
use Exception;

class AlumnosController
{
	public $NumRows;
	
    public function getAlumno($id)
    {
        $Model = new AlumnoModel();
        $db = null;
        $Model->Query = "SELECT 
				            e.id_est,
				            u.nombre_us AS nombre,
				            u.apellido_us AS apellido,
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
}

