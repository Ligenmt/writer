<?php
namespace Common\Model;
use Think\Model;

class RecommandModel extends Model {

    private $_db = '';  //表名
    public function __construct() {
        $this->_db = M('recommand');
    }

    public function insert($data) {
        return $this->_db->add($data);
    }

    public function find($data = array()) {
        $data['status'] = array('neq', -1);
        $list = $this->_db->where($data)->order('id desc')->select();
        return $list;
    }

}