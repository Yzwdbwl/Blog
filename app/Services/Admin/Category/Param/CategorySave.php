<?php namespace App\Services\Admin\Category\Param;

use App\Services\Admin\AbstractParam;

/**
 *              ，    ，      。
 *
 *  
 */
class CategorySave extends AbstractParam
{
    protected $name;

    protected $is_active;

    protected $id;

    public function setName($name)
    {
        $this->name = $this->attributes['name'] = $name;
        return $this;
    }

    public function setIsActive($is_active)
    {
        $this->is_active = $this->attributes['is_active'] = $is_active;
        return $this;
    }

    public function setId($id)
    {
        $this->id = $this->attributes['id'] = $id;
        return $this;
    }

}
