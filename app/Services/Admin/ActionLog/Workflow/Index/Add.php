<?php namespace App\Services\Admin\ActionLog\Workflow\Index;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use Request, Lang;


class Add extends AbstractActionLog
{
    
    public function handler()
    {
        if(Request::method() !== 'POST') return false;
        if( ! $this->isLog()) return false;
        $workflowInfo = Request::input('data');
        if( ! isset($workflowInfo['name'])) return false;
        event(new ActionLog(Lang::get('actionlog.add_new_workflow', ['name' => $workflowInfo['name']])));
    }
    
}
