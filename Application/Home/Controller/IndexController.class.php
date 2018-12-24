<?php
namespace Home\Controller;

class IndexController extends CommonController {
    public function index($type=''){

        //首页大图
       // $topPicNews = D("PositionContent")->select(array('status'=>1, 'position_id'=>1), 1);
        $recommands = D("Recommand")->find();
        //首页推荐小图
        //$topSmallNews = D("PositionContent")->select(array('status'=>1, 'position_id'=>2), 3);
        //广告位
        //$advNews= D("PositionContent")->select(array('status'=>1, 'position_id'=>5), 2);

        //近期文章
        $latest_articles = $this->getLatest(array());

        $show_bizs = D("Business")->selectShowInIndex();

        $show_articles = array();
        foreach ($show_bizs as $show_biz) {
//            array_push($show_bizids, $show_biz['biz_id']);
            $articles = D("Article")->findByBizId($show_biz['biz_id']);
            $show_articles = array_merge($show_articles, $articles);
        }
//        print_r($show_articles);exit;


        $this->assign('show_bizs', $show_bizs);
        $this->assign('show_articles', $show_articles);

//        $this->assign('bizs', D("Business")->select());
//        $this->assign('cats', D("Category")->select());
        $this->assign('latest_articles', $latest_articles);
        $this->assign('recommands', $recommands);


        $this->display();
//        if($type == 'buildHtml') {
//            $this->buildHtml('index', HTML_PATH, 'Index/index');
//        } else {
//            $this->display();
//        }
    }

    public function about() {
        $latest_articles = $this->getLatest(array());
        $this->assign('bizs', D("Business")->select());
        $this->assign('cats', D("Category")->select());
        $this->assign('latest_articles', $latest_articles);
        $this->assign('id', 1);
        $this->display();
    }

    public function business() {
        $latest_articles = $this->getLatest(array());
        $this->assign('bizs', D("Business")->select());
        $this->assign('cats', D("Category")->select());
        $this->assign('latest_articles', $latest_articles);
        $this->assign('id', 2);
        $this->display();
    }

    public function example() {
        $latest_articles = $this->getLatest(array());
        $this->assign('bizs', D("Business")->select());
        $this->assign('cats', D("Category")->select());
        $this->assign('latest_articles', $latest_articles);
        $this->assign('id', 3);
        $this->display();
    }

    public function connect() {
        $latest_articles = $this->getLatest(array());
        $this->assign('bizs', D("Business")->select());
        $this->assign('cats', D("Category")->select());
        $this->assign('latest_articles', $latest_articles);
        $this->assign('id', 4);
        $this->display();
    }

    public function build_html() {
        $this->index('buildHtml');
    }

}