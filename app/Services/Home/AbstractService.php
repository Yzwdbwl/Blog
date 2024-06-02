<?php namespace App\Services\Home;


abstract class AbstractService
{
    
    protected $errorMsg;
    
    
    public function getErrorMessage()
    {
        return $this->errorMsg;
    }

    
    public function setErrorMsg($errorMsg)
    {
    	$this->errorMsg = $errorMsg;
    	return false;
    }
}
