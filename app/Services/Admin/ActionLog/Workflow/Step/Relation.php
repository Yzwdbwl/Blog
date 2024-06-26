<?php namespace App\Services\Admin\ActionLog\Workflow\Step;

use App\Services\Admin\AbstractActionLog;
use App\Events\Admin\ActionLog;
use App\Services\Admin\Workflow\Process;
use App\Models\Admin\User;
use Request, Lang;


class Relation extends AbstractActionLog
{
    
    public function handler()
    {
        if(Request::method() !== 'POST') return false;
        if( ! $this->isLog()) return false;
        $extDatas = $this->getExtDatas();
        if( ! isset($extDatas['userIds']) or ! is_array($extDatas['userIds']) or empty($extDatas['userIds']) or ! isset($extDatas['stepInfo'])) return false;
        $manager = new Process();
        $workflowInfo = $manager->workflowInfo(['id' => $extDatas['stepInfo']['workflow_id'] ]);
        $userModel = new User();
        foreach($extDatas['userIds'] as $userId)
        {
            $userInfo = $userModel->getOneUserById($userId);
            event(new ActionLog(Lang::get('actionlog.set_step_user', ['workflow_step' => $extDatas['stepInfo']['name'], 'workflow' => $workflowInfo['name'], 'username' => $userInfo['realname'] ])));
        }
    }
    
}
