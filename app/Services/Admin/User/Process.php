<?php namespace App\Services\Admin\User;

use Illuminate\Support\Facades\Hash;
use Lang;
use App\Models\User as UserModel;
use App\Models\Admin\Access as AccessModel;
use App\Services\Admin\User\Validate\User as UserValidate;
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
    private $userModel;

    /**
     *         
     *
     * @var object
     */
    private $userValidate;

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
        if( ! $this->userModel) $this->userModel = new UserModel();
        if( ! $this->userValidate) $this->userValidate = new UserValidate();
        if( ! $this->acl) $this->acl = new Acl();
    }

    /**
     *Add new user
     *
     * @param object $data
     * @access public
     * @return boolean true|false
     */
    public function addUser(\App\Services\Admin\User\Param\UserSave $data)
    {
        if( ! $this->userValidate->add($data)) return $this->setErrorMsg($this->userValidate->getErrorMessage());
        //                  
        if( ! $this->acl->checkGroupLevelPermission($data->group_id, Acl::GROUP_LEVEL_TYPE_GROUP)) return $this->setErrorMsg(Lang::get('common.account_level_deny'));
        //             
        if($this->userModel->getOneUserByName($data->name)) return $this->setErrorMsg(Lang::get('user.account_exists'));
        $data->setPassword(Hash::make($data->password));
        //        
        if($this->userModel->addUser($data->toArray()) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * Delete  
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
            if( ! $this->acl->checkGroupLevelPermission($value, Acl::GROUP_LEVEL_TYPE_USER)) return $this->setErrorMsg(Lang::get('common.account_level_deny'));
            if($value == Acl::ADMIN_ID) return $this->setErrorMsg(Lang::get('common.sys_account'));
        }
        if($this->userModel->deleteUser($ids) !== false)
        {
            $accessModel = new AccessModel();
            $result = $accessModel->deleteInfo(['type' => AccessModel::AP_USER, 'role_id' => $ids]);
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
    public function editUser(\App\Services\Admin\User\Param\UserSave $data)
    {
        if( ! isset($data->id)) return $this->setErrorMsg(Lang::get('common.action_error'));
        $id = intval(url_param_decode($data->id)); unset($data->id);
        if( ! $id) return $this->setErrorMsg(Lang::get('common.illegal_operation'));
        if( ! $this->userValidate->edit($data)) return $this->setErrorMsg($this->userValidate->getErrorMessage());
        if( ! empty($data->password)) $data->setPassword(Hash::make($data->password));
        else unset($data->password);
        //                  
        if( ! $this->acl->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_USER)) return $this->setErrorMsg(Lang::get('common.account_level_deny'));
        if($this->userModel->editUser($data->toArray(), $id) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     *        
     *
     * @return true|false
     */
    public function modifyPassword(\App\Services\Admin\User\Param\UserModifyPassword $params)
    {
        if( ! $this->userValidate->password($params)) return $this->setErrorMsg($this->userValidate->getErrorMessage());
        $loginProcess = new \App\Services\Admin\Login\Process();
        $userInfo = \App\Services\Admin\SC::getLoginSession();
        if($userInfo->password != md5($params->oldPassword)) return $this->setErrorMsg(Lang::get('user.old_password_wrong'));
        $updateData = ['password' => md5($params->newPassword)];
        if($this->userModel->editUser($updateData, $userInfo->id) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     *             
     *
     * @return array
     */
    public function getWorkflowUser($param = [])
    {
        return $this->userModel->getAllUser($param);
    }

}
