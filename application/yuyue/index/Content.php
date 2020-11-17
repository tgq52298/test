<?php
namespace app\yuyue\index;

use app\common\controller\index\C;
use app\yuyue\model\Fx AS FxModel;
use app\yuyue\model\Order AS OrderModel;
use app\yuyue\model\Member AS MemberModel;

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
	 * 内容页详情页
	 * {@inheritDoc}
	 * @param int $id 内容ID
	 * @param int $oid 订单ID,砍价模型会用到
	 * @param int $uid 参与竟拍的用户UID,竟拍会用到
	 */
	public function show($id=0,$oid=0,$uid=0){
	    if ( empty($this->user) && in_weixin() && config('webdb.weixin_type')==3  ) {  //在微信端,就强制自动登录!
	        weixin_login();
	    }
	    $this->haibao = 'content/share';
	    if ($oid) {
	        $oinfo = getArray(OrderModel::where('id',$oid)->find());
	        if (!$oinfo) {
	            $this->error('订单不存在');
	        }elseif($oinfo['shopid']!=$id){
	            $this->error('不是当前商品的订单');
	        }
	        $this->assign('oinfo',$oinfo);
	    }elseif($uid){	        
	        $total_num = MemberModel::where([
	            'aid'=>$id,
	            'order_id'=>$uid,
	            'type'=>4,
	        ])->count('id');
	        $this->assign('uid',$uid);
	        $this->assign('total_num',$total_num);
	    }	    
	    return parent::show($id);
	}
	
	protected function view_check(&$info=[]){
	    if ($info['mid']==2 && $this->user && empty(input('oid'))) {
	        $oid = OrderModel::where('uid',$this->user['uid'])->where('shopid',$info['id'])->order('id dsec')->value('id');
	        if ($oid){
	            $this->redirect('show',['id'=>$info['id'],'oid'=>$oid]);
	        }
	    }
	    $this->set_fx($info);
	    parent::view_check($info);	    
	}
	
	
	/**
	 * 分销做记录
	 * @param array $info
	 */
	protected function set_fx($info=[]){
	    $p_id = get_cookie('p_id');
	    $p_uid = get_cookie('p_uid');
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
	            FxModel::create($data);	            
	        }else{
	            FxModel::where('id',$result['id'])->update(['create_time'=>time()]);
	        }
	    }
	}
	
	/**
	 * 设置海报路径
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::view_check()
	 */
// 	protected function view_check($info=[]){
// 	    parent::view_check($info);
// 	    $this->set_haibao($info);
// 	}
	
	/**
	 * 设置海报
	 * @param array $info
	 */
// 	protected function set_haibao($info=[]){
// 	    $haibao = '';
// 	    if ($info['haibao'] && is_file(TEMPLATE_PATH.'haibao_style/'.$info['haibao'])) {
// 	        $haibao = TEMPLATE_PATH.'haibao_style/'.$info['haibao'];
// 	    }
// 	    if(empty($haibao)){
// 	        $array = $info['fid'] ? get_sort($info['fid'],'config') : [];
// 	        if($array['haibao']){
// 	            list($default_file) = explode(',', $array['haibao']);
// 	        }
// 	        if ($default_file && is_file(TEMPLATE_PATH.'haibao_style/'.$default_file)) {
// 	            $haibao = TEMPLATE_PATH.'haibao_style/'.$default_file;
// 	        }
// 	    }
// 	    if(empty($haibao)){
// 	        $array = model_config($info['mid']);
// 	        if($array['haibao']){
// 	            list($default_file) = explode(',', $array['haibao']);
// 	        }
// 	        if ($default_file && is_file(TEMPLATE_PATH.'haibao_style/'.$default_file)) {
// 	            $haibao = TEMPLATE_PATH.'haibao_style/'.$default_file;
// 	        }
// 	    }
// 	    if (empty($haibao)){
// 	        $haibao = 'content/share';
// 	    }else{
// 	        define('TPL_CACHE_PRE', basename(dirname($haibao)));    //要设置缓存的前缀,否则有缓存会不生效
// 	    }
// 	    $this->assign('haibao',$haibao);
// 	}
	
}
