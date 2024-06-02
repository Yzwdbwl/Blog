<?php

namespace App\Widget\Admin;

use App\Services\Admin\SC;
use Illuminate\Support\Facades\Auth;
use Request, Config;
use \App\Services\Admin\MCAManager;
/**
 *      
 *
 *  
 */
class Common
{
    /**
     * footer
     */
    public function footer()
    {
        return view('admin.widget.footer');
    }

    /**
     * header
     */
    public function header(array $widgetHeaderConfig = array())
    {
        $domain['domain'] = Request::root();
        $domain['img_domain'] = Config::get('sys.sys_images_domain');
        return view('admin.widget.header', compact('widgetHeaderConfig', 'domain'));
    }

    /**
     * top
     */
    public function top()
    {
        $username =  Auth::user()->name;
        return view('admin.widget.top', compact('username'));
    }

    /**
     * crumbs
     */
    public function crumbs($btnGroup = false)
    {


        $MCA = new MCAManager();
//        $MCA = app()->make($mcaName);
        $currentMCAinfo = $MCA->getCurrentMCAInfo();
        $topMenu = $MCA->getCurrentMCAfatherMenuInfo();
        return view('admin.widget.crumbs',
            compact('btnGroup', 'currentMCAinfo', 'topMenu')
        );
    }

    /**
     * htmlend
     */
    public function htmlend()
    {
        return '</body></html>';
    }

    /**
     *     
     */
    public function menumap()
    {
        $zTreeNode = widget('Admin.Menu')->ztreeNode();
        return view('admin.widget.menumap', compact('zTreeNode'));
    }

}
