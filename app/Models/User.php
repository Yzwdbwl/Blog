<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Admin\Group;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function groups()
    {
        return $this->belongsTo(Group::class,'group_id');
    }

    /**
     * 
     *
     * @param string $username 
     */
    public function InfoByName($username)
    {
        return $this->where('name', $username)->first();
    }

    public function getAllUser($param = [])
    {
        $query = $this->leftJoin('group', 'users.group_id', '=', 'group.id');
        if(isset($param['group_id'])) $query->where('users.group_id', '=', intval($param['group_id']));
        $nums = isset($param['nums']) ? $param['nums'] : 15;
        $currentQuery = $query->select(array('*','users.id as id'))->orderBy('users.id', 'desc')->paginate($nums);
        return $currentQuery;
    }



   
    public function userNameList()
    {
        return $this->get()->toArray();
    }

  
    public function addUser(array $data)
    {
        return $this->create($data);
    }

   
    public function editUser(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }

    public function deleteUser(array $ids)
    {
        return $this->destroy($ids);
    }

    
    public function getOneUserById($id)
    {
        return $this->where('id', '=', intval($id))->first();
    }

    
    public function getOneUserByName($name)
    {
        return $this->where('name', '=', $name)->first();
    }

   
    public function updateLastLoginInfo($userId, $data)
    {
        $updateDatas = [];
        if(isset($data['last_login_time'])) $updateDatas['last_login_time'] = $data['last_login_time'];
        if(isset($data['last_login_ip'])) $updateDatas['last_login_ip'] = $data['last_login_ip'];
        if(empty($updateDatas)) return false;
        return $this->where('id', '=', intval($userId))->update($updateDatas);
    }

  
    public function getUserInIds($ids)
    {
        if( ! is_array($ids)) return false;
        return $this->whereIn('id', $ids)->get()->toArray();
    }
}
