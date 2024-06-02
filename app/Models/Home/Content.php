<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 *      
 *
 *
 */
class Content extends Model
{
    /**
     *    Delete   
     */
    CONST IS_DELETE_NO = 1;

    /**
     *        
     */
    CONST STATUS_YES = 1;

    /**
     *       
     *
     * @var string
     */
    protected $table = 'artice';

    /**
     *    
     *
     * @var string
     */
    private $prefix;

    /**
     *         
     *
     * @return array
     */
    public function activeArticleInfo($object)
    {

        if($object->tag){
            $currentQuery = $this->where('name', 'like', "%{$object->tag}%")->orderBy('id', 'desc');
        }else{
            $currentQuery = $this->orderBy('id', 'desc');
        }


        $total = $currentQuery->get()->count();
        $currentQuery->forPage(
            $page = Paginator::resolveCurrentPage(),
            $perPage = 20
        );

        $data = $currentQuery->get()->all();

        return new LengthAwarePaginator($data, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }

    /**
     *               
     *
     * @param int $articleId    ID
     * @return array
     */
    public function getContentDetailByArticleId($articleId)
    {
        $articleId = (int) $articleId;
        $this->prefix = \DB:: getTablePrefix();
        $currentQuery = $this ->where('id', $articleId)->first();
        $info = $currentQuery->toArray();
        return $info;
    }



}
