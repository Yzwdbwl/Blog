<?php
namespace App\Models\Admin;

use App\Models\Admin\Base;


class Permission extends Base
{
    
    protected $table = 'permission';

   
    protected $fillable = array('id', 'module', 'class', 'action', 'name', 'display', 'pid', 'add_time', 'mark', 'level', 'sort');

    
    public function getAllAccessPermissionByPage()
    {
        $currentQuery = $this->orderBy('sort', 'desc')->orderBy('id', 'desc')->paginate(12);
        return $currentQuery;
    }

   
    public function getAllAccessPermission()
    {
        return $this->orderBy('sort', 'desc')->orderBy('id', 'asc')->get()->toArray();
    }

    
    public function addPermission(array $data)
    {
        return $this->create($data);
    }

   
    public function editPermission(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }

   
    public function deletePermission(array $ids)
    {
        return $this->destroy($ids);
    }

    public function getOnePermissionById($id)
    {
        return $this->where('id', '=', intval($id))->first();
    }

   
    public function sortPermission($aclId, $sort)
    {
        return $this->where('id', '=', intval($aclId))->update(array('sort' => $sort));
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class,  'access','permission_id');
    }

   
    public function checkIfIsExists($module, $class, $function, $checkSelf = true, $selfId = false)
    {
        $search = $this->where('module', '=', $module)->where('class', '=', $class)->where('action', '=', $function);
        if( ! $checkSelf) $search->where('id', '!=', intval($selfId));
        return $search->first();
    }

    
    public function getSon($ids)
    {
        return $this->whereIn('pid', $ids)->get()->toArray();
    }

}
