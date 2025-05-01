<?php
namespace Config;

class ApplicationConfig extends Singleton
{
    protected function __construct($readConfigFile = true)
    {
    	if ($readConfigFile) {
    		$configFile = file_get_contents("..\config.json");
    		//$json =
    		if ($configFile)
    		{
    			$this->set(json_decode($configFile, true));
    		}
    	}
    }
    
    public function set($data) 
    {
        foreach ($data AS $key => $value)
        {
            if (is_array($value)) 
            {
                $sub = new ApplicationConfig(false);
                $sub->set($value);
                $value = $sub;
            }
            $this->{$key} = $value;
        }
    }
}