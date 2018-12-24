<?php
namespace Common\Model;
use Think\Model;

class BasicModel extends Model {


    function __construct()
    {

    }
    public function save($data) {
        if(!$data) {
            throw_exception('没有提交的数据');
        }
        return F('basic_web_config', $data);
    }

    public function select() {
        return F('basic_web_config');
    }

}