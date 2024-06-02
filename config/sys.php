<?php

return [

    //             
    'login_process' => 'default',

    //     ，   http://  
    'sys_images_domain' => 'http://img.opcache.net',

    //      ，  http://  
    'sys_admin_domain' => '127.0.0.6/admin',

    //      
    'sys_blog_domain' => '127.0.0.6/index',

    //         
    'sys_blog_nopre_domain' => '127.0.0.6',

    //     ，  ueditor            ，     ueditor，         。
    'sys_upload_path' => __DIR__ . '/../upload_path',
    'sys_upload_path' => __DIR__ . '/../upload_path',

    //    
    'sys_water_file' => __DIR__ . '/../storage/water/water.png',

    //          ，*     ,module   * 
    'access_public' => [
        ['module' => 'foundation', 'class' => 'index', 'function' => '*'],
        ['module' => 'foundation', 'class' => 'user', 'function' => ['mpassword']],
        ['module' => 'foundation', 'class' => 'upload', 'function' => ['process']],
    ]
];
