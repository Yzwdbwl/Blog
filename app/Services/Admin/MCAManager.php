<?php
namespace App\Services\Admin;

use App\Services\Admin\SC;



class MCAManager {

    
    CONST MAC_BIND_NAME = 'mac';

    
    CONST MENU_LEVEL_FIRST = 1;

    
    CONST MENU_LEVEL_SECOND = 2;

    
    CONST MENU_LEVEL_THIRD = 3;

   
    private $module;

    
    private $class;

    
    private $action;

   
    private $currentMCA;

    
    private $userPermission;

   
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * get current module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * get current action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * get current class
     */
    public function getClass()
    {
        return $this->class;
    }

    
    public function getCurrentMCAInfo()
    {
        return $this->currentMCAInfo();
    }

   
    public function getCurrentMCAfatherMenuInfo()
    {
        return $this->searchMCAMatchMenuLevelForCurrentMCA(self::MENU_LEVEL_FIRST, $this->currentMCAInfo());
    }

   
    public function getCurrentMCASecondFatherMenuInfo()
    {
        return $this->searchMCAMatchMenuLevelForCurrentMCA(self::MENU_LEVEL_SECOND, $this->currentMCAInfo());
    }

    
    public function matchFirstMenu($module, $class, $action)
    {
        $currentMCAInfo = $this->currentMCAInfo();

        if($currentMCAInfo['level'] == self::MENU_LEVEL_FIRST)
        {
            $menuInfo = $currentMCAInfo;
        }
        else
        {
            $menuInfo = $this->searchMCAMatchMenuLevelForCurrentMCA(self::MENU_LEVEL_FIRST, $currentMCAInfo);
        }
        if(empty($menuInfo)) return false;
        if($module == $menuInfo['module'] and $class == $menuInfo['class'] and $action == $menuInfo['action']) return true;
        return false;
    }

    
    public function matchSecondMenu($module, $class, $action)
    {
        $currentMCAInfo = $this->currentMCAInfo();
        if($currentMCAInfo['level'] == self::MENU_LEVEL_SECOND)
        {
            $menuInfo = $currentMCAInfo;
        }
        else
        {
            $menuInfo = $this->searchMCAMatchMenuLevelForCurrentMCA(self::MENU_LEVEL_SECOND, $currentMCAInfo);
        }
        if(empty($menuInfo)) return false;
        if($module == $menuInfo['module'] and $class == $menuInfo['class'] and $action == $menuInfo['action']) return true;
        return false;
    }

   
    public function matchThirdMenu($module, $class, $action)
    {
        $currentMCAInfo = $this->currentMCAInfo();

        if($currentMCAInfo['level'] == self::MENU_LEVEL_THIRD)
        {
            $menuInfo = $currentMCAInfo;
        }
        else
        {
            $menuInfo = $this->searchMCAMatchMenuLevelForCurrentMCA(self::MENU_LEVEL_THIRD, $currentMCAInfo);
        }
        if(empty($menuInfo)) return false;
        if($module == $menuInfo['module'] and $class == $menuInfo['class'] and $action == $menuInfo['action']) return true;
        return false;
    }

  
    private function searchMCAMatchMenuLevelForCurrentMCA($menuLevel, $currentMCAInfo)
    {
        $userPermission = $this->getUserPermission();

       if($currentMCAInfo){
           foreach($userPermission as $key => $value)
           {


               if($currentMCAInfo['pid'] == $value['id'] and ! empty($value['id']))
               {
                   if($value['level'] == $menuLevel) return $value;
                   return $this->searchMCAMatchMenuLevelForCurrentMCA($menuLevel, $value);
               }
           }
       }

        return [];
    }

    private function currentMCAInfo()
    {
        if( ! $this->currentMCA)
        {
            $userPermission = $this->getUserPermission();
//            var_dump($userPermission);
//            die;
            foreach($userPermission as $key => $value)
            {
                if($this->matchCurrentMCA($value))
                {
                    $this->currentMCA = $value;
                    break;
                }
            }
        }
        return $this->currentMCA;
    }

    /**
     * find match mca
     */
    private function matchCurrentMCA($value)
    {
        if($this->getModule() == $value['module']
            and $this->getClass() == $value['class']
                and $this->getAction() == $value['action'])

            return true;
        return false;
    }

    /**
     * return user permission
     */
    private function getUserPermission()
    {
        if( ! $this->userPermission)
            $this->userPermission = SC::getUserPermissionSession();

        return $this->userPermission;
    }

}
