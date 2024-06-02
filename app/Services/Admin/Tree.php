<?php namespace App\Services\Admin;

/**
 *        
 *
 * 
 */
class Tree
{
    /**
     *         
     * 
     * @var string
     */
    static public $son = 'son';
    
    /**
     *      key
     *
     * @access public
     */
    static public function getSonKey()
    {
        return self::$son;
    }

    /**
     *       ，            
     *
     * @access public
     */
    static public function prepareData(array $items)
    {
        $data = array();
        foreach($items as $value)
        {
            $id = $value['id'];
            $data[$id] = $value;
        }
        return $data;
    }

    /**
     *       
     *
     * @access public
     */
    static public function genTree(array $items)
    {
        $items = self::prepareData($items);
        foreach ($items as $item)
            $items[$item['pid']][self::$son][$item['id']] = &$items[$item['id']];
        return isset($items[0][self::$son]) ? $items[0][self::$son] : array();
    }

    /**
     *   select  option    ，         
     * 
     * @param  array $datas    
     * @param  array $id      option 
     * @param  array $prefix       
     * @return html       option  
     */
    static public function dropDownSelect(array $datas, $id = 0, $prefix = '')
    {
        $select = ''; $id = intval($id);
        
        foreach($datas as $key => $value)
        {
            //          ，  
            if(substr_count($prefix.$value['name'], '／') > 2) continue;

            $line = $prefix.$value['name'].'／';
            $isCurrent = $value['id'] == $id ? 'selected' : '';
            $select .= '<option value="'.$value['id'].'" '.$isCurrent.'>'.$prefix.$value['name'].'</option>';
            if(isset($value[self::$son]) && is_array($value[self::$son]))
            {
                $select .= self::dropDownSelect($value[self::$son], $id, $line);
            }
        }
        return $select;
    }
    
    
}
