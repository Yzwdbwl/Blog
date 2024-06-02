<?php namespace App\Http\Controllers\Admin\Foundation;

use App\Services\Admin\SC;
use App\Http\Controllers\Admin\Controller;

/**
 * 登录相关
 *
 * 
 */
class IndexController extends Controller
{
    /**
     * 显示首页
     */
    public function index()
    {

        return view('admin.index.index');
    }

    /**
     * 显示首页
     */
    public function cs()
    {
        return view('admin.index.cs');
    }



}
