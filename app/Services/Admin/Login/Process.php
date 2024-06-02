<?php namespace App\Services\Admin\Login;

use Config;
use App\Services\Admin\Login\AbstractProcess;

/**
 *     
 *
 *  
 */
class Process {

    /**
     *       
     * 
     * @var object
     */
    private $process;

    /**
     *    
     *
     * @access public
     */
    public function __construct()
    {
        $useProcess = '\\App\\Services\\Admin\\Login\\Process' . ucfirst(Config::get('sys.login_process'));
        $class = new $useProcess();
        $check = $class instanceof AbstractProcess;
        if( ! $check) throw new \Exception("login process class must be instanceof AbstractProcess!!");
        
        if( ! $this->process) $this->process = new $class;
    }

    /**
     *          
     *
     * @return object
     */
    public function getProcess()
    {
        return $this->process;
    }

}