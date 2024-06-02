<?php namespace App\Services\Admin\Acl\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 *       
 *
 * 
 */
class Acl extends BaseValidate
{
    /**
     *             
     *
     * @access public
     */
    public function add(\App\Services\Admin\Acl\Param\AclSave $data)
    {
        //      
        $rules = array(
            'name'    => 'required',
            'module'  => 'required',
            'class'   => 'required',
            'action'  => 'required',
            'pid'     => 'required|numeric',
        );
        
        //       
        $messages = array(
            'name.required'   => Lang::get('acl.acl_name_empty'),
            'module.required'  => Lang::get('acl.acl_module_empty'),
            'class.required'  => Lang::get('acl.acl_class_empty'),
            'pid.numeric'     => Lang::get('acl.acl_pid_empty'),
            'pid.required'    => Lang::get('acl.acl_pid_empty'),
            'action.required' => Lang::get('acl.acl_action_empty')
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
    public function edit(\App\Services\Admin\Acl\Param\AclSave $data)
    {
        return $this->add($data);
    }
    
}
