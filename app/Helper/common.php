<?php

/**
 * 
 *
 * @param string $route 
 * @param string $urlString 
 * @param string $params 
 * @return string
 */

if( ! function_exists('R'))
{
    function R($route, $urlString, $params = [])
    {

        if( ! is_string($route) or ! is_string($urlString)) return false;
        $urlArr = explode('.', $urlString);
        if( ! isset($urlArr[2])) return false;
        $param = ['module' => $urlArr[0], 'class' => $urlArr[1], 'action' => $urlArr[2]];
        if(is_array($params)) $param = array_merge($param, $params);

        return route($route, $param);
    }
}


if( ! function_exists('widget'))
{
    function widget($widgetName)
    {
        $widgetNameEx = explode('.', $widgetName);
        if( ! isset($widgetNameEx[1])) return false;
        $widgetClass = 'App\\Widget\\'.$widgetNameEx[0].'\\'.$widgetNameEx[1];
        if(app()->bound($widgetName)) return app()->make($widgetName);
        app()->singleton($widgetName, function() use ($widgetClass)
        {
            return new $widgetClass();
        });
        return app()->make($widgetName);
    }
}


if( ! function_exists('responseJson'))
{
    function responseJson($msg, $status = false)
    {
        $status = $status ? 'success' : 'error';
        $arr = array('result' => $status, 'message' => $msg);
        return Response::json($arr);
    }
}


if( ! function_exists('showWriteTime'))
{
    function showWriteTime($time)
    {
        $interval = time() - $time;
        $format = array(
            '31536000'  => 'year',
            '2592000'   => 'month',
            '604800'    => 'week',
            '86400'     => 'day',
            '3600'      => 'hour',
            '60'        => 'minus',
            '1'         => 's'
        );
        foreach($format as $key => $value)
        {
            $match = floor($interval / (int) $key );
            if(0 != $match)
            {
                return $match . $value . 'before';
            }
        }
        return date('Y-m-d', $time);
    }
}


if ( ! function_exists('arraySort'))
{
    function arraySort($arr,$keys,$type='asc')
    {
        $keysvalue = $new_array = array();
        foreach ($arr as $k=>$v)
        {
            $keysvalue[$k] = $v[$keys];
        }
        if($type == 'asc')
        {
            asort($keysvalue);
        }
        else
        {
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach($keysvalue as $k=>$v)
        {
            $new_array[$k] = $arr[$k];
        }
        $arr = array();
        foreach($new_array as $key => $val)
        {
            $arr[] = $val;
        }
        return $arr;
    }
}


if ( ! function_exists('loadStatic'))
{
    function loadStatic($file)
    {
        $realFile = public_path().$file;
        if( ! file_exists($realFile)) return '';
        $filemtime = filemtime($realFile);
        return Request::root().$file.'?v='.$filemtime;
    }
}


if( ! function_exists('base64url_encode') )
{
    function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}


if( ! function_exists('base64url_decode') )
{
    function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}


if( ! function_exists('dir_path') )
{
    function dir_path($path)
    {
        $path = str_replace('\\', '/', $path);
        if(substr($path, -1) != '/') $path = $path.'/';
        return $path;
    }

}


if( ! function_exists('dir_create') )
{
    function dir_create($path, $mode = 0777)
    {
        if(is_dir($path)) return TRUE;
        $ftp_enable = 0;
        $path = dir_path($path);
        $temp = explode('/', $path);
        $cur_dir = '';
        $max = count($temp) - 1;
        for($i=0; $i<$max; $i++)
        {
            $cur_dir .= $temp[$i].'/';
            if (@is_dir($cur_dir)) continue;
            @mkdir($cur_dir, 0777,true);
            @chmod($cur_dir, 0777);
        }
        return is_dir($path);
    }
}


if( ! function_exists('isImage') )
{
    function isImage($ext)
    {
        $imageExt = 'jpg|gif|png|bmp|jpeg';
        if( ! in_array($ext, explode('|', $imageExt))) return false;
        return true;
    }
}


if( ! function_exists('cryptcode'))
{
    function cryptcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
    {
        return App\Libraries\Crypt::cryptcode($string, $operation, $key, $expiry);
    }
}


if( ! function_exists('url_param_encode'))
{
    function url_param_encode($string)
    {
        return base64url_encode(cryptcode($string, 'ENCODE'));
    }
}


if( ! function_exists('url_param_decode'))
{
    function url_param_decode($string)
    {
        return cryptcode(base64url_decode($string), 'DECODE');
    }
}


if( ! function_exists('form_hash'))
{
    function form_hash($data)
    {
        return (new App\Services\Formhash())->hash($data);
    }
}
