<?php

namespace App\Widget\Admin;

use App\Services\Admin\Acl\Acl;


Abstract class AbstractBase
{
 
    protected $acl;

    
    protected $data;

    
    protected $module;

   
    protected $class;

    
    protected $function;

   
    protected $hasPermission;

    
    public function __construct()
    {
        $this->acl = new Acl();
    }

 
    public function setCurrentAction($class, $function, $module = '')
    {
        $this->module = $module;
        $this->class = $class;
        $this->function = $function;
        return $this;
    }

  
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

 
    protected function checkPermission($type = NULL)
    {
        $this->hasPermission = $this->acl->checkIfHasPermission($this->module, $this->class, $this->function);
        if(isset($this->data['id']) && in_array($type, [Acl::GROUP_LEVEL_TYPE_LEVEL, Acl::GROUP_LEVEL_TYPE_USER, Acl::GROUP_LEVEL_TYPE_GROUP])
            && ! $this->acl->checkGroupLevelPermission($this->data['id'], $type))
                $this->hasPermission = false;
    }

}