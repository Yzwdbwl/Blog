<?php namespace App\Services\Admin\ActionLog\Foundation\Acl;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use App\Models\Admin\Group as GroupModel;
use Request, Lang;


class Group extends AbstractActionLog
{
   
    public function handler()
    {
        if(Request::method() !== 'POST') return false;
        if( ! $this->isLog()) return false;
        $id = Request::input('id');
        $groupInfo = (new GroupModel())->getOneGroupById(intval($id));
        event(new ActionLog(Lang::get('actionlog.acl_group', ['groupname' => $groupInfo['group_name']])));
    }
    
}
