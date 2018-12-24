<?php
namespace Common\Model;
use Think\Model;

class ArticleContentModel extends Model {

    private $_db = '';  //表名
    public function __construct() {
        $this->_db = M('article_content');
    }

    public function insert($data) {
        if(!is_array($data)) {
            return -1;
        }
        $data['create_time'] = time();
        if ($data['content']) {
            //html标签也带进去
            $data['content'] = htmlspecialchars($data['content']);
        }
        return $this->_db->add($data);
    }

    public function findById($id) {
        $data = $this->_db->where('article_id='.$id)->find();
        return $data;
    }

    public function updateById($id, $data) {
        if(!$id) {
            throw_exception("ID不合法");
        }
        if(!$data) {
            throw_exception("data异常");
        }
        $data['content'] = htmlspecialchars($data['content']);
        $data['update_time'] = time();
        return $this->_db->where("article_id=".$id)->save($data);
    }

    public function delete($data) {
        $this->_db->where($data)->delete();
    }

}