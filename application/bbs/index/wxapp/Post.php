<?php
namespace app\bbs\index\wxapp;

use app\common\controller\index\wxapp\Post AS _Post; 
use app\bbs\model\Member;
use app\bbs\model\Reply;
use app\common\util\Weixin;
use app\bbs\traits\Content AS TraitsContent;

//小程序 发表内容处理
class Post extends _Post
{
    use TraitsContent;
    /**
     * 打赏用户
     * @param number $id 主题ID
     * @param number $rid 回复ID
     * @param number $money 打赏金额
     * @return void|\think\response\Json
     */
    public function reward($id=0,$rid=0,$money=0){
        if (!$this->user) {
            return $this->err_js('请先登录');
        }elseif($this->user['rmb']<$money){
            return $this->err_js('你的可用余额不足,请先充值',['money'=>$this->user['rmb']],2);
        }elseif ($money<0.3){
            return $this->err_js('打赏金额不能小于0.3元!!');
        }
        $data = [
                'uid'=>$this->user['uid'],
                'aid'=>$id,
                'rid'=>$rid,
                'create_time'=>time(),
                'money'=>$money,
        ];
        $result = Member::reward($data);
        if ($result) {
            $res = $this->act_reward($id,$rid,$money);
        }
        
        $this->sendmsg($id,$rid,$money,$result);
        hook_listen( 'content_give_rmb' , $id , ['rid'=>$rid,'pay_weixin'=>$res,'money'=>$money,'module'=>$this->request->module()] );      //监听打赏
        
        if($res===true){            
            return $this->ok_js(['havepay'=>1],'打赏成功,赏金已成功转到用户微信钱包');
        }else{
            return $this->ok_js(['havepay'=>0],'打赏成功,赏金已转到用户余额');
        }
    }
    
    protected function sendmsg($id=0,$rid=0,$money=0,$type=false){
        $info = $this->model->getInfoByid($id);
        if($rid>0){            
            $content = "你参与的主题《{$info[title]}》受到《".$this->user['username']."》的打赏,<a href='".get_url(url('content/show',['id'=>$id]))."'>点击查查看详情</a>";
            $Rinfo = Reply::get($rid);
            send_wx_msg($Rinfo['uid'], $content);
        }else{           
            $content = "你发表的主题《{$info[title]}》受到《".$this->user['username']."》的打赏,<a href='".get_url(url('content/show',['id'=>$id]))."'>点击查查看详情</a>";
            send_wx_msg($info['uid'], $content);
        }      
    }
    
    /**
     * 对用户的一些打赏操作
     * @param number $id
     * @param number $rid
     * @param number $money
     * @return void|boolean
     */
    protected function act_reward($id=0,$rid=0,$money=0){
        if($rid){
            $info = Reply::get($rid);            
        }else{
            $info = $this->model->getInfoByid($id , false);
        }
        $user = get_user($info['uid']);
        if(empty($user)){
            return ;
        }
        add_rmb($user['uid'], $money, 0,'被 '.$this->user['username'].' 打赏');
        if($user['weixin_api'] && $money>=0.3 && $this->webdb['reward_gave_wx']){
            $array = [
                    'money'=>$money,
                    'title'=>'优秀内容被 '.$this->user['username'].' 打赏',
                    'id'=>$user['weixin_api'],
            ];
            $res = Weixin::gave_moeny($array);
            if($res===true){
                add_rmb($user['uid'],-$money,0,'被打赏提现');
                return true;
            }
        }
    }
    
   
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
     * 新发表主题
     * @return \think\response\Json
     */
    public function add($mid=1){
        $mid = intval($mid);
        $data = input();
//         if(!$data['fid']){
//             return $this->err_js('你没有选择栏目!');
//         }elseif(!get_sort($data['fid'],'config')){
//             return $this->err_js('栏目不存在!');
//         }
        if(!$data['content']){
            return $this->err_js('内容不能为空!');
        }elseif(!input('post.content')){
            return $this->err_js('内容必须是POST数据!');
        }
        $mid || $mid = 1;
        if (in_wap()) { //判断来自哪个手机
            if (!table_field('bbs_content'.$mid,'phone_type')) {
                query("ALTER TABLE  `qb_bbs_content{$mid}` ADD  `phone_type` VARCHAR( 50 ) NOT NULL COMMENT  '发表来自什么手机'");
            }
            $this->request->post(['phone_type'=>fun('client@phone_type')]);
        }
        return parent::add($mid);
    }
    
    /**
     * 保存数据到数据库
     * {@inheritDoc}
     * @see \app\common\controller\index\wxapp\Post::savaNewData()
     */
    protected function savaNewData($mid=0,$data=[]){
        $result = parent::savaNewData($mid,$data);
        if ($result) {
            hook_listen('bbs_add_end',$id,$data);
        }
        return $result;
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
    
    
    
    /**
     * 采集公众号的文章
     * @param number $mid
     * @return void|\think\response\Json|\think\response\Json
     */
    public function copynews($mid=1){
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if(!$data['fid']){
               // return $this->err_js('你没有选择栏目!');
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
   
    
}













