<?php
namespace Admin\Controller;

class CategoryController extends CommonController {

    public function index() {
        //$cats = D("Category")->select();
        $bizs = D("Business")->select();

        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $conditions = array();
        $pageSize = 15;
        $cats = D("Category")->getCategory($conditions, $page, $pageSize);
        $count = D("Category")->getCategoryCount();

        $pageRes = new \Think\Page($count, $pageSize); //分页

        $this->assign('pageRes', $pageRes->show());
        $this->assign('cats', $cats);
        $this->assign('bizs', $bizs);
        $this->display();
    }

    public function add() {

        if($_POST) {
            //插入操作
            if(!isset($_POST['name']) || !$_POST['name']) {
                return show(0, '菜单名不能为空');
            }
            if(!isset($_POST['biz_id']) || !$_POST['biz_id']) {
                return show(0, '模块名不能为空');
            }
            //更新操作
            if($_POST['cat_id']) {
                $this->save($_POST);
            }
            $catId = D("Category")->insert($_POST);
            if($catId) {
                return show(1, '新增成功', $catId);
            } else {
                return show(0, '新增失败', $catId);
            }
        } else {
            $bizs = D("Business")->select();
            $this->assign('bizs', $bizs);
            //print_r($bizs);exit;
            $this->display();
        }
    }

    public function save($data) {
        $catId = $data['cat_id'];
        unset($data['cat_id']);
        try {
            $id = D("Category")->updateById($catId, $data);
            if($id == false) {
                return show(0, '更新失败');
            }
            return show(1, '更新成功');
        } catch (\Exception $e) {
            return show(0, $e->getMessage());
        }
    }

    public function delete() {
        if($_POST) {
            $data['cat_id'] = $_POST['id'];
            D("Category")->delete($data);
            return show(1, '删除成功');
        }
    }

    /**
     * 根据biz_id获取category
     */
    public function category() {
        if($_POST) {
            $data['biz_id'] = $_POST['id'];
            $result = D("Category")->getCategoryByBizId($data);
            exit(json_encode($result));
        }
    }

}