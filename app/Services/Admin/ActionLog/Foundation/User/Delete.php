<?php namespace App\Services\Admin\ActionLog\Foundation\User;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use App\Models\Admin\User;
use Request, Lang;


class Delete extends AbstractActionLog
{
    
    public function handler()
    {
        if( ! $this->isLog()) return false;
        $extDatas = $this->getExtDatas();
        if( ! isset($extDatas['userInfos']) or ! is_array($extDatas['userInfos'])) return false;
        if(empty($extDatas['userInfos']) or ! is_array($extDatas['userInfos'])) return false;
        foreach($extDatas['userInfos'] as $value)
        {
            event(new ActionLog(Lang::get('actionlog.delete_user', ['username' => $value['name']])));
        }
    }
    
}
