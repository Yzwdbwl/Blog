<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;
use App\Models\Admin\Position as PositionModel;

/**
 *        
 *
 *  
 */
class Content extends AbstractBase
{
    /**
     *         
     *
     * @access public
     */
    public function edit($data)
    {
        $this->setCurrentAction('content', 'edit', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a href="'.$url.'"><i class="fa fa-pencil"></i></a>'
                        : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        return $html;
    }

    /**
     *         
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('content', 'delete', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a href="javascript:ajaxDelete(\''.$url.'\', \'ajax-reload\', \'sure?\');"><i class="fa fa-trash-o"></i></a>'
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
        $this->setCurrentAction('content', 'add', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function);
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:right;"><a href="'.$url.'" title="Add article" class="btn btn-primary btn-xs"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>Add article</a></div>'
                        : '';
        return $html;
    }

    /**
     *   Delete
     *
     * @access public
     */
    public function deleteSelect()
    {
        $this->setCurrentAction('content', 'delete', 'blog')->checkPermission();
        $html = $this->hasPermission ?
                    '<div class="btn-group btn-group-sm" style="float:left;margin:10px 0;margin-right:10px;"><a class="btn btn-primary pl-delete" data-loading="Processing..." ><i class="fa fa-trash-o"></i> <span class="sys-btn-submit-str">Batch deletion</span></a></div>'
                        : '';
        return $html;
    }

    /**
     *        
     *
     * @access public
     */
    public function position()
    {
        $this->setCurrentAction('content', 'position', 'blog')->checkPermission();
        $html = $this->hasPermission ?
                    '<div class="btn-group btn-group-sm" style="float:left;margin:10px 0;margin-right:10px;"><a class="btn btn-primary pl-position" data-loading="Processing..." ><i class="fa fa-exchange"></i> <span class="sys-btn-submit-str">Related recommendations</span></a></div>'
                        : '';
        return $html;
    }



}
