<?php
namespace app\zhidao\index\wxapp;

use app\common\controller\index\wxapp\Post AS _Post; 
use app\zhidao\model\Member;
use app\zhidao\model\Reply;
use app\common\util\Weixin;
use app\zhidao\model\Content;
use app\zhidao\traits\Content AS TraitsContent;

//小程序 发表内容处理
class Post extends _Post
{

    use TraitsContent;

    /**
     * 打赏用户
     * @param number $id 问题ID
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
        
        if($res===true){
            return $this->ok_js(['havepay'=>1],'打赏成功,赏金已成功转到用户微信钱包');
        }else{
            return $this->ok_js(['havepay'=>0],'打赏成功,赏金已转到用户余额');
        }
    }
    // 采纳最佳回答
    public function adoption_response($id=0,$rid=0){
        $info = $this->model->getInfoByid($id);
        if($info[best_rid]>0){
             return $this->err_js('该问题之前已采纳过最佳答案，再次采纳操作无效',['tip'=>"已采纳的回答ID为:{$info[best_rid]}"],1);
        }
        if($rid>0){
            $Rinfo = Reply::get($rid);
            if($info[money]>0){
                $msg = "你回答的《{$info[title]}》问题答案被提问者采纳，获得{$info[money]}{$this->webdb['MoneyDW']}{$this->webdb['MoneyName']}";
                add_jifen($Rinfo['uid'],$info[money]," 你回答的《{$info[title]}》问题答案被提问者采纳");
                send_wx_msg($Rinfo['uid'], $msg); //微信消息提醒
            }
            $editdb=array('id'=>$id,'best_rid'=>$rid);
            $this->model->editData(0,$editdb);

            $this_list=time()+365*24*3600;
            $replydata=array('id'=>$rid,'list'=>$this_list);
           $upinfo=Content::updateReplyList($rid,$replydata);

             return $this->ok_js();
        }
         return $this->err_js('未知错误',['rid'=>$rid],1);
    }

    protected function sendmsg($id=0,$rid=0,$money=0,$type=false){
        $info = $this->model->getInfoByid($id);
        if($rid>0){            
            $content = "你参与的问题《{$info[title]}》受到《".$this->user['username']."》的打赏,<a href='".get_url(url('content/show',['id'=>$id]))."'>点击查查看详情</a>";
            $Rinfo = Reply::get($rid);
            send_wx_msg($Rinfo['uid'], $content);
        }else{           
            $content = "你发表的问题《{$info[title]}》受到《".$this->user['username']."》的打赏,<a href='".get_url(url('content/show',['id'=>$id]))."'>点击查查看详情</a>";
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
        if($user['weixin_api'] && $money>=0.3){
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
     * 删除问题
     * @param number $id 问题ID
     * @return \think\response\Json
     */
    public function delete($id=0){
        return parent::delete($id);
    }
    
    /**
     * 修改问题
     * @param number $id
     * @return \think\response\Json
     */
    public function edit($id=0){
        //修改数据检测
        $check_edit= $this->check_edit($id,input());
        if($check_edit){
            // return $check_edit;
             return $this->err_js($check_edit);
        }
/*          $info = $this->getInfoData($id);
          if(input()['money']>$info['money']){
            $disparity_money=input()['money']-$info['money'];
            if($disparity_money>$this->user['money']){
                return $this->err_js("你的{$this->webdb['MoneyName']}不足以支付填写悬赏的数值，请重新操作!");
            }
            add_jifen($this->user['uid'],-$disparity_money," 修改《{$info[title]}》问题,增加悬赏{$webdb[MoneyName]}");
          }*/
        return parent::edit($id);
    }
    
    /**
     * 新发表问题
     * @return \think\response\Json
     */
    public function add($mid=1){
        $data = input();

        if(!$data['fid']){
            return $this->err_js('你没有选择栏目!');
        }elseif(!get_sort($data['fid'],'config')){
            return $this->err_js('栏目不存在!');
        }elseif(!$data['content']){
            // return $this->err_js('内容不能为空!');
        }elseif(!input('post.content')){
            return $this->err_js('内容必须是POST数据!');
        }

        // if($data['money']){
        //     $data['money']=abs($data['money']);
        //     if($data['money']>$this->user['money']){
        //         return $this->err_js("你的{$this->webdb['MoneyName']}不足以支付填写悬赏的数值，请重新操作!");
        //     }
        //      add_jifen($this->user['uid'],-$data['money']," 发布《{$data[title]}》问题,悬赏{$webdb[MoneyName]}");

        // }

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
            hook_listen('zhidao_add_end',$id,$data);
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
     * 问题点赞
     * @param number $id 问题ID
     * @return \think\response\Json
     */
    public function agree($id=0){
        return parent::agree($id);
    }
   
    
}













