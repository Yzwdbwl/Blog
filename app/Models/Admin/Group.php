<?php namespace App\Models\Admin;

use App\Models\Admin\Base;


class Group extends Base
{
 
    protected $table = 'group';


    protected $fillable = array('id', 'group_name', 'mark', 'status', 'level');



    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'access','role_id');
    }

   
    public function getAllGroupByPage()
    {
        $currentQuery = $this->orderBy('id', 'desc')->paginate(self::PAGE_NUMS);
        return $currentQuery;
    }


    public function getAllGroup()
    {
        return $this->all();
    }

  
    public function getGroupLevelLessThenCurrentUser($level)
    {
        return $this->where('level', '>', intval($level))->get()->toArray();
    }

  
    public function getOneGroupById($id)
    {
        return $this->where('id', '=', intval($id))->first();
    }

  
    public function addGroup(array $data)
    {
        return $this->create($data);
    }

  
    public function editGroup(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }

   
    public function deleteGroup(array $ids)
    {
        return $this->destroy($ids);
    }

  
    public function getGroupInIds($ids)
    {
        if( ! is_array($ids)) return false;
        return $this->whereIn('id', $ids)->get()->toArray();
    }

}
