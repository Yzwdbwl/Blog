<?php namespace App\Services\Home\Search;

use Lang;
use App\Services\Home\Search\Sphinx;
use App\Libraries\Spliter;
use App\Services\Home\BaseProcess;

/**
 *     
 *
 *  
 */
class Process extends BaseProcess
{
    /**
     *    sphinx   
     */
    public function sphinxSearch($keyword)
    {
        $sphinx = (new Sphinx())->initSphinxClient();
        $result = $sphinx->query($keyword, '*');
        return $this->prepareSphinxResult($result);
    }

    /**
     *   sphinx     
     */
    private function prepareSphinxResult($result)
    {
        if( ! isset($result['matches'])) return false;
        $result = arraySort($result['matches'], 'weight', 'desc');
        $articleIds = [];
        foreach($result as $key => $value)
        {
            $articleIds[] = $value['attrs']['article_id'];
        }
        return $articleIds;
    }

    /**
     *   keyword unicode 
     * 
     * @param  string $keyword
     * @return string        
     */
    public function prepareKeyword($keyword)
    {
        $spliter = new Spliter();
        $keywords = explode(' ', $keyword);
        $against = '';
        foreach($keywords as $kw)
        {
            $splitedWords = $spliter->utf8Split($kw);
            $against .= $splitedWords['words']; 
        }
        return $against;
    }

}