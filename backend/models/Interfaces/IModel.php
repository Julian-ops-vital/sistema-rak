<?php
namespace models\Interfaces;

interface IModel
{
    public $NumRows;
    public $Query;
    public $Data;
    public function FetchResults($Results);
}