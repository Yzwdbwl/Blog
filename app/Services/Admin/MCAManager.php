<?php
namespace App\Services\Admin;

use App\Services\Admin\SC;


/**
 *              、 、  
 *
 * 
 */
class MCAManager {

    /**
     *             
     *
     * @var string
     */
    CONST MAC_BIND_NAME = 'mac';

    /**
     *        
     *
     * @var int
     */
    CONST MENU_LEVEL_FIRST = 1;

    /**
     *        
     *
     * @var int
     */
    CONST MENU_LEVEL_SECOND = 2;

    /**
     *        
     *
     * @var int
     */
    CONST MENU_LEVEL_THIRD = 3;

    /**
     *        
     *
     * @var string
     */
    private $module;

    /**
     *       
     *
     * @var string
     */
    private $class;

    /**
     *        
     *
     * @var string
     */
    private $action;

    /**
     *                
     *
     * @var array
     */
    private $currentMCA;

    /**
     *              
     *
     * @var array
     */
    private $userPermission;

    /**
     * set current module
     *
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * set current action
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * set current class
     *
     * @param string $class
     */
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

    /**
     *             
     *
     * @return array     
     */
    public function getCurrentMCAInfo()
    {
        return $this->currentMCAInfo();
    }

    /**
     *                
     *
     * @return array     
     */
    public function getCurrentMCAfatherMenuInfo()
    {
        return $this->searchMCAMatchMenuLevelForCurrentMCA(self::MENU_LEVEL_FIRST, $this->currentMCAInfo());
    }

    /**
     *                
     *
     * @return array     
     */
    public function getCurrentMCASecondFatherMenuInfo()
    {
        return $this->searchMCAMatchMenuLevelForCurrentMCA(self::MENU_LEVEL_SECOND, $this->currentMCAInfo());
    }

    /**
     *             ，          
     *
     * @param  string $module   
     * @param  string $class   
     * @param  string $action   
     * @return true|false
     */
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

    /**
     *             ，          
     *
     * @param  string $module   
     * @param  string $class   
     * @param  string $action   
     * @return true|false
     */
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

    /**
     *             ，          
     *
     * @param  string $module   
     * @param  string $class   
     * @param  string $action   
     * @return true|false
     */
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

    /**
     *                   
     *
     * @param int $level            
     * @return array
     */
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

    /**
     *             
     *
     * @return array
     */
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
