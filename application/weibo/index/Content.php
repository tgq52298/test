<?php
namespace app\weibo\index;

use app\common\controller\index\C; 
use app\weibo\model\Member AS QMember;

//内容页与列表页
class Content extends C
{
    //取消每次刷新都更新点击
    protected function updateView($id){
    }
    
    protected function get_user_group($id){
        $user = $this->user;
        if (empty($user)) {
            return ;
        }
        $map = [
                'aid'=>$id,
                'uid'=>$user['uid']
        ];
        $info = QMember::get($map);
        if(empty($info)){
            return ;
        }
        if(time()-$info['update_time']>60){
            $data['update_time'] = time();
            $data['id'] = $info['id'];
            QMember::update($data);
        }
        if($info['type']==0){
            return -1;
        }else{
            return $info['type'];
        }
    }
	
	/**
	 * 列表页
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::index()
	 */
	public function index($fid=0,$mid=0){
	    return parent::index($fid,$mid);
	}
	
	/**
	 * 内容详情页
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::show()
	 */
	public function show($id){
	    if ($id==0) {
	        if ($this->user['uid']) {
	            $id = $this->user['uid'];
	        }else{
	            return $this->error('你还没登录');
	        }
	    }
	    
	    if ( empty(fun('sns@weibo',$id)) ){
	        $this->success('当前用户还没有创建微博,点击下一步,进入他的会员主页',murl('member/user/index',['uid'=>$id]));
	    }
	    if($id == $this->user['uid']){
	        fun('sns@clear_msg',$this->user['uid']);    //把新消息清0
	    }
	    	    
	    $this->assign('gid', $this->get_user_group($id) );
	    return parent::show($id);
	}
	
	public function add($mid=1){
	    if(!$this->user){
	        return $this->error('你还没登录');
	    }
	    $this->assign('mid',$mid);
	    return $this->fetch('post');
	}
	
	public function my(){
	    if (empty($this->user)) {
	        $this->error('你还没登录!');
	    }
	    $this->assign('uid',$this->user['uid']);
	    return $this->fetch();
	}
	
}
