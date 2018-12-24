<?php
namespace Common\Model;
use Think\Model;

class AdminModel extends Model {

    private $_db = '';
    public function __construct() {
        $this->_db = M('admin');
    }

    public function getAdminByUsername($username) {
        $data = $this->_db->where('username="'.$username.'"')->find();
        return $data;
    }

}