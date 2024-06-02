<?php

namespace App\Widget\Admin;

use App\Services\Admin\SC;
use App\Services\Admin\Tree;

/**
 *      
 *
 *  
 */
class Menu
{
    /**
     *     
     *
     * @var array
     */
    protected $list;

    /**
     *     
     *
     * @var array
     */
    protected $menuTree;

    /**
     *        
     */
    CONST DISABLE_NONE = 0;

    /**
     *        
     */
    public function leftMenu()
    {
        $this->generalData();
        return view('admin.widget.leftmenu', ['menu' => $this->menuTree]);
    }

    /**
     *        
     */
    public function contentMenu()
    {
        $contentMenu = $this->getContentMenu();
        return view('admin.widget.contentmenu', compact('contentMenu'));
    }

    /**
     *   ztree       ，        
     */
    public function ztreeNode()
    {
        $this->list = SC::getUserPermissionSession();
        $result = [];
        foreach($this->list as $key => $value) {
            if($value['display'] == self::DISABLE_NONE or $value['level'] == 4) continue;
            $url = R('common', $value['module'].'.'.$value['class'].'.'.$value['action']);
            if($value['pid'] == 0 or $this->isSecondFatherNode($value)) $url = 'javascript:;';
            $arr = ['id' => $value['id'], 'pId' => $value['pid'], 'name' => $value['name'], 'url' => $url, 'target' => '_self'];
            $arr['open'] = true;
            $result[] = $arr;
        }
        return json_encode($result);
    }

    /**
     *          
     *
     * @return boolean
     */
    private function isSecondFatherNode($currentNode)
    {
        if($currentNode['level'] != 2) return false;
        foreach($this->list as $key => $value) {
            if($value['pid'] == $currentNode['id']) return true;
        }
        return false;
    }

    /**
     *                    
     */
    protected function generalData()
    {
        $this->list = SC::getUserPermissionSession();
        foreach($this->list as $key => $value) {
            if($value['display'] == self::DISABLE_NONE) unset($this->list[$key]);
        }
        $this->menuTree = (array) Tree::genTree($this->list);
        return $this;
    }

    /**
     *          
     */
    protected function getContentMenu()
    {
        $this->list = SC::getUserPermissionSession();
        foreach($this->list as $key => $value) {
            if($value['display'] == self::DISABLE_NONE) unset($this->list[$key]);
        }
        $this->menuTree = (array) Tree::genTree($this->list);
        $son = \App\Services\Admin\Tree::getSonKey();
        $mcaName = \App\Services\Admin\MCAManager::MAC_BIND_NAME;
        $MCA = app()->make($mcaName);
        foreach($this->menuTree as $key => $value) {
            if(isset($value[$son]) and is_array($value[$son])) {
                foreach($value[$son] as $skey => $svalue) {
                    if( ! $MCA->matchSecondMenu($svalue['module'], $svalue['class'], $svalue['action'])) continue;
                    if(isset($svalue[$son]) and is_array($svalue[$son])) return $svalue[$son];
                }
            }
        }
        return [];
    }

}
