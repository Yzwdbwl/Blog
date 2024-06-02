<?php namespace App\Http\Controllers\Admin\Blog;

use Request, Lang, Session;
use App\Models\Admin\Content as ContentModel;
use App\Models\Admin\Category as CategoryModel;
use App\Models\User as UserModel;
use App\Models\Admin\Position as PositionModel;
use App\Models\Admin\Tags as TagsModel;
use App\Services\Admin\Content\Process as ContentActionProcess;
use App\Libraries\Js;
use App\Http\Controllers\Admin\Controller;

/**
 *     
 *
 * 
 */
class ContentController extends Controller
{
    
    public function index()
    {
        Session::flashInput(['http_referer' => Request::fullUrl()]);

        $search['keyword'] = strip_tags(Request::input('keyword'));


        $list = (new ContentModel())->AllContents($search);
        $page = $list->setPath('')->appends(Request::all())->render();
        $users = (new UserModel())->userNameList();

        return view('admin.content.index',
            compact('list', 'page', 'users', 'search')
        );
    }

    /**
     *     
     *
     * @access public
     */
    public function add()
    {
        if(Request::method() == 'POST') return $this->saveDatasToDatabase();

        $formUrl = R('common', 'blog.content.add');
        return view('admin.content.add', compact('formUrl'));
    }

    /**
     *         
     *
     * @access private
     */
    private function saveDatasToDatabase()
    {
        $data = (array) Request::input('data');

        $param = new \App\Services\Admin\Content\Param\ContentSave();
        $param->setAttributes($data);

        $manager = new ContentActionProcess();
        if($manager->addContent($param) !== false) return Js::locate(R('common', 'blog.content.index'), 'parent');
        return Js::error($manager->getErrorMessage());
    }

    /**
     * Delete  
     *
     * @access public
     */
    public function delete()
    {
        if( ! $id = Request::input('id')) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($id)) $id = array($id);
        $manager = new ContentActionProcess();
        if($manager->detele($id)) return responseJson(Lang::get('common.action_success'), true);
        return responseJson($manager->getErrorMessage());
    }

    /**
     *     
     *
     * @access public
     */
    public function edit()
    {
        if(Request::method() == 'POST') return $this->updateDatasToDatabase();
        Session::flashInput(['http_referer' => Session::getOldInput('http_referer')]);
        $id = Request::input('id');
        if( ! $id or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'));
        $info = (new ContentModel())->getContentDetailByArticleId($id);

        if(empty($info)) return Js::error(Lang::get('content.not_found'));


        $formUrl = R('common', 'blog.content.edit');
        return view('admin.content.add', compact('info', 'formUrl', 'id'));
    }

    /**
     *            
     *
     * @param  array $articleInfo        
     * @return array                        
     */
    private function joinArticleClassify($articleInfo)
    {
        $classifyInfo = (new ContentModel())->getArticleClassify($articleInfo['id']);
        $classifyIds = [];
        foreach ($classifyInfo as $key => $value)
        {
            $classifyIds[] = $value['classify_id'];
        }
        $articleInfo['classifyInfo'] = $classifyIds;
        return $articleInfo;
    }

    /**
     *            
     *
     * @param  array $articleInfo        
     * @return array                        
     */
    private function joinArticleTags($articleInfo)
    {
        $tagsInfo = (new ContentModel())->getArticleTag($articleInfo['id']);
        $tagsIds = [];
        foreach ($tagsInfo as $key => $value)
        {
            $tagsIds[] = $value['name'];
        }
        $articleInfo['tagsInfo'] = $tagsIds;
        return $articleInfo;
    }

    /**
     *         
     *
     * @access private
     */
    private function updateDatasToDatabase()
    {

        $httpReferer = Session::getOldInput('http_referer');
        $data = (array) Request::input('data');
        $id = intval(Request::input('id'));


        $param = new \App\Services\Admin\Content\Param\ContentSave();
        $param->setAttributes($data);

        $manager = new ContentActionProcess();

        if($manager->editContent($param, $id) !== false)
        {
            $backUrl = ( ! empty($httpReferer)) ? $httpReferer : R('common', 'blog.content.index');
            return Js::locate($backUrl, 'parent');
        }
        return Js::error($manager->getErrorMessage());
    }

    /**
     *          
     */
    public function position()
    {
        $ids = array_map('intval', (array) Request::input('ids'));
        $pids = array_map('intval', (array) Request::input('pids'));
        $manager = new ContentActionProcess();
        if($manager->articlePositionRelation($ids, $pids) !== false)
        {
            return responseJson(Lang::get('common.action_success'), true);
        }
        return responseJson(Lang::get('common.action_error'));
    }

}
