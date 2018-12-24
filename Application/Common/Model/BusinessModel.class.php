<?php
namespace Common\Model;
use Think\Model;

class BusinessModel extends Model {


    private $_db = '';  //表名
    public function __construct() {
        $this->_db = M('article_biz');
    }

    public function select() {
        $data = array();
        return $this->_db->where($data)->order('biz_id desc')->select();
    }

    public function save($data) {
        return $this->_db->add($data);
    }

    public function selectShowInIndex() {
        $data = array();
        $data['status'] = 1; //show=1表示显示在首页
        return $this->_db->where($data)->select();
    }

}