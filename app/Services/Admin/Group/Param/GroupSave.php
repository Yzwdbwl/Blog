<?php namespace App\Services\Admin\Group\Param;

use App\Services\Admin\AbstractParam;

/**
 *             ，    ，      。
 *
 *  
 */
class GroupSave extends AbstractParam
{
    protected $group_name;

    protected $level;

    protected $mark;

    protected $id;

    public function setGroupName($groupName)
    {
        $this->group_name = $this->attributes['group_name'] = $groupName;
        return $this;
    }

    public function setLevel($level)
    {
        $this->level = $this->attributes['level'] = $level;
        return $this;
    }

    public function setMark($mark)
    {
        $this->mark = $this->attributes['mark'] = $mark;
        return $this;
    }

    public function setId($id)
    {
        $this->id = $this->attributes['id'] = $id;
        return $this;
    }

}
