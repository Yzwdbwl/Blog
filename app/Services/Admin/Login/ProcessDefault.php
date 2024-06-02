<?php namespace App\Services\Admin\Login;

use App\Models\Admin\User as UserModel;
use App\Models\Admin\Permission as PermissionModel;
use App\Services\Admin\SC;
use App\Services\Admin\Login\AbstractProcess;
use Validator, Lang;
use Request;

/**
 *     
 *
 *  
 */
class ProcessDefault extends AbstractProcess {

    /**
     *     
     * 
     * @var object
     */
    private $userModel;

    /**
     *     
     * 
     * @var object
     */
    private $permissionModel;

    /**
     *    
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->userModel) $this->userModel = new UserModel();
        if( ! $this->permissionModel) $this->permissionModel = new PermissionModel();
    }

    /**
     *     
     *
     * @param string $username    
     * @param string $password   
     * @access public
     * @return boolean false|     
     */
    public function check($username, $password)
    {
        $userInfo = $this->userModel->InfoByName($username);
        $sign = md5($userInfo['password'].$this->getPublicKey());
        $this->delPublicKey();
        if($sign == strtolower($password))
        {
            $data['last_login_time'] = time();
            $data['last_login_ip'] = Request::ip();
            $this->userModel->updateLastLoginInfo($userInfo->id, $data);
            SC::setLoginSession($userInfo);
            SC::setAllPermissionSession($this->permissionModel->getAllAccessPermission());
            event(new \App\Events\Admin\ActionLog(Lang::get('login.login_sys'), ['userInfo' => $userInfo]));
            return $userInfo;
        }
        return false;
    }

    /**
     *   post     
     * 
     * @param string $username    
     * @param string $password   
     * @access public
     * @return false|string
     */
    public function validate($username, $password)
    {
        $this->checkCsrfToken();
        $data = array( 'username' => $username, 'password' => $password );
        $rules = array( 'username' => 'required|min:1', 'password' => 'required|min:1' );
        $messages = array(
            'username.required' => Lang::get('login.please_input_username'),
            'username.min' => Lang::get('login.please_input_username'),
            'password.required' => Lang::get('login.please_input_password'),
            'password.min' => Lang::get('login.please_input_password')
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails())
        {
            return $validator->messages()->first();
        }
        return false;
    }

    /**
     *      csrftoken
     */
    private function checkCsrfToken()
    {
        $csrf = new \App\Services\Admin\CsrfValidate();
        $csrf->tokensMatch();
    }

    /**
     *          
     *
     * @return string   
     */
    public function setPublicKey()
    {
        return SC::setPublicKey();
    }

    /**
     *            
     * 
     * @return string   
     */
    public function getPublicKey()
    {
        return SC::getPublicKey();
    }

    /**
     * Delete  
     * 
     * @return void
     */
    public function delPublicKey()
    {
        return SC::delPublicKey();
    }

    /**
     *         
     *
     * @return boolean true|false
     */
    public function hasLogin()
    {
        return SC::getLoginSession();
    }

    /**
     *     
     *
     * @return void
     */
    public function logout()
    {
        return SC::delLoginSession();
    }

}