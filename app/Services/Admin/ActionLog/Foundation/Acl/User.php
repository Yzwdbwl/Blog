<?php namespace App\Services\Admin\ActionLog\Foundation\Acl;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use App\Models\Admin\User as UserModel;
use Request, Lang;


class User extends AbstractActionLog
{
    
    public function handler()
    {
        if(Request::method() !== 'POST') return false;
        if( ! $this->isLog()) return false;
        $id = Request::input('id');
        $groupInfo = (new UserModel())->getOneUserById(intval($id));
        event(new ActionLog(Lang::get('actionlog.acl_user', ['username' => $groupInfo['name']])));
    }
    
}
