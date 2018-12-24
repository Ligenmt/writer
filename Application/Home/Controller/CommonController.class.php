<?php
namespace Home\Controller;
use Think\Controller;
/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class CommonController extends Controller {


    public function __construct() {
        header('Content-type:text/html;charset=utf-8');
        parent::__construct();

    }


    /**
     * 最近发布文章
     */
    public function getLatest($data) {
        $articles = D('Article')->getLatest($data, 10);
        return $articles;
    }

    public function error($message = ''){
        $message = $message ? $message : '服务器有问题..';
        $this->assign('message', $message);
        $this->display('Index/error');
    }

}