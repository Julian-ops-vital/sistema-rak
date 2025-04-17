<?php
namespace entities\core;

interface IEntity
{
    public $NumRows;
    public $Query;
    public function FetchResults($QueryResults);
}