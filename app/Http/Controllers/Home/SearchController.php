<?php namespace App\Http\Controllers\Home;

use App\Models\Home\Search as SearchModel;
use App\Services\Home\Search\Process;
use Request;


class SearchController extends Controller
{
    /**
     * 
     */
    public function index()
    {
        $object = new \stdClass();
        $object->keyword = Request::input('keyword');
        $articleList = (new SearchModel())->activeArticleInfoBySearch($object->keyword);
        $page = '';
        if( ! empty($articleList)) $page = $articleList->setPath('')->appends(Request::all())->render();
        return view('home.index.index', compact('articleList', 'page', 'object'));
    }

}