<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
        if(session('adminuser')) {
            redirect('/index.php?m=admin&c=index');
        }
        return $this->display();
    }

    public function check() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (!trim($username)) {
            return show(0, "用户名不能为空");
        }
        if (!$password) {
            return show(0, "密码不能为空");
        }
        $ret = D('Admin')->getAdminByUsername($username);  //AdminModel.class.php放在Admin/Model下成功，大写后放在Common/Model下成功，放在Admin/Model/Admin和Common/Model/Admin下均不成功
        if(!$ret) {
            return show(0, "用户名或密码错误");
        }
//        if ($ret['password'] != getMd5Password($password)) {
        if ($ret['password'] != $password) {
            return show(0, "用户名或密码错误");
        }
        session('adminuser', $ret);
        return show(1, '登陆成功');
    }

    public function logout() {
        session('adminuser', null);
        //$this->redirect('Login/index');
        redirect('/admin.php?c=login');
    }
}