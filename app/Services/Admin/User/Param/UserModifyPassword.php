<?php namespace App\Services\Admin\User\Param;

use App\Services\Admin\AbstractParam;

/**
 *            ，    ，      。
 *
 *  
 */
class UserModifyPassword extends AbstractParam
{
    protected $oldPassword;

    protected $newPassword;

    protected $newPasswordRepeat;

    /**
     * setOldPassword
     * @param string $oldPassword     
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $this->attributes['oldPassword'] = $oldPassword;
        return $this;
    }

    /**
     * setNewPassword
     * @param string $oldPassword     
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $this->attributes['newPassword'] = $newPassword;
        return $this;
    }

    /**
     * setNewPassword
     * @param string $oldPassword     
     */
    public function setNewPasswordRepeat($newPasswordRepeat)
    {
        $this->newPasswordRepeat = $this->attributes['newPasswordRepeat'] = $newPasswordRepeat;
        return $this;
    }

    
    
}
