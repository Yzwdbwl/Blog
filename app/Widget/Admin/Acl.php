<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;
use App\Services\Admin\Acl\Acl as AclManager;

/**
 *        
 *
 *  
 */
class Acl extends AbstractBase
{
    /**
     *         
     *
     * @access public
     */
    public function edit($data)
    {
        $this->setCurrentAction('acl', 'edit', 'foundation')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => url_param_encode($data['id'])]);
        $html = $this->hasPermission ?
                    '<a href="'.$url.'"><i class="fa fa-pencil"></i></a>'
                        : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        return $html;
    }

    /**
     *     Delete  
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('acl', 'delete', 'foundation')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => url_param_encode($data['id'])]);
        $html = $this->hasPermission ?
                    '<a href="javascript:ajaxDelete(\''.$url.'\', \'sys-list\', \'Are you sure you want to delete?\');"><i class="fa fa-trash-o"></i></a>'
                        : '<i class="fa fa-trash-o" style="color:#ccc"></i>';
        return $html;
    }

    /**
     *        
     *
     * @access public
     */
    public function navBtn()
    {
        $this->setCurrentAction('acl', 'add', 'foundation')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function);
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:right;"><a href="'.$url.'" title="Add new funtion" class="btn btn-primary btn-xs"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>Add new funtion</a></div>'
                        : '';
        return $html;
    }

    /**
     *      
     *
     * @access public
     */
    public function sort()
    {
        $this->setCurrentAction('acl', 'sort', 'foundation')->checkPermission();
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:left;margin:10px 0;margin-right:20px;"><a class="btn btn-primary btn-sm sys-btn-submit" data-loading="Processing..." ><i class="fa fa-sort"></i> <span class="sys-btn-submit-str">Ranking</span></a></div>'
                        : '';
        return $html;
    }

    /**
     *       key
     *
     * @var string
     */
    private $son;

    /**
     *   select  option    ，         
     *
     * @param  array $datas    
     * @param  mixed $prefix       ，   false
     * @return html       option  
     */
    public function acllist(array $datas, $pid, $prefix = false)
    {
        $html = '';

        if( ! $this->son) $this->son = \App\Services\Admin\Tree::getSonKey();

        foreach($datas as $key => $value)
        {
            if($prefix === false)
            {
                if($pid != $value['id'] && $pid != '0') continue;
            }
            $line = ($prefix === false ? '' : $prefix).'┆┄';
            $html .= view('admin.acl.list', compact('value', 'prefix'));
            if(isset($value[$this->son]) && is_array($value[$this->son]))
            {
                $html .= $this->acllist($value[$this->son], $pid, $line);
            }
        }
        return $html;
    }

}
