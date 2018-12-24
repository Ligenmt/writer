<?php
namespace Admin\Controller;

class ArticleController extends CommonController {

    public function index() {

        $conds = array();
        $title = $_GET['title'];
        if($title) {
            $conds['title'] = $title;
        }
        if($_GET['catid']) {
            $conds['catid'] = intval($_GET['catid']);
        }

        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = 10;
        $articles = D('Article')->getArticles($conds, $page, $pageSize);
        $count = D('Article')->getArticleCount($conds);
        $pageRes = new \Think\Page($count, $pageSize); //分页

        $this->assign('pageRes', $pageRes->show());
        $this->assign('bizs', D("Business")->select());
        $this->assign('cats', D("Category")->select());
        $this->assign('articles', $articles);
        $this->display();
    }

    public function add() {
        if($_POST) {
            //插入操作

            if(!isset($_POST['title']) || !$_POST['title']) {
                return show(0, '标题不能为空');
            }
            if(!isset($_POST['biz_id']) || !$_POST['biz_id']) {
                return show(0, '业务类型不能为空');
            }
            if(!isset($_POST['cat_id']) || !$_POST['cat_id']) {
                return show(0, '文章类型不能为空');
            }
            //更新操作
            if($_POST['article_id']) {
                $this->save($_POST);
            }

            $articleId = D("Article")->insert($_POST);
            if($articleId) {
                $contentData['content'] = $_POST['content'];
                $contentData['article_id'] = $articleId;
                $cid = D('ArticleContent')->insert($contentData);
                if ($cid) {
                    return show(1, '新增成功');
                } else {
                    return show(0, '副表插入失败');
                }
            } else {
                return show(0, '新增失败', $articleId);
            }
        } else {
            $this->assign('bizs', D("Business")->select());
            $this->assign('cats', D("Category")->select());
            //print_r($bizs);exit;
            $this->display();
        }
    }

    public function edit() {
        $articleId = $_GET['id'];
        if(!$articleId) {
            redirect('/admin.php?c=article');
        }
        $article = D('Article')->findById($articleId);
        if(!$article) {
            redirect('/admin.php?c=article');
        }
        $content = D('ArticleContent')->findById($articleId);
        if($content) {
            $article['content'] = $content['content'];
        }
        $this->assign('bizs', D('Business')->select());
        $this->assign('cats', D('Category')->select());
        $this->assign('article', $article);
        $this->display();
    }

    public function push() {
        //echo "111";
        $jumpUrl = $_POST['jump_url'];
        $push = $_POST['push'];
        if(!$push) {
            show(0, '参数非法');
        }
        $articles = D("Article")->findByIdIn($push);
        if(!$articles) {
            return $this->show(0, '无相关内容');
        }
        foreach ($articles as $article) {
            $data = array(
                'title' => $article['title'],
                'thumb' => $article['thumb'],
                'article_id' => $article['article_id'],
                'description' => $article['description'],
                'status' => 1,
                'create_time' => $article['create_time'],
            );
            $id = D("Recommand")->insert($data);
        }
        return show(1, '推送成功', array('jump_url' =>$jumpUrl));
    }

    public function save($data) {
        $articleId = $data['article_id'];
        unset($data['article_id']);
        try {


            $id = D("Article")->updateById($articleId, $data);
            $contentData['content'] = $data['content'];
            $contentid = D("ArticleContent")->updateById($articleId, $contentData);

            if($id == false) {
                return show(0, '文章更新失败');
            }
            if($contentid == false) {
                return show(0, '内容更新失败');
            }
            return show(1, '更新成功');
        } catch (\Exception $e) {
            return show(0, $e->getMessage());
        }
    }

    public function delete() {
        if($_POST) {
            $data['article_id'] = $_POST['id'];
            D("Article")->delete($data);
            D("ArticleContent")->delete($data);
            return show(1, '删除成功');
        }
    }

}