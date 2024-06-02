<?php namespace App\Models\Admin;

use App\Models\Admin\Base;


class Access extends Base
{
    
    protected $table = 'access';
       
    CONST AP_USER = 2;
    
    CONST AP_GROUP = 1;
    
    public function getUserAccessPermission($userId)
    {
        $info = $this->leftJoin('permission', 'access.permission_id', '=', 'permission.id')
                     ->where('role_id', '=', intval($userId))->where('type', '=', self::AP_USER)
                     ->orderBy('sort', 'desc')->orderBy('permission.id', 'asc')
                     ->get();
        return $info->toArray();
    }
    
    public function getGroupAccessPermission($groupId)
    {
        $info = $this->leftJoin('permission', 'access.permission_id', '=', 'permission.id')
                     ->where('role_id', '=', intval($groupId))->where('type', '=', self::AP_GROUP)
                     ->orderBy('sort', 'desc')->orderBy('permission.id', 'asc')
                     ->get();
        return $info->toArray();
    }

    public function setPermission(array $data, $id, $allArr, $type)
    {
        if( ! in_array($type, array(self::AP_USER, self::AP_GROUP))) return false;
        //Delete
        $currentQuery = $this->from('permission')->select(array('id'))->get();
        $existPermissionIds = $currentQuery->toArray();
        //Delete
        $del = $this->where('role_id', '=', intval($id))->where('type', '=', intval($type))->where(function($query) use ($allArr, $existPermissionIds)
        {
            $query->whereIn('permission_id', $allArr)->orWhere(function($query) use ($existPermissionIds)
            {
                $query->whereNotIn('permission_id', $existPermissionIds);
            });
        })->delete();
        
        if($del !== false)
        {
            if(empty($data)) return true;
            $inserData = array();
            foreach($data as $key => $value)
            {
                $inserData[] = array(
                                'role_id' => intval($id),
                                'permission_id' => intval($value),
                                'type' => intval($type)
                            );
            }
            return $this->insert($inserData);
        }

        return false;
    }

    public function deleteInfo($where)
    {
        if(isset($where['type'], $where['role_id']) and is_array($where['role_id']) and in_array($where['type'], array(self::AP_USER, self::AP_GROUP)) )
            $search = $this->where('type', '=', $where['type'])->whereIn('role_id', array_map('intval', $where['role_id']));
        if(isset($search)) return $search->delete();
        return false;
    }

}
