<?php namespace App\Services\Admin\ActionLog\Foundation\User;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use Request, Lang;


class Add extends AbstractActionLog
{
    
    public function handler()
    {
        if(Request::method() !== 'POST') return false;
        if( ! $this->isLog()) return false;
        $userInfo = Request::input('data');
        if( ! isset($userInfo['name'])) return false;
        event(new ActionLog(Lang::get('actionlog.add_new_user', ['username' => $userInfo['name']])));
    }
    
}
