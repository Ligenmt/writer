<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
         if(!session('adminuser')) {
             redirect('/admin.php?c=login');
         }
        $this->display();
    }

}