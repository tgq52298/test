<?php
namespace app\vote\index\wxapp;

use app\common\controller\index\wxapp\Post AS _Post; 
use app\vote\traits\Content AS TraitsContent;

//小程序 发表内容处理
class Post extends _Post
{
   use TraitsContent;
    /**
     * 上传文件,图片或视频
     */
    public function postFile(){
        return parent::postFile();
    }
    
    
    
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
     * 新发表报名选项
     * @return \think\response\Json
     */
    public function add($mid=1){
        $data = input();
        // print_r($data);
   
        $data && $check_msg= $this->post_check($data);

        if($check_msg){
              return $this->err_js($check_msg);
        }
        return parent::add($mid);
    }
	
    /**
     * 采集公众号的文章
     * @param number $mid
     * @return void|\think\response\Json|\think\response\Json
     */
	public function copynews($mid=1){
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if(!$data['fid']){
                return $this->err_js('你没有选择栏目!');
            }
            if(!strstr($data['mpurl'],'mp.weixin.qq.com')&&!strstr($data['mpurl'],'toutiao.com')&&!strstr($data['mpurl'],request()->domain())){
                return $this->err_js('请粘贴公众号网址！');
            }
            $array = \app\common\util\CopyMp::get_weixin_article($data['mpurl'],$data['fid']);
            if($array['title']==''||$array['content']==''){
                return $this->err_js('采集失败');
            }
            $this->request->post($array);
            return parent::add($mid);
        }
    }
    
    /**
     * 获取栏目数据
     * @return \think\response\Json
     */
    public function get_sort(){
        return parent::get_sort();
    }
    
    /**
     * 主题点赞
     * @param number $id 主题ID
     * @return \think\response\Json
     */
    public function agree($id=0){
        return parent::agree($id);
    }
    




}













