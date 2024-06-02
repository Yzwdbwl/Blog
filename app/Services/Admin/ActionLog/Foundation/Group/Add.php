<?php namespace App\Services\Admin\ActionLog\Foundation\Group;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use Request, Lang;


class Add extends AbstractActionLog
{
    
    public function handler()
    {
        if(Request::method() !== 'POST') return false;
        if( ! $this->isLog()) return false;
        $groupInfo = Request::input('data');
        if( ! isset($groupInfo['group_name'])) return false;
        event(new ActionLog(Lang::get('actionlog.add_new_group', ['groupname' => $groupInfo['group_name']])));
    }
    
}
