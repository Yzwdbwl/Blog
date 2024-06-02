<?php namespace App\Services\Admin\Acl;

use Lang;
use App\Services\Admin\Acl\Validate\Acl as AclValidate;
use App\Services\Admin\Acl\Acl as AclManager;
use App\Models\Admin\Permission as PermissionModel;
use App\Models\Admin\Access as AccessModel;
use App\Services\Admin\BaseProcess;


class Process extends BaseProcess
{
   
    private $permissionModel;

   
    private $aclValidate;

    private $acl;

   
    public function __construct()
    {
        if( ! $this->permissionModel) $this->permissionModel = new PermissionModel();
        if( ! $this->aclValidate) $this->aclValidate = new AclValidate();
        if( ! $this->acl) $this->acl = new AclManager();
    }

   
    public function addAcl(\App\Services\Admin\Acl\Param\AclSave $data)
    {
        if( ! $this->aclValidate->add($data)) return $this->setErrorMsg($this->aclValidate->getErrorMessage());
        if($this->permissionModel->checkIfIsExists($data->module, $data->class, $data->action)) return $this->setErrorMsg(Lang::get('acl.acl_exists'));
        $info = $this->permissionModel->getOnePermissionById(intval($data->pid));
        $data = $data->toArray();
        $data['level'] = $info['level'] + 1;
        if($this->permissionModel->addPermission($data) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

  
    public function detele($ids)
    {
        if( ! is_array($ids)) return false;
        if($this->permissionModel->getSon($ids)) return $this->setErrorMsg(Lang::get('acl.acl_has_son'));
        if($this->permissionModel->deletePermission($ids) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

   
    public function editAcl(\App\Services\Admin\Acl\Param\AclSave $data)
    {
        $id = intval(url_param_decode($data->id)); unset($data->id);
        if( ! $id) return $this->setErrorMsg(Lang::get('common.illegal_operation'));
        if( ! $this->aclValidate->edit($data)) return $this->setErrorMsg($this->aclValidate->getErrorMessage());
        if($this->permissionModel->checkIfIsExists($data->module, $data->class, $data->action, false, $id)) return $this->setErrorMsg(Lang::get('acl.acl_exists'));
        $info = $this->permissionModel->getOnePermissionById(intval($data->pid));
        $data = $data->toArray();
        $data['level'] = $info['level'] + 1;
        if($this->permissionModel->editPermission($data, intval($id)) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    private function setAcl(\App\Services\Admin\Acl\Param\AclSet $data, $type)
    {
        if( ! (new Acl())->checkGroupLevelPermission($data->id, Acl::GROUP_LEVEL_TYPE_USER)) return $this->setErrorMsg(Lang::get('common.account_level_deny'));
        $allArr = array_map('intval', explode(',', $data->all));
        $permission = array_unique($data->permission);
        $ret = (new AccessModel())->setPermission($permission, intval($data->id), $allArr, $type);
        if($ret) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

   
    public function setUserAcl(\App\Services\Admin\Acl\Param\AclSet $data)
    {
        return $this->setAcl($data, AccessModel::AP_USER);
    }

   
    public function setGroupAcl(\App\Services\Admin\Acl\Param\AclSet $data)
    {
        return $this->setAcl($data, AccessModel::AP_GROUP);
    }

}