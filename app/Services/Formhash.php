<?php

namespace App\Services;

use Request, Session;

/**
 *           
 *
 *
 */
class Formhash
{
    /**
     *          
     * 
     * @param void $data        ，                 。
     * @return string
     */
    public function hash($data)
    {
        $fullUrl = Request::fullUrl();
        $hashKey = md5($fullUrl.serialize($data));
        Session::put($hashKey, $data);
        return $hashKey;
    }

    /**
     *     
     */
    public function checkFormHash()
    {
        $formHash = Request::input('_form_hash');
        $formData = Request::all();
        if( ! $formHash) abort(500, 'form hash deny!');
        if( ! Session::has($formHash)) abort(500, 'form hash deny!');
        $hashData = Session::get($formHash);
        foreach($hashData as $key => $value)
        {
            if($formData[$key] != $value) abort(500, 'form hash deny!');
        }
        return true;
    }

}
