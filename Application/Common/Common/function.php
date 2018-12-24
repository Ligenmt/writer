<?php
/**
 * 一些公用的方法
 */
function show($status, $message, $data = array()) {
    $result = array(
        'status' => $status,
        'message' => $message,
        'data' => $data
    );
    exit(json_encode($result));
}

function getMd5Password($password) {
    return md5($password . C('MD5_PRE'));
}

function getMenuType($type) {
    return $type == 1 ? '后台菜单' : '前端导航';
}

function getStatus($status) {
    return $status == 0 ? '关闭' : '正常';
}
//获取菜单中url
function getAdminMenuUrl($nav) {
    $url = 'admin.php?c='.$nav['c'].'&a='.$nav['a'];
    if($nav['f'] == 'index') {
        $url = 'admin.php?c='.$nav['c'];
    }
    return $url;
}
//设置高亮li
function getActive($navc) {
    $c = strtolower(CONTROLLER_NAME);
    if(strtolower($navc) == $c) {
        return 'class="active"';
    }
    return '';
}

function showKind($status, $data) {
    header("Content-type: application/json;charset=utf-8");
    if($status == 0) {
        exit(json_encode(array('error'=>0, 'url'=>$data)));
    }
    exit(json_encode(array('error'=>1, 'message'=>'上传失败')));
}

function getLoginUsername() {
    return $_SESSION['adminuser']['username'] ? $_SESSION['adminuser']['username'] : null;
}

function getCatName($navs, $id) {
    foreach ($navs as $nav) {
        $navList[$nav['cat_id']] = $nav['name'];
    }
    return isset($navList[$id]) ? $navList[$id] : '';
}

function getBizName($navs, $id) {
    foreach ($navs as $nav) {
        $navList[$nav['biz_id']] = $nav['name'];
    }
    return isset($navList[$id]) ? $navList[$id] : '';
}

//显示略缩图
function isThumb($thumb) {
    if($thumb) {
        return '<span style="color:red">有</span>';
    }
    return '<span style="color:red">无</span>';
}

