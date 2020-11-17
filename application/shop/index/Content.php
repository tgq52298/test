<?php
namespace app\shop\index;

use app\common\controller\index\C;
use app\shop\model\Fx AS FxModel;


//列表页与内容页
class Content extends C
{	
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
	public function show($id=0){
	    if ($this->user) { //分销链接
	        $share['link'] = urls('content/show',['id'=>$id]).'?p_uid='.$this->user['uid'].'&p_id='.$id;
	        $this->assign('share',$share);
	    }	    
	    return parent::show($id);
	}
	
	/**
	 * 重写父方法,加东西
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::view_check()
	 */
	protected function view_check(&$info=[]){
	    $this->set_fx($info);
	    parent::view_check($info);
	}
	
	
	/**
	 * 分销做记录
	 * 分享不是终身制,最后那次分享才有效
	 * @param array $info
	 */
	protected function set_fx($info=[]){
	    $p_id = get_cookie('p_id');        //分享的商品ID 如果多个频道同时用的话,id会有重复的存在,没做处理判断
	    $p_uid = get_cookie('p_uid');      //分享者的UID
	    if ($this->user['uid'] && $p_id==$info['id'] && $p_uid!=$this->user['uid']) {
	        set_cookie('p_id',null);
	        $data = [
	            'aid'=>$p_id,
	            'uid'=>$this->user['uid'],
	            'introducer_1'=>$p_uid,
	            'ifbuy'=>0,
	        ];
	        $result = FxModel::get($data);
	        if (empty($result)){
	            FxModel::create($data);    //最后推荐者入库作记录
	        }else{
	            FxModel::where('id',$result['id'])->update(['create_time'=>time()]);   //更新最后分享时间,方便后面做奖励处理
	        }
	    }
	}
	
}
