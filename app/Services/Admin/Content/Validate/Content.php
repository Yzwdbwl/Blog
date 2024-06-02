<?php namespace App\Services\Admin\Content\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 *     
 *
 *  
 */
class Content extends BaseValidate
{
    /**
     *             
     *
     * @access public
     */
    public function add(\App\Services\Admin\Content\Param\ContentSave $data)
    {
        //       
        $rules = array(
            'name' => 'required',
            'subtitle' => 'required',
            'other' => 'required',
            'content' => 'required',
            'status' => 'required',
        );

        //        
        $messages = array(
            'name.required' => Lang::get('content.name_empty'),
            'subtitle.required' => Lang::get('content.subtitle_empty'),
            'other.required' => Lang::get('content.other_empty'),
            'content.required' => Lang::get('content.content_empty'),
            'status.required' => Lang::get('content.status_empty')
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
    public function edit(\App\Services\Admin\Content\Param\ContentSave $data)
    {
        return $this->add($data);
    }

}
