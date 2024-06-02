<?php namespace App\Services\Admin;

use Session, Cookie, Request;

class SC {

    /**
     *      session key
     */
    CONST LOGIN_MARK_SESSION_KEY = 'LOGIN_MARK_SESSION';

    /**
     *    session key
     */
    CONST PUBLIC_KEY = 'LOGIN_PROCESS_PUBLIC';

    /**
     *        key
     *
     * @var string
     */
    CONST USER_ACL_SESSION_KEY = 'USER_ACL_SESSION';

    /**
     *       key
     *
     * @var string
     */
    CONST ALL_PERMISSION_KEY = 'ALL_PERMISSION_KEY';

    /**
     *        session
     * 
     * @param array $userInfo        
     */
    static public function setLoginSession($userInfo)
    {
        return Session::put(self::LOGIN_MARK_SESSION_KEY, $userInfo);
    }

    /**
     *        session
     */
    static public function getLoginSession()
    {
        return Session::get(self::LOGIN_MARK_SESSION_KEY);
    }

    /**
     * Delete   session
     * 
     * @return void
     */
    static public function delLoginSession()
    {
        Session::forget(self::LOGIN_MARK_SESSION_KEY);
        Session::flush();
        Session::regenerate();
    }

    /**
     *          
     *
     * @return string   
     */
    static public function setPublicKey()
    {
        $key = uniqid();
        Session::put(self::PUBLIC_KEY, $key);
        return $key;
    }

    /**
     *            
     * 
     * @return string   
     */
    static public function getPublicKey()
    {
        return Session::get(self::PUBLIC_KEY);
    }

    /**
     * Delete  
     * 
     * @return void
     */
    static public function delPublicKey()
    {
        Session::forget(self::PUBLIC_KEY);
        Session::flush();
        Session::regenerate();
    }

    /**
     *          session ，      。
     * 
     * @param array $aclArray
     * @access public
     * @return true|false
     */
    static public function setUserPermissionSession($aclArray)
    {
        return Session::put(self::USER_ACL_SESSION_KEY, $aclArray);
    }

    /**
     *      session        
     *
     * @access public
     */
    static public function getUserPermissionSession()
    {
        return Session::get(self::USER_ACL_SESSION_KEY);
    }

    /**
     *          session 。
     * 
     * @access public
     * @return true|false
     */
    static public function setAllPermissionSession($allAclInfo)
    {
        return Session::put(self::ALL_PERMISSION_KEY, $allAclInfo);
    }

    /**
     *      session        
     *
     * @access public
     */
    static public function getAllPermissionSession()
    {
        return Session::get(self::ALL_PERMISSION_KEY);
    }

}