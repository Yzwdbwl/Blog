<?php namespace App\Services\Admin\Group\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 *          
 *
 *  
 */
class Group extends BaseValidate
{
    /**
     *              
     *
     * @access public
     */
    public function add(\App\Services\Admin\Group\Param\GroupSave $data)
    {
        //       
        $rules = array(
            'group_name' => 'required',
            'level' => 'required|numeric',
        );
        
        //        
        $messages = array(
            'group_name.required' => Lang::get('group.group_name_empty'),
            'level.required' => Lang::get('group.group_level_empty'),
            'level.numeric' => Lang::get('group.group_level_empty'),
        );
        
        //    
        $validator = Validator::make($data->toArray(), $rules, $messages);
        if($validator->fails())
        {
            $this->errorMsg = $validator->messages()->first();
            return false;
        }
        return true;
    }
    
    /**
     *              
     *
     * @access public
     */
    public function edit(\App\Services\Admin\Group\Param\GroupSave $data)
    {
        return $this->add($data);
    }
    
}
