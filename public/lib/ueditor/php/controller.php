<?php
//header('Access-Control-Allow-Origin: http://www.baidu.com'); //  http://www.baidu.com      
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //       header
date_default_timezone_set("Asia/chongqing");
error_reporting(E_ERROR);
header("Content-Type: text/html; charset=utf-8");

define('IN_UEDITOR', TRUE);

//import laravel
require dirname($_SERVER['DOCUMENT_ROOT']).'/bootstrap/autoload.php';
$app = require_once dirname($_SERVER['DOCUMENT_ROOT']).'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());
use App\Services\Admin\Login\Process as LoginProcess;
$isLogin = (new LoginProcess())->getProcess()->hasLogin();
if(empty($isLogin)) return;

$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
$APPCONFIG = require(dirname($_SERVER['DOCUMENT_ROOT']).'/config/sys.php');
$action = $_GET['action'];

switch ($action) {
    case 'config':
        $result =  json_encode($CONFIG);
        break;

    /*      */
    case 'uploadimage':
    /*      */
    case 'uploadscrawl':
    /*      */
    case 'uploadvideo':
    /*      */
    case 'uploadfile':
        $result = include("action_upload.php");
        break;

    /*      */
    case 'listimage':
        $result = include("action_list.php");
        break;
    /*      */
    case 'listfile':
        $result = include("action_list.php");
        break;

    /*        */
    case 'catchimage':
        $result = include("action_crawler.php");
        break;

    default:
        $result = json_encode(array(
            'state'=> '      '
        ));
        break;
}

/*      */
if (isset($_GET["callback"])) {
    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
    } else {
        echo json_encode(array(
            'state'=> 'callback     '
        ));
    }
} else {
    echo $result;
}