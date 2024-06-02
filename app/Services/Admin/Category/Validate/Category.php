<?php namespace App\Services\Admin\Category\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 *          
 *
 *  
 */
class Category extends BaseValidate
{
    /**
     *              
     *
     * @access public
     */
    public function add(\App\Services\Admin\Category\Param\CategorySave $data)
    {
        //       
        $rules = array(
            'name' => 'required',
            'is_active' => 'required'
        );
        
        //        
        $messages = array(
            'name.required' => Lang::get('category.name_empty'),
            'is_active.required' => Lang::get('category.is_active_empty')
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
    public function edit(\App\Services\Admin\Category\Param\CategorySave $data)
    {
        return $this->add($data);
    }
    
}
