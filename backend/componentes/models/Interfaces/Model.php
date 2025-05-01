<?php
namespace Models\Interfaces;

abstract class Model
{
    public $NumRows;
    public $Query;
    public $UpdateQuery;
    public $Data;
    
    abstract public function FetchResults($Results);
}