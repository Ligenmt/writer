<?php
namespace Admin\Controller;
use Think\Controller;

class RecommandController extends CommonController {

    public function index(){

        $contents = D("Recommand")->find();
        //$articles = D("Article")->find();
        $this->assign('contents', $contents);
        $this->display();
    }

    public function add() {

    }



}