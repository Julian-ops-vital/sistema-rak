<?php
namespace data;

use http\Exception;
use config\ApplicationConfig;
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
            $this->Conexion = new mysqli($this->Config['server'], $this->Config['username'], $this->Config['password'], $this->Config['database'], $this->Config['port']);
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
        	$ITable->FetchResults($results.fetch_all(MYSQLI_ASSOC));
        }
        catch (Exception $e) 
        {
        	echo 'Error al tratar de consultar la base de datos: ' . $e->getMessage() . 'Query que se intento ejecutar: ' . $ITable->Query;
        }
        finally 
        {
            if($results)
            {
                $results->free();
                $results->close();
            }
        }
    }
    
    public function __destruct() 
    {
        if ($this->Conexion) 
        {
            mysqli_close($this->Conexion);
        }
    }
}
