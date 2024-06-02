<?php if( ! defined('IN_UEDITOR')) exit;
/**
 *          
 * User: Jinqn
 * Date: 14-04-09
 * Time:   10:17
 */
include "Uploader.class.php";

/*      */
$base64 = "upload";
switch (htmlspecialchars($_GET['action'])) {
    case 'uploadimage':
        $config = array(
            "pathFormat" => $CONFIG['imagePathFormat'],
            "maxSize" => $CONFIG['imageMaxSize'],
            "allowFiles" => $CONFIG['imageAllowFiles']
        );
        $fieldName = $CONFIG['imageFieldName'];
        break;
    case 'uploadscrawl':
        $config = array(
            "pathFormat" => $CONFIG['scrawlPathFormat'],
            "maxSize" => $CONFIG['scrawlMaxSize'],
            "allowFiles" => $CONFIG['scrawlAllowFiles'],
            "oriName" => "scrawl.png"
        );
        $fieldName = $CONFIG['scrawlFieldName'];
        $base64 = "base64";
        break;
    case 'uploadvideo':
        $config = array(
            "pathFormat" => $CONFIG['videoPathFormat'],
            "maxSize" => $CONFIG['videoMaxSize'],
            "allowFiles" => $CONFIG['videoAllowFiles']
        );
        $fieldName = $CONFIG['videoFieldName'];
        break;
    case 'uploadfile':
    default:
        $config = array(
            "pathFormat" => $CONFIG['filePathFormat'],
            "maxSize" => $CONFIG['fileMaxSize'],
            "allowFiles" => $CONFIG['fileAllowFiles']
        );
        $fieldName = $CONFIG['fileFieldName'];
        break;
}
$config['sys_upload_path'] = $APPCONFIG['sys_upload_path'];
$config['sys_images_domain'] = $APPCONFIG['sys_images_domain'];

/*               */
$up = new Uploader($fieldName, $config, $base64);

/**
 *               ,    
 * array(
 *     "state" => "",          //    ，         "SUCCESS"
 *     "url" => "",            //     
 *     "title" => "",          //    
 *     "original" => "",       //     
 *     "type" => ""            //    
 *     "size" => "",           //    
 * )
 */

/*      */
return json_encode($up->getFileInfo());
