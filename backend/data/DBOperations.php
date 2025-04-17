<?php
namespace data;

use http\Exception;
use config\ApplicationConfig;
use mysqli;
use entities\core\IEntity;

class DBOperations
{
    private ApplicationConfig $Config;
    private mysqli $Conexion;
    private IEntity $Entity;
    
    public function __construct($Entity)
    {
        try 
        {
            $this->Entity = $Entity;
            $this->Config = ApplicationConfig::getInstance();
            $this->Conexion = new mysqli($this->Config['server'], $this->Config['username'], $this->Config['password'], $this->Config['database'], $this->Config['port']);
        } 
        catch (Exception $e) 
        {
            echo 'Error de conexion a la base de datos: ' . $e->getMessage();
        }
    }
    
    public function RunQuery()
    {
        try 
        {
            $results = $this->Conexion->query($this->Entity->Query);
            $this->Entity->NumRows = $results->num_rows;
            $this->Entity->FetchResults($results.fetch_all(MYSQLI_ASSOC));
        } 
        catch (Exception $e) 
        {
            echo 'Error al tratar de consultar la base de datos: ' . $e->getMessage() . 'Query que se intento ejecutar: ' . $this->Entity->Query;
        }
    }
    
    public function __destruct() 
    {
        mysqli_close($this->Conexion);
    }
}
