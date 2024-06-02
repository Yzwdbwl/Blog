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
   
    CONST IS_DELETE_NO = 1;

    CONST STATUS_YES = 1;

    protected $table = 'artice';

    private $prefix;

    private $dictModelObject;

    private $dictDataCache;

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
