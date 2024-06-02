<?php namespace App\Services\Admin;

use Crypt, Session, Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Str;

class CsrfValidate {

    /**
     *        get       csrf，          
     */
    public function tokensMatch()
    {
        $token = Session::token();
        $header = Request::header('X-XSRF-TOKEN');
        $match = Str::equals($token, Request::input('_token')) ||
               ($header && Str::equals($token, $header));
        if( ! $match) throw new TokenMismatchException;
    }
}