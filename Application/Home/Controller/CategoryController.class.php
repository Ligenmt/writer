<?php
namespace Home\Controller;

class CategoryController extends CommonController {

    public function index(){
        $cat_id = intval($_GET['id']);
        if(!$cat_id) {
            return $this->error('栏目不存在');
        }
        $data['cat_id'] = $cat_id;
        $latest_articles = $this->getLatest($data);

        $this->assign('bizs', D("Business")->select());
        $this->assign('cats', D("Category")->select());
        $this->assign('latest_articles', $latest_articles);
        $this->assign('cat_id', 0);
        $this->display();
    }



}