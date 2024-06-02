<?php namespace App\Services\Admin;

use Session, Cookie, Request;

class SC {

    
    CONST LOGIN_MARK_SESSION_KEY = 'LOGIN_MARK_SESSION';

    
    CONST PUBLIC_KEY = 'LOGIN_PROCESS_PUBLIC';

   
    CONST USER_ACL_SESSION_KEY = 'USER_ACL_SESSION';

   
    CONST ALL_PERMISSION_KEY = 'ALL_PERMISSION_KEY';

  
    static public function setLoginSession($userInfo)
    {
        return Session::put(self::LOGIN_MARK_SESSION_KEY, $userInfo);
    }

  
    static public function getLoginSession()
    {
        return Session::get(self::LOGIN_MARK_SESSION_KEY);
    }

  
    static public function delLoginSession()
    {
        Session::forget(self::LOGIN_MARK_SESSION_KEY);
        Session::flush();
        Session::regenerate();
    }

 
    static public function setPublicKey()
    {
        $key = uniqid();
        Session::put(self::PUBLIC_KEY, $key);
        return $key;
    }

 
    static public function getPublicKey()
    {
        return Session::get(self::PUBLIC_KEY);
    }

  
    static public function delPublicKey()
    {
        Session::forget(self::PUBLIC_KEY);
        Session::flush();
        Session::regenerate();
    }

   
    static public function setUserPermissionSession($aclArray)
    {
        return Session::put(self::USER_ACL_SESSION_KEY, $aclArray);
    }

  
    static public function getUserPermissionSession()
    {
        return Session::get(self::USER_ACL_SESSION_KEY);
    }

    static public function setAllPermissionSession($allAclInfo)
    {
        return Session::put(self::ALL_PERMISSION_KEY, $allAclInfo);
    }

   
    static public function getAllPermissionSession()
    {
        return Session::get(self::ALL_PERMISSION_KEY);
    }

}