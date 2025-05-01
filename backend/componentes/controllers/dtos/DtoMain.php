<?php
namespace Controllers\dtos;

abstract class DtoMain
{
    public function ToJson()
    {
        return json_encode($this);
    }
}

