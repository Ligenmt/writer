<?php
namespace Home\Controller;

class ArticleController extends CommonController {

    public function index() {
        $id = $_GET['id'];
        if(!$id || $id < 0) {
            return $this->error('错误的页面');
        }
        $article = D('Article')->findById($id);
        if(!$article) {
            return $this->error('文章不存在');
        }
        $count = intval($article['count']) + 1;
        D('Article')->updateCount($id, $count);

        $newsContent = D('ArticleContent')->findById($id);
        $content = htmlspecialchars_decode($newsContent['content']);
        $article['content'] = $content;

        //$advNews= D("PositionContent")->select(array('status'=>1, 'position_id'=>5), 2);
        //$rankNews = $this->getRank();

        //$this->assign('rankNews', $rankNews);
        $this->assign('article', $article);
        $this->assign('id', $id);
        $this->assign('bizs', D("Business")->select());
        $this->assign('cats', D("Category")->select());
        $this->display("Article/index");

    }
    //预览
    public function view() {
        if(!getLoginUsername()) {
            return $this->error('无权限');
        }
        $this->index();
    }


}