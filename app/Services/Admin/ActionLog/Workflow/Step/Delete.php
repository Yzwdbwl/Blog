<?php namespace App\Services\Admin\ActionLog\Workflow\Step;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use Request, Lang;


class Delete extends AbstractActionLog
{
    
    public function handler()
    {
        if( ! $this->isLog()) return false;
        $extDatas = $this->getExtDatas();
        if( ! isset($extDatas['workflowStepInfo']) or ! is_array($extDatas['workflowStepInfo']) or empty($extDatas['workflowStepInfo'])) return false;
        foreach($extDatas['workflowStepInfo'] as $value)
        {
            event(new ActionLog(Lang::get('actionlog.delete_workflow_step', ['name' => $value['name']])));
        }
    }
    
}
