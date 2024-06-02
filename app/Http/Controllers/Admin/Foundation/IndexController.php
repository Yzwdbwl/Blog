<?php namespace App\Http\Controllers\Admin\Foundation;

use App\Services\Admin\SC;
use App\Http\Controllers\Admin\Controller;

/**
 *     
 *
 * 
 */
class IndexController extends Controller
{
    /**
     *     
     */
    public function index()
    {

        return view('admin.index.index');
    }

    /**
     *     
     */
    public function cs()
    {
        return view('admin.index.cs');
    }



}
