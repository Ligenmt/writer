<?php

namespace Common\Model;
use Think\Model;

class MenuModel extends Model {

    private $_db = '';  //表名
    public function __construct() {
        $this->_db = M('menu');
    }

    public function insert($data = array()) {
        if(!$data || !is_array($data)) {
            return -1;
        }
        return $this->_db->add($data);
    }

    /**查询文章
     * @param $data
     * @param $page
     * @param $pageSize
     * @return mixed
     */
    public function getMenus($data, $page, $pageSize) {
        $offset = ($page - 1 ) * $pageSize;
        $list = $this->_db->where($data)->order('menu_id desc')->limit($offset, $pageSize)->select();
        return $list;
    }

    public function getMenusCount($data = array()) {
        $data['status'] = array('neq', -1);  //status -1 认为是删除
        return $this->_db->where($data)->count();
    }

    /**通过id查询菜单
     * @param array|mixed $id
     * @return array|mixed
     */
    public function find($id) {
        if (!$id || !is_numeric($id)) {
            return array();
        }
        return $this->_db->where('menu_id='.$id)->find();
    }

    public function updateMenuById($id, $data) {
        if(!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        if(!$data || !is_array($data)) {
            throw_exception('data不合法');
        }
        return $this->_db->where('menu_id='.$id)->save($data);

    }

    //更新status，用于删除
    public function updateStatus($id, $status) {
        if(!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        if(!$status || !is_numeric($status)) {
            throw_exception('Status不合法');
        }
        $data['status'] = $status;
        return $this->_db->where('menu_id='.$id)->save($data);
    }

    //获取后台菜单
    public function getAdminMenus() {
        $data = array(
          'status' => array('neq', -1),
        );
        return $this->_db->where($data)->order('listorder desc, menu_id desc')->select();
    }

    /**
     * 获取前端导航菜单
     */
    public function getBarMenus() {
        $data = array(
            'status' => array('neq', -1),
            'type' => 0,
        );
        return $this->_db->where($data)->order('listorder desc, menu_id desc')->select();
    }
}