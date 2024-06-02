<?php namespace App\Services\Admin\Login;

abstract class AbstractProcess {

    /**
     *       
     */
    abstract public function hasLogin();

    /**
     *     
     */
    abstract public function logout();

    /**
     *     
     */
    abstract public function check($username, $password);

    /**
     *        
     */
    abstract public function validate($username, $password);

    /**
     *     
     */
    abstract public function setPublicKey();
}