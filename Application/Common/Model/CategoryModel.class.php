<?php
namespace Common\Model;
use Think\Model;

class CategoryModel extends Model {

    private $_db = '';  //表名
    public function __construct() {
        $this->_db = M('article_category');
    }

    public function select() {
        $data = array();
        return $this->_db->where($data)->order('biz_id desc')->select();
    }

    public function getCategory($conditions, $page, $pageSize) {

        $offset = ($page - 1 ) * $pageSize;
        $data = $this->_db->where($conditions)
            ->order('biz_id desc')
            ->limit($offset, $pageSize)
            ->select();
        return $data;
    }

    public function getCategoryCount() {
        $conditions = array();
        return $this->_db->where($conditions)->count();
    }

    public function insert($data) {
        if(!$data || !is_array($data)) {
            return -1;
        }
        $data['create_time'] = time();
        $data['update_time'] = $data['create_time'];
        $data['username'] = getLoginUsername();
        return $this->_db->add($data);
    }

    public function delete($data) {
        $this->_db->where($data)->delete();
    }

    public function updateById($catId, $data) {

        if(!$catId || !is_numeric($catId)) {
            throw_exception('ID不合法');
        }
        if(!$data || !is_array($data)) {
            throw_exception('data不合法');
        }
        return $this->_db->where('cat_id='.$catId)->save($data);
    }

    public function getCategoryByBizId($data) {
        return $this->_db->where($data)->select();
    }

}