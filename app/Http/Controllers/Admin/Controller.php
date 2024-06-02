<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use App\Services\Formhash;
use App\Services\Admin\ActionLog\Mark;


abstract class Controller extends BaseController
{
    /**
     *       
     * 
     * @return true|exception
     */
    protected function checkFormHash()
    {
        return (new Formhash())->checkFormHash();
    }

    /**
     *         
     */
    protected function setActionLog($extDatas = [])
    {
    	return app()->make(Mark::BIND_NAME)->setMarkYes()->setExtDatas($extDatas);
    }

}
