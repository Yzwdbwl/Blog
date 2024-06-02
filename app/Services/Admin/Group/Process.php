<?php namespace App\Services\Admin\Group;

use Lang;
use App\Models\Admin\Group as GroupModel;
use App\Models\Admin\Access as AccessModel;
use App\Services\Admin\Group\Validate\Group as GroupValidate;
use App\Services\Admin\Acl\Acl;
use App\Services\Admin\BaseProcess;

/**
 *     
 *
 *  
 */
class Process extends BaseProcess
{
    /**
     *      
     * 
     * @var object
     */
    private $groupModel;

    /**
     *          
     * 
     * @var object
     */
    private $groupValidate;

    /**
     *       
     *
     * @var object
     */
    private $acl;

    /**
     *    
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->groupModel) $this->groupModel = new GroupModel();
        if( ! $this->groupValidate) $this->groupValidate = new GroupValidate();
        if( ! $this->acl) $this->acl = new Acl();
    }


    /**
     * Add new user group
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function addGroup(\App\Services\Admin\Group\Param\GroupSave $data)
    {
        if( ! $this->groupValidate->add($data)) return $this->setErrorMsg($this->groupValidate->getErrorMessage());
        //                   
        if( ! $this->acl->checkGroupLevelPermission($data->level, Acl::GROUP_LEVEL_TYPE_LEVEL)) return $this->setErrorMsg(Lang::get('common.account_level_deny'));
        if($this->groupModel->addGroup($data->toArray()) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * Delete user group
     * 
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function detele($ids)
    {
        if( ! is_array($ids)) return false;
        foreach($ids as $key => $value)
        {
            if( ! $this->acl->checkGroupLevelPermission($value, Acl::GROUP_LEVEL_TYPE_GROUP))
                return $this->setErrorMsg(Lang::get('common.account_level_deny'));
        }
        if($this->groupModel->deleteGroup($ids) !== false)
        {
            $accessModel = new AccessModel();
            $result = $accessModel->deleteInfo(['type' => AccessModel::AP_GROUP, 'role_id' => $ids]);
            return true;
        }
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     *      
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editGroup(\App\Services\Admin\Group\Param\GroupSave $data)
    {
        if( ! isset($data->id)) return $this->setErrorMsg(Lang::get('common.action_error'));
        $id = intval(url_param_decode($data->id)); unset($data->id);
        if( ! $id) return $this->setErrorMsg(Lang::get('common.illegal_operation'));
        if( ! $this->groupValidate->edit($data)) return $this->setErrorMsg($this->groupValidate->getErrorMessage());
        //                  
        if( ! $this->acl->checkGroupLevelPermission($data->level, Acl::GROUP_LEVEL_TYPE_LEVEL)) return $this->setErrorMsg(Lang::get('common.account_level_deny'));
        if($this->groupModel->editGroup($data->toArray(), $id) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

}