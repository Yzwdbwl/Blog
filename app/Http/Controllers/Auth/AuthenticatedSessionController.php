<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin\Permission as PermissionModel;
use App\Models\User as UserModel;
use App\Providers\RouteServiceProvider;
use App\Services\Admin\SC;
use App\Services\Admin\Acl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    
    private $userModel;

    
    private $permissionModel;

    
    public function __construct()
    {
        if( ! $this->userModel) $this->userModel = new UserModel();
        if( ! $this->permissionModel) $this->permissionModel = new PermissionModel();
    }
    
    public function create(): View
    {
        return view('auth.login');
    }

   
    public function store(LoginRequest $request): RedirectR/esponse
    {

        $request->authenticate();
        $aclobj=new Acl\Acl();
        $request->session()->regenerate();
        $userinfo=Auth::user();
        SC::setLoginSession($userinfo);
        SC::setUserPermissionSession($aclobj->getUserAccessPermission($userinfo));
        SC::setAllPermissionSession($this->permissionModel->getAllAccessPermission());
        $url=R('common', RouteServiceProvider::HOME);
       
        return redirect()->intended($url);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin');
    }
}
