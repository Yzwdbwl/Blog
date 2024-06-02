<?php

namespace App\Widget\Admin;

use Config;
use App\Services\Admin\Upload\Process as UploadManager;


class Upload
{
   
    private $config = [
        'id' => '', 
        'callback' => '', 
        'alowexts' => '', 
        'nums' => '', 
        'thumbSetting' => '',
        'waterSetting' => '', 
        'waterImage' => '', 
        'uploadPath' => '', 
        'filesize' => '',
    ];

    
    public function setConfig(array $config)
    {
        foreach($config as $key => $value)
        {
            if(isset($this->config[$key])) $this->config[$key] = $value;
        }
        return $this;
    }

   
    public function uploadButton()
    {
        $config = $this->config;
        if( ! isset($config['alowexts']) or empty($config['alowexts'])) $config['alowexts'] = 'jpg,jpeg,gif,bmp,png,doc,docx';
        $uploadObject = new UploadManager();
        if( ! isset($config['uploadPath']) or empty($config['uploadPath'])) $config['uploadPath'] = Config::get('sys.sys_upload_path').'/';
        $config['uploadPath'] = base64url_encode($config['uploadPath']);

        $config['uploadUrl'] = R('common', 'foundation.upload.index');
        $authkey = $uploadObject->setParam($config)->uploadKey();
        return view('admin.widget.uploadbutton',
            compact('config', 'authkey')
        );
    }

}