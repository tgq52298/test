<?php
namespace plugins\guestbook\index\wxapp;

use app\common\controller\index\wxapp\Post AS _Post;

//小程序 发表内容处理
class Post extends _Post
{
    /**
     * 删除主题
     * @param number $id 主题ID
     * @return \think\response\Json
     */
    public function delete($id=0){
        return parent::delete($id);
    }
    
    /**
     * 修改主题
     * @param number $id
     * @return \think\response\Json
     */
    public function edit($id=0){
        return parent::edit($id);
    }
    
    /**
     * 新发表主题
     * @return \think\response\Json
     */
    public function add($mid=1){
        $data = input();
        if(!$data['content']){
            return $this->err_js('内容不能为空!');
        }
//         elseif(!input('post.content')){
//             return $this->err_js('内容必须是POST数据!');
//         }
        return parent::add($mid);
    }
    
    /**
     * 保存数据到数据库
     * {@inheritDoc}
     * @see \app\common\controller\index\wxapp\Post::savaNewData()
     */
//     protected function savaNewData($mid=0,$data=[]){
//         $result = parent::savaNewData($mid,$data);
//         if ($result) {
//             //hook_listen('bbs_add_end',$id,$data);
//         }
//         return $result;
//     }


   
    
}













