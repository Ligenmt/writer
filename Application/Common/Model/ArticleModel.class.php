<?php
namespace Common\Model;
use Think\Model;

class ArticleModel extends Model {

    private $_db = '';  //表名
    public function __construct() {
        $this->_db = M('article');
    }

//    public function select($data, $limit = 10) {
//        if($data['title']) {
//            $data['title'] = array('like', '%'.$data['title'].'%');
//        }
//        $this->_db->where($data)->order('listorder desc, article_id desc');
//        if($limit) {
//            $this->_db->limit($limit);
//        }
//        $list = $this->_db->select();
//        return $list;
//    }

    public function insert($data) {
        if(!$data || !is_array($data)) {
            return -1;
        }
        $data['create_time'] = time();
        $data['update_time'] = time();
        $data['username'] = getLoginUsername();
        return $this->_db->add($data);
    }

    public function getArticles($data, $page, $pageSize) {
        $conditions = $data;
        if(isset($data['title']) && $data['title']) {
            $conditions['title'] = array('like'. '%'.$data['title'].'%');  //模糊搜索
        }
        if(isset($data['cat_id']) && $data['cat_id']) {
            $conditions['cat_id'] = intval($data['cat_id']);
        }
        $offset = ($page - 1 ) * $pageSize;
        $list = $this->_db->where($conditions)
            ->order('listorder desc , article_id desc')
            ->limit($offset, $pageSize)
            ->select();
        return $list;
    }

    public function getArticleCount($data) {
        $conditions = $data;
        if(isset($data['title']) && $data['title']) {
            $conditions['title'] = array('like'. '%'.$data['title'].'%');  //模糊搜索
        }
        if(isset($data['cat_id']) && $data['cat_id']) {
            $conditions['cat_id'] = intval($data['cat_id']);
        }
        return $this->_db->where($conditions)->count();
    }

    public function findById($id) {
        return $this->_db->where('article_id='.$id)->find();
    }

    public function findByIdIn($ids) {
        if (!is_array($ids)) {
            throw_exception("参数非法");
        }
        $data = array(
            'article_id' =>array('in', implode(',', $ids))
        );
        return $this->_db->where($data)->select();
    }

    public function findByBizId($id) {
        $data = array(
            'biz_id' => $id
        );
        return $this->_db->where($data)->order('create_time desc')->limit(5)->select();
    }

    public function updateById($articleId, $data) {

        if(!$articleId || !is_numeric($articleId)) {
            throw_exception('ID不合法');
        }
        if(!$data || !is_array($data)) {
            throw_exception('data不合法');
        }
        $data['update_time'] = time();
        return $this->_db->where('article_id='.$articleId)->save($data);
    }

    /**
     * 最新文章
     */
    public function getLatest($data, $limit) {
        $list = $this->_db->where($data)->order('create_time desc')->limit($limit)->select();
        return $list;
    }

    /**
     * 更新阅读数
     */
    public function updateCount($id, $count) {
        $data = array(
            'article_id'=> $id,
            'count' => $count
        );
        return $this->_db->where('article_id='.$id)->save($data);
    }

    public function delete($data) {
        $this->_db->where($data)->delete();
    }
}