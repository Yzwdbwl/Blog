<?php namespace App\Services\Admin\ActionLog;


class Mark
{
    CONST BIND_NAME = 'ACTION_LOG_BIND_NAME';

    
    private $mark = false;

    
    private $extDatas = [];

   
    public function setMarkYes()
    {
        $this->mark = true;
        return $this;
    }

    
    public function setMarkNo()
    {
        $this->mark = false;
        return $this;
    }

    
    public function setExtDatas($extDatas)
    {
        $this->extDatas = $extDatas;
        return $this;
    }

   
    public function getExtDatas()
    {
        return $this->extDatas;
    }

   
    public function isLog()
    {
        $mark = $this->mark;
        $this->mark = false;
        return $mark;
    }
    
}
