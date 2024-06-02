<?php



namespace App\Services\Admin\Acl;

use Config;
use App\Models\Admin\Permission;
use App\Models\Admin\Access;
use App\Models\Admin\Group;
use App\Models\Admin\User;
use App\Services\Admin\SC;

class Acl
{
    
    CONST AP_USER = 2;

   
    CONST AP_GROUP = 1;

    
    CONST ADMIN_ROLE_ID = 1;

   
    CONST ADMIN_NAME = 'admin';

    
    CONST ADMIN_ID = 1;

    
    CONST GROUP_LEVEL_TYPE_LEVEL = 'level';

   
    CONST GROUP_LEVEL_TYPE_USER = 'user';

   
    CONST GROUP_LEVEL_TYPE_GROUP = 'group';

   
    public function getUserAccessPermission($userObj, $userOrGroup = false)
    {
        $permission = new Permission(); $access = new Access();

        if($userObj->group_id == self::ADMIN_ROLE_ID or $userObj->id == self::ADMIN_ID) return $permission->getAllAccessPermission();

        if($userOrGroup == self::AP_USER or ! $userOrGroup)
            $userAccessPermissionInfo = $access->getUserAccessPermission($userObj->id);

        if($userOrGroup == self::AP_GROUP or ! $userAccessPermissionInfo or ! $userOrGroup)
        {
            $groupAccessPermissionInfo = $access->getGroupAccessPermission($userObj->group_id);
        }

        return ($userOrGroup == self::AP_USER ? $userAccessPermissionInfo :
                    ($userOrGroup == self::AP_GROUP ? $groupAccessPermissionInfo :
                        ($userAccessPermissionInfo ? $userAccessPermissionInfo : $groupAccessPermissionInfo)
                    )
                );
    }

   
    public function checkIfHasPermission($module, $class, $function)
    {
        $module = (string) $module; $class = (string) $class; $function = (string) $function;
        if($this->isSystemManager()) return true;
        if( ! $module) $module = '';
        if($this->isNoNeedCheckPermission($module, $class, $function)) return true;
        $permissionList = SC::getUserPermissionSession();
        foreach($permissionList as $value)
        {
            if($value['module'] == $module && $value['class'] == $class && $value['action'] == $function) return true;
        }
        return false;
    }

    public function isNoNeedCheckPermission($module, $class, $function)
    {
        $info = Config::get('sys.access_public');
        foreach($info as $key => $value)
        {
            if( ! isset($value['module']) or !is_string($value['module']) or $value['module'] != $module) continue;
            if( ! isset($value['class']) or !is_string($value['class']) or ($value['class'] != $class and $value['class'] != '*')) continue;
            if($value['class'] == '*') return true;
            if( ! isset($value['function'])) continue;
            if(is_string($value['function']) and $value['function'] == '*') return true;
            if(is_string($value['function']) and $value['function'] == $function) return true;
            if(is_array($value['function']) and in_array($function, $value['function'])) return true;
        }
        return false;
    }

  
    public function checkGroupLevelPermission($id, $type)
    {
        if( ! $id) return false;
        if($this->isSuperSystemManager()) return true;
        $userObj = SC::getLoginSession();
        $groupModel = new Group(); $userModel = new User();
        $currentGroupInfo = $groupModel->getOneGroupById($userObj->group_id);
        if(empty($currentGroupInfo)) return false;
        if($type === self::GROUP_LEVEL_TYPE_LEVEL) return ($id <= $currentGroupInfo['level']) ? false : true;
        if($type === self::GROUP_LEVEL_TYPE_USER)
        {
            $userInfo = $userModel->getOneUserById($id);
            if($userInfo['name'] == self::ADMIN_NAME) return false;
            $toGroupInfo = $groupModel->getOneGroupById($userInfo['group_id']);
        }
        if($type === self::GROUP_LEVEL_TYPE_GROUP) $toGroupInfo = $groupModel->getOneGroupById($id);
        if(isset($toGroupInfo) and $toGroupInfo['level'] <= $currentGroupInfo['level']) return false;
        return true;
    }

    
    public function checkIfHasReg($module, $class, $function)
    {
        if($module == 'foundation' and $class == 'acl') return true;
        if($this->isNoNeedCheckPermission($module, $class, $function)) return true;
        $permissionList = SC::getAllPermissionSession();
//        var_dump($permissionList);
//        die;
        if(empty($permissionList)) return false;
        foreach($permissionList as $value)
        {
            if($value['module'] == $module && $value['class'] == $class && $value['action'] == $function)
                return true;
        }
        return false;
    }

    public function checkUriPermission($module, $class, $function)
    {
        return $this->checkIfHasPermission($module, $class, $function);
    }

   
    public function isSystemManager($userObj = false)
    {
        if( ! $userObj) $userObj = SC::getLoginSession();
     
        if($userObj->group_id == self::ADMIN_ROLE_ID or $this->isSuperSystemManager($userObj)) return true;
        return false;
    }

   
    public function isSuperSystemManager($userObj = false)
    {
        if( ! $userObj) $userObj = SC::getLoginSession();
        if($userObj->name == self::ADMIN_NAME or $userObj->id == self::ADMIN_ID) return true;
        return false;
    }

}
