<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use App\Models\Home\SearchDict as SearchDictModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

/** *
 *
 */
class Search extends Model
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
     * dict model object
     *
     * @var object
     */
    private $dictModelObject;

    /**
     *     ，      
     *
     * @var [type]
     */
    private $dictDataCache;

    /**
     *
     * @return array
     */
    public function activeArticleInfoBySearch($object)
    {

        //\DB::connection()->enableQueryLog();
        if( ! isset($object)) return [];

        $currentQuery = $this->where('name', 'like', "%{$object}%")->orderBy('id', 'desc');
        $total = $currentQuery->get()->count();
        $currentQuery->forPage(
            $page = Paginator::resolveCurrentPage(),
            $perPage = 20
        );

        $data = $currentQuery->get()->all();
        //$queries = \DB::getQueryLog();
        //dd($total, $queries);

        return new LengthAwarePaginator($data, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }



}
