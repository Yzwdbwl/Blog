<?php namespace App\Services\Admin\ActionLog\Foundation\Group;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use Request, Lang;


class Delete extends AbstractActionLog
{
   
    public function handler()
    {
        if( ! $this->isLog()) return false;
        $extDatas = $this->getExtDatas();
        if( ! isset($extDatas['groupInfos']) or ! is_array($extDatas['groupInfos'])) return false;
        if(empty($extDatas['groupInfos']) or ! is_array($extDatas['groupInfos'])) return false;
        foreach($extDatas['groupInfos'] as $value)
        {
            event(new ActionLog(Lang::get('actionlog.delete_group', ['groupname' => $value['group_name']])));
        }
    }
    
}
