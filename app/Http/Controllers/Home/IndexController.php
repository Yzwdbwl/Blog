<?php namespace App\Http\Controllers\Home;

use App\Models\Home\Content as ContentModel;
use Request;

/**
 * blog front page
 *
 * 
 */
class IndexController extends Controller
{
    
    public function index()
    {
        $object = new \stdClass();

        $object->tag =  Request::input('tag');

    	$contentModel = new ContentModel();
    	$articleList = $contentModel->activeArticleInfo($object);
    	$page = $articleList->setPath('')->appends(Request::all())->render();
        $cacheSecond = config('home.cache_control');
        $time = date('D, d M Y H:i:s', time() + $cacheSecond) . ' GMT';
        return response(view('home.index.index', compact('articleList', 'page', 'object')))->header('Cache-Control', 'max-age='.$cacheSecond)->header('Expires', $time);
    }

    
    public function detail()
    {
        $articleId = (int) Request::input('id');
        $contentModel = new ContentModel();
        $info = $contentModel->getContentDetailByArticleId($articleId);
        return view('home.index.detail', compact('info'));
    }

}
