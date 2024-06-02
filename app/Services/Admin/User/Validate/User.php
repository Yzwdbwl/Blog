<?php namespace App\Services\Admin\User\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 *       
 *
 *  
 */
class User extends BaseValidate
{
    /**
     *             
     *
     * @access public
     */
    public function add(\App\Services\Admin\User\Param\UserSave $data)
    {
        //       
        $rules = array(
            'name'      => 'required',

            'password'  => 'required',
            'group_id'  => 'required|numeric|min:1',

        );

        //        
        $messages = array(
            'name.required'      => Lang::get('user.account_name_empty'),
            'password.required'  => Lang::get('user.password_empty'),

            'group_id.required'  => Lang::get('user.group_empty'),
            'group_id.numeric'   => Lang::get('user.group_empty'),
            'group_id.min'       => Lang::get('user.group_empty'),

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
    public function edit(\App\Services\Admin\User\Param\UserSave $data)
    {
        //      
        $rules = array(
            'name'      => 'required',

            'group_id'  => 'required|numeric|min:1',

        );

        //       
        $messages = array(
            'name.required'      => Lang::get('user.account_name_empty'),

            'group_id.required'  => Lang::get('user.group_empty'),
            'group_id.numeric'   => Lang::get('user.group_empty'),
            'group_id.min'       => Lang::get('user.group_empty'),

        );

        //       ，     
        if( ! empty($data->password))
        {
            $rules['password'] = 'required';
            $messages['password.required'] = Lang::get('user.password_empty');
        }

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
    public function password(\App\Services\Admin\User\Param\UserModifyPassword $data)
    {
        //       
        $rules = array(
            'oldPassword'  => 'required',
            'newPassword' => 'required',
            'newPasswordRepeat' => 'required',
        );

        //        
        $messages = array(
            'oldPassword.required'  => Lang::get('user.password_empty'),
            'newPassword.required'  => Lang::get('user.new_password_empty'),
            'newPasswordRepeat.required' => Lang::get('user.newPasswordRepeat')
        );

        //    
        $validator = Validator::make($data->toArray(), $rules, $messages);
        if($validator->fails())
        {
            $this->errorMsg = $validator->messages()->first();
            return false;
        }

        //        
        if($data->newPassword != $data->newPasswordRepeat)
        {
            $this->errorMsg = Lang::get('user.password_comfirm');
            return false;
        }

        return true;
    }

}
