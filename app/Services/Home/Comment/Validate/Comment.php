<?php namespace App\Services\Home\Comment\Validate;

use Validator, Lang;
use App\Services\Home\BaseValidate;

/**
 *       
 *
 *  
 */
class Comment extends BaseValidate
{
    /**
     *          
     *
     * @access public
     */
    public function add($data)
    {
        //      
        $rules = array(
            'object_id'    => 'required',
            'object_type'   => 'required',
            'content'     => 'required',
            'nickname'  => 'required',
        );
        
        //       
        $messages = array(
            'object_id.required'   => Lang::get('home.comment_object_id_empty'),
            'object_type.required'  => Lang::get('home.comment_object_type_empty'),
            'nickname.required'    => Lang::get('home.comment_nickname_empty'),
            'content.required' => Lang::get('home.comment_content_empty')
        );
        
        //    
        $validator = Validator::make($data, $rules, $messages);
        if($validator->fails())
        {
            $this->errorMsg = $validator->messages()->first();
            return false;
        }
        return true;
    }
    
}
