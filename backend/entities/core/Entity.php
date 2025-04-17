<?php
namespace entities\core;

use data\DBOperations;

abstract class Entity implements IEntity
{
    private $AdmonDB;
    
    public function __construct($QueryToDB = true)
    {
        if ($QueryToDB) 
        {
            $this->AdmonDB = new DBOperations($this);
        }
    }
    
    public function setSQLFilters($filterList)
    {
        if(count($filterList) > 0)
        {
            $this->Query .= 'where ' . implode(' and ', $filterList);
        }
    }
    
    public function RunQuery()
    {
        $this->AdmonDB->RunQuery();
    }
}