<?php

namespace App\Http\Controllers\Admin\Foundation;

use Request, Config, Lang;
use App\Services\Admin\Upload\Process as UploadManager;
use App\Http\Controllers\Admin\Controller;

/**
 *       
 *
 * 
 */
class UploadController extends Controller
{
    /**
     *       
     */
    public function index()
    {
        $parpams = Request::only('args', 'authkey');
        $args = @ unserialize(base64url_decode($parpams['args']));
        $uploadObject = new UploadManager();
        if( ! $uploadObject->setParam($args)->checkUploadToken($parpams['authkey'])) return abort(500);
        return view('admin.upload.index', compact('parpams', 'args'));
    }

    /**
     *     
     */
    public function process()
    {
        $parpams = Request::only('authkey', 'args');
        $config = @ unserialize(base64url_decode($parpams['args']));
        //        
        $uploadObject = new UploadManager();
        if( ! $uploadObject->setParam($config)->checkUploadToken($parpams['authkey'])) return abort(500);
        //      
        $file = Request::file('file');
        $returnFileUrl = $uploadObject->setFile($file)->upload();
        if( ! $returnFileUrl) return abort(500);
        return response()->json(['file'=>$returnFileUrl]);
    }

}