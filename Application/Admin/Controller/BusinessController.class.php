<?php
namespace Admin\Controller;

class BusinessController extends CommonController {

    public function index() {
        $result = D("Business")->select();
        $this->assign('bizs', $result);
        $this->display();
    }

    public function add() {
        if($_POST) {
            if(!$_POST['name']) {
                return show(1, '业务名称');
            }
            $id = D("Business")->save($_POST);
            return show(1, '新增成功');
        } else {
            $this->display();
        }


    }

}