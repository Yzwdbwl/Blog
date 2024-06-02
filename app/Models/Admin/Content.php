<?php namespace App\Models\Admin;




class Content extends Base
{
    
    protected $table = 'artice';

    
    protected $fillable = array('id', 'name', 'subtitle', 'other', 'create_at', 'content', 'is_delete', 'status');

    
    CONST IS_DELETE_NO = 1;

    
    CONST IS_DELETE_YES = 0;

    
    public function AllContents($search = [])
    {

        $currentQuery = $this->where('name', 'like', "%{$search['keyword']}%")->orderBy('id', 'desc')->paginate(self::PAGE_NUMS);
        return $currentQuery;

    }

    public function addContent(array $data)
    {
        return $this->create($data);
    }

    public function editContent(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }
    
    public function getContentDetailByArticleId($articleId)
    {
        $articleId = (int) $articleId;
        $currentQuery = $this ->where('id', $articleId)->first();
        $info = $currentQuery->toArray();
        return $info;
    }
   
    public function getOneById($id)
    {
        return $this->where('id', '=', intval($id))->first();
    }


    public function solfDeleteContent(array $data, array $ids)
    {
        return $this->whereIn('id', $ids)->update($data);
    }


}
