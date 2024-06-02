<?php namespace App\Services\Admin;

/**
 *     
 *
 * 
 */
abstract class AbstractService
{
    /**
     *        
     *
     * @access protected
     */
    protected $errorMsg;
    
    /**
     *        
     *
     * @access public
     */
    public function getErrorMessage()
    {
        return $this->errorMsg;
    }

    /**
     *        
     *
     * @param string $errorMsg      
     */
    public function setErrorMsg($errorMsg)
    {
    	$this->errorMsg = $errorMsg;
    	return false;
    }
}
