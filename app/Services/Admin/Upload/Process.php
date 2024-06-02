<?php namespace App\Services\Admin\Upload;

use App\Services\Admin\BaseProcess;

/**
 *     
 *
 *  
 */
class Process extends BaseProcess
{
    /**
     *          
     * 
     * @var string
     */
    private $uploadToken = 'jiang';

    /**
     *          
     * 
     * @var string
     */
    private $fileFormName = 'file';

    /**
     *        
     * 
     * @var object
     */
    private $file;

    /**
     *        
     * 
     * @var array
     */
    private $params;

    /**
     *         
     * 
     * @var string
     */
    private $saveFileName;

    /**
     *                
     * 
     * @var string
     */
    private $configSavePath;

    /**
     *          
     */
    public function setParam($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     *        
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     *         ，      
     */
    public function uploadKey()
    {
        $uploadToken = md5($this->uploadToken.$_SERVER['HTTP_USER_AGENT']);
        $authkey = md5(serialize($this->params).$uploadToken);
        return $authkey;
    }

    /**
     *   token    
     * 
     * @return boolean
     */
    public function checkUploadToken($uploadToken)
    {
        if($this->uploadKey() != $uploadToken) return false;
        return true;
    }

    /**
     *       
     *
     * @return false|string
     */
    public function upload()
    {
        //      
        if ( ! $this->file->isValid() or $this->file->getError() != UPLOAD_ERR_OK) return false;
        //     
        $savePath = $this->setSavePath();
        //      
        $saveFileName = $this->getSaveFileName().'.'.$this->file->getClientOriginalExtension();
        //  
        $this->file->move($savePath, $saveFileName);
        //      
        $realFile = $savePath.$saveFileName;
        if( ! file_exists($realFile)) return false;

        //      
        if(isset($this->params['waterSetting']) and $this->params['waterSetting'] === true)
        {
            $waterImage = $this->params['waterImage'];
            if( ! isset($this->params['waterImage']) or empty($this->params['waterImage']))
            {
                $waterImage = $this->getWaterFile();
            }
            $this->waterImage($realFile, $waterImage);
        }

        //    
        $realFileUrl[] = str_replace('/', '', str_replace($this->getConfigSavePath(), '', $realFile));
        $thumbRealFileUrl = [];

        //     
        if(isset($this->params['thumbSetting']) and ! empty($this->params['thumbSetting']))
        {
            $thumbRealFileUrl = $this->cutImage($realFile, $savePath);
        }

        $returnFileUrl = implode('|', array_merge($realFileUrl, $thumbRealFileUrl));

        return $returnFileUrl;
    }

    /**
     *     
     * 
     * @param  string $realFile           
     * @param string $waterImage         
     * @return void
     */
    private function waterImage($realFile, $waterImage)
    {
        $imagine = new \Imagine\Gd\Imagine();
        $watermark = $imagine->open($waterImage);
        $image = $imagine->open($realFile);
        $size = $image->getSize();
        $wSize = $watermark->getSize();
        $bottomRight = new \Imagine\Image\Point($size->getWidth() - $wSize->getWidth(), $size->getHeight() - $wSize->getHeight());
        $image->paste($watermark, $bottomRight);
        $image->save($realFile);
    }

    /**
     *       
     *
     * @param  string $realFile           
     * @param  string $savePath        
     * @return string                 
     */
    private function cutImage($realFile, $savePath)
    {
        if( ! isImage($this->file->getClientOriginalExtension())) throw new \Exception("Image thumb must be images.");
        $imagine = new \Imagine\Gd\Imagine();
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        $result = [];
        foreach($this->params['thumbSetting'] as $key => $value)
        {
            if(isset($value['width'], $value['height']) and is_numeric($value['width']) and is_numeric($value['height']))
            {
                $size = new \Imagine\Image\Box($value['width'], $value['height']);
                $saveName = $savePath.$this->getSaveFileName().'_'.$value['width'].'_'.$value['height'].'_thumb.'.$this->file->getClientOriginalExtension();
                $imagine->open($realFile)->thumbnail($size, $mode)->save($saveName);
                $result[] = str_replace('/', '', str_replace($this->getConfigSavePath(), '', $saveName));
            }
        }
        return $result;
    }

    /**
     *        
     *
     * @access private
     */
    private function setSavePath()
    {
        $savePath = base64url_decode($this->params['uploadPath']);
        if( ! is_dir($savePath))
        {
            //         ，     
            dir_create($savePath);
        }
        return $savePath;
    }

    /**
     *         
     * 
     * @return string
     */
    private function getSaveFileName()
    {
        if( ! $this->saveFileName) $this->saveFileName = md5(uniqid('pre', TRUE).mt_rand(1000000,9999999));
        return $this->saveFileName;
    }

    /**
     *               
     * 
     * @return string
     */
    private function getConfigSavePath()
    {
        if( ! $this->configSavePath) $this->configSavePath = \Config::get('sys.sys_upload_path');
        return $this->configSavePath;
    }

    /**
     *          
     */
    private function getWaterFile()
    {
        return \Config::get('sys.sys_water_file');
    }

}