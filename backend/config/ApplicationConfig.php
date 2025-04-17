<?php
namespace config;

use 'Singleton.php';

class ApplicationConfig extends Singleton
{
    protected function __construct()
    {
        $configFile = file_get_contents('./config.json');
        $json = json_decode($configFile);
        
        if ($json)
        {
            $this->set(json_decode($json, true));
        }
    }
    
    public function set($data) 
    {
        foreach ($data AS $key => $value)
        {
            if (is_array($value)) 
            {
                $sub = new ApplicationConfig();
                $sub->set($value);
                $value = $sub;
            }
            $this->{$key} = $value;
        }
    }
}