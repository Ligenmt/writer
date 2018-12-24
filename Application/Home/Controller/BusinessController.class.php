<?php
namespace Home\Controller;

class BusinessController extends CommonController {

    public function index(){
        $biz_id = intval($_GET['id']);
        if(!$biz_id) {
            return $this->error('业务不存在');
        }

        $data['biz_id'] = $biz_id;
        $latest_articles = D('Article')->getLatest($data, 10);

        $this->assign('bizs', D("Business")->select());
       // $this->assign('cats', D("Category")->select());
        $this->assign('latest_articles', $latest_articles);
        $this->assign('biz_id', $biz_id);
        $this->display();
    }

}