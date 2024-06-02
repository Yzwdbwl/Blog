<?php

namespace App\Widget\Admin;

use App\Services\Admin\Acl\Acl;

/**
 *    
 *
 *  
 */
Abstract class AbstractBase
{
    /**
     *        
     *
     * @var object
     */
    protected $acl;

    /**
     *        
     * 
     * @var array
     */
    protected $data;

    /**
     *   module
     * 
     * @var string
     */
    protected $module;

    /**
     *   class
     * 
     * @var string
     */
    protected $class;

    /**
     *   function
     * 
     * @var string
     */
    protected $function;

    /**
     *        
     *
     * @var boolean
     */
    protected $hasPermission;

    /**
     *    
     */
    public function __construct()
    {
        $this->acl = new Acl();
    }

    /**
     *        module,class,function
     *
     * @param string $class  
     * @param string $function   
     * @param string $module   
     * @access public
     * @return object $this
     */
    public function setCurrentAction($class, $function, $module = '')
    {
        $this->module = $module;
        $this->class = $class;
        $this->function = $function;
        return $this;
    }

    /**
     *            
     * 
     * @param array $data
     * @return object $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     *        
     *
     * @param string $type    Acl::GROUP_LEVEL_TYPE_LEVEL, Acl::GROUP_LEVEL_TYPE_USER, Acl::GROUP_LEVEL_TYPE_GROUP
     * @access protected
     */
    protected function checkPermission($type = NULL)
    {
        $this->hasPermission = $this->acl->checkIfHasPermission($this->module, $this->class, $this->function);
        if(isset($this->data['id']) && in_array($type, [Acl::GROUP_LEVEL_TYPE_LEVEL, Acl::GROUP_LEVEL_TYPE_USER, Acl::GROUP_LEVEL_TYPE_GROUP])
            && ! $this->acl->checkGroupLevelPermission($this->data['id'], $type))
                $this->hasPermission = false;
    }

}