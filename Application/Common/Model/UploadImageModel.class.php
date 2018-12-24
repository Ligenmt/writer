<?php
namespace Common\Model;
use Think\Model;

class UploadimageModel extends Model {
    private $_uploadObj = '';
    private $_uploadImageData = '';

    const UPLOAD = 'upload';

    function __construct()
    {
        $this->_uploadObj = new \Think\Upload();

        $this->_uploadObj->rootPath = './'.self::UPLOAD.'/';
        $this->_uploadObj->subName = date(Y).'/'.date('m').'/'.date(d);
    }

    /**
     * 针对编辑器的图片上传
     */
    public function upload() {
        $res = $this->_uploadObj->upload();
        if($res) {
            return '/' .self::UPLOAD.'/'.$res['imgFile']['savepath']. $res['imgFile']['savename'];
        } else {
            return false;
        }

    }

    public function imageUpload() {

        $res = $this->_uploadObj->upload();
        //print_r($res);exit;
        if($res) {
            return '/' .self::UPLOAD.'/'.$res['file']['savepath']. $res['file']['savename'];
        } else {
            return false;
        }

    }
}