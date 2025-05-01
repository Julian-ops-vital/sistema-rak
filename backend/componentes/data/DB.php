<?php
namespace Models;

use http\Exception;
use Config\ApplicationConfig;
use Models\Interfaces\Model;
use mysqli;

class DB
{
    private ApplicationConfig $Config;
    private mysqli $Conexion;
    
    public function __construct()
    {
        try 
        {
            $this->Config = ApplicationConfig::getInstance();
            $this->Conexion = new mysqli(
            					$this->Config->DbConnectionInfo->server, 
            					$this->Config->DbConnectionInfo->username, 
            					$this->Config->DbConnectionInfo->password, 
            					$this->Config->DbConnectionInfo->database, 
            					$this->Config->DbConnectionInfo->port
            				);
        } 
        catch (Exception $e) 
        {
            echo 'Error de conexion a la base de datos: ' . $e->getMessage();
        }
    }
    
    public function Select(&$ITable)
    {
        $results = null;
        try 
        {
        	$results = $this->Conexion->query($ITable->Query);
        	$ITable->NumRows = $results->num_rows;
        	$ITable->FetchResults($results->fetch_all(MYSQLI_ASSOC));
        }
        catch (Exception $e) 
        {
        	echo 'Error al tratar de consultar la base de datos: ' . $e->getMessage() . 'Query que se intento ejecutar: ' . $ITable->Query;
        }
    }
    
    public function Insert($ITable)
    {
    	$result = null;
    	try
    	{
    		$result = $this->Conexion->query($ITable->UpdateQuery);
    		
    		if($result)
    		{
    			$ITable->Query = $ITable->Query.$this->Conexion->insert_id;
    			
    			$this->Select($ITable);
    		}
    	}
    	catch (Exception $e)
    	{
    		echo 'Error al tratar de consultar la base de datos: ' . $e->getMessage() . 'Query que se intento ejecutar: ' . $ITable->Query;
    	}
    	
    }
    
    public function Update(Model $ITable, int $id)
    {
    	$result = null;
    	try
    	{
    		$result = $this->Conexion->query($ITable->UpdateQuery);
    		
    		if($result)
    		{
    			$ITable->Query = $ITable->Query.$id;
    			
    			$this->Select($ITable);
    		}
    	}
    	catch (Exception $e)
    	{
    		echo 'Error al tratar de consultar la base de datos: ' . $e->getMessage() . 'Query que se intento ejecutar: ' . $ITable->Query;
    	}
    	
    }
    
    public function Delete(Model $ITable, int $id)
    {
    	$result = null;
    	
    	try
    	{
    		$result = $this->Conexion->query($ITable->Query);
    		
    		if($result)
    		{
    			array_push($ITable->Data, true);
    		}
    	}
    	catch (Exception $e)
    	{
    		echo 'Error al tratar de consultar la base de datos: ' . $e->getMessage() . 'Query que se intento ejecutar: ' . $ITable->Query;
    	}
    	
    }
    
    public function __destruct() 
    {
    	if (is_resource($this->Conexion) && get_resource_type($this->Conexion) === 'mysql link') 
        {
            $this->Conexion->close();
        }
    }
}
