<?php
namespace plugins\qunrenzheng\member;

use app\common\controller\member\C;
//use plugins\qunrenzheng\traits\Content AS TraitsContent;

class Content extends C
{
   // use TraitsContent;
    
    /**
     * 发布信息
     * {@inheritDoc}
     * @see \app\common\controller\member\C::add()
     */
    public function add($mid=0){
    	$data = $this->request->post();
    	if($data)$this->check_rz($data); //新增数据的检测过滤
    	$this->assign('rz_rmb',$this->webdb['rz_rmb']);
        return parent::add(0,$mid);
    }
    
    /**
     * 修改信息
     * {@inheritDoc}
     * @see \app\common\controller\member\C::edit()
     */
    public function edit($id){
    	$data = $this->request->post();
    	$info = $this->getInfoData($id);
    	if(empty($info)){
    		$this->error('内容不存在!');
    	}
    	if($info['status']>0){
    		$this->error('通过审核后的信息禁止进行修改');
    	}
    	if($data&&$data['qun_id']!=$info['qun_id'])$this->error('认证的'.QUN.'不能更改，如是新'.QUN.'需认证请重新填写申请！');
    	$this->validate = '';
    	return parent::edit($id);
    }

    /**
     * 新增数据的检测过滤
     * @param array 提交的数据
     */
    protected function check_rz($data=[]){
    	if(empty($data)){
    		return false;
    	}
    	$this->validate = '';//清空标题验证
    	if(empty($data['qun_id'])){
    		$this->error('请选择需要认证的'.QUN);
    	}
    	$rzinfo_db = $this->model->getContentByQunid($data['qun_id']);//检测提交的圈子是否已经提交过申请
    	if($rzinfo_db){
    		$edit_url = purl('edit',['id'=>$rzinfo_db['id']]);
    		$this->error('该'.QUN."已经提交过申请信息，如需修改相关资料可进入<a href='{$edit_url}'>【我提交的信息】</a>进行修改！");
    	}
    	$rz_rmb = $this->webdb['rz_rmb'] ? $this->webdb['rz_rmb'] : 0; //认证金额
    	
    	if($rz_rmb>0&&$this->user['rmb']<$rz_rmb){
    		$this->error('申请认证需支付'.$rz_rmb.'元认证费用，你的账号余额不足，请先充值再进行申请操作！');
    	}
    }
    
    
    /**
     * 同时适用于前台与后台 新增加后做个性拓展
     * @param number $id 内容ID
     * @param number $data 内容数据
     */
    protected function end_add($id=0,$data=[]){
    	//认证费用处理
    	$rz_rmb = $this->webdb['rz_rmb'] ? $this->webdb['rz_rmb'] : 0;
    	if($rz_rmb>0){
    		if($this->user['rmb']<$rz_rmb){
    			//余额不足则直接删除申请信息
    			if($this->model->deleteData(id)){
    				$this->error('账号余额不足，申请信息失败，请充值后再进行申请操作！');
    			}
    		}else{
    			$qun_info = $this->model->getQqunInfoByid($data['qun_id']); 
    			add_rmb($this->user['uid'],-$rz_rmb,0,"申请".$qun_info['title'].QUN."认证支付"); //人民币日志
    			$map['rz_rmb'] = $rz_rmb;
    			$map['pay_status'] =1;
    			
    		}
    	}
    	//是否自动通过认证处理
    	if($this->webdb['automatic_yz']){
    		$map['status'] = 1;
    	}else{
    		$map['status'] = 0;
    	}
    	$this->model->updates($id,$map); //更新认证信息

    	parent::end_add($id,$data);

    }
    
    
    /**
     * 删除内容
     * @param unknown $ids
     */
    public function delete($ids=null)
    {
    	if(empty($ids)){
    		$this->error('ID有误');
    	}
    	$ids = is_array($ids) ? $ids : [$ids];
    	$num = 0;
    	foreach ($ids AS $id) {
    		$info = $this->getInfoData($id);
    		if($info['status']>0){
    			$this->error('通过审核后的信息禁止删除');
    		}
    		//接口
    		hook_listen('cms_delete_begin',$id);
    		if (($result=$this->delete_check($id,$info))!==true) {
    			$this->error($result);
    		}
    		
    		$this->deleteOne($id,$info['mid']) && $num++;
    		
    	}
    	if( $num>0 ){
    		$this->success("成功删除 {$num} 条记录", auto_url('index',['mid'=>$this->mid]));
    	}else{
    		$this->error('删除失败');
    	}
    }
    

    
    /**
     * 信息列表
     * {@inheritDoc}
     * @see \app\common\controller\member\C::index()
     */
    public function index($mid=0){
    	if(!$mid){
    		//没有指定栏目或模型的话， 就显示默认模型的内容
    		//$mid = $this->m_model->getId();
    		$mid = model_config('default_id');
    	}
    	
    	$this->mid = $mid;
    	$map = ['mid'=>$mid];
    	$map['uid'] = $this->user['uid'];

    	$f_array = $this->getEasyIndexItems();
    	if(empty($this->list_items)){
    		$this->list_items = array_merge(
    				$f_array,
    				[
    						
    						['qun_id', '认证'.QUN, 'callback',function($v){return $this->model->getQqunInfoByid($v)['title'];}],
    						['rz_rmb', '费用', 'text'],
    						['pay_status', '支付状态', 'callback',function($v){if($v)return '已支付';}],
    						['create_time', '申请时间', 'datetime'],
    						['qun_id', '认证', 'callback',function($qun_id){
    							$qun_info = $this->model->getQqunInfoByid($qun_id);
    							if($qun_info['status']>1){
    								return '已认证';
    							}else{
    								return '待认证';
    							}
    						}],
    						['telphone', '联系电话', 'text'],
    						['id', '修改', 'callback',function($id,$rs){
    							if($rs['status']==0){
    								$edit_url = purl('edit',['id'=>$id]);
    								return "<a href=\"{$edit_url}\" title='修改'><i class='fa fa-pencil'></i> </a>";
    							}
    						}],
    						['id', '删除', 'callback',function($id,$rs){
    							if($rs['status']==0){
    								$del_url = purl('delete',['ids'=>$id]);
    								return "<a href='{$del_url}' title='删除' class='_dels' onclick='return confirm(\"你确实要删除吗?不可恢复!\")'><i class='fa fa-times'></i> </a>";
    							}	
    						}]
    				]
    				);
    	}
    	
    	$this->tab_ext['right_button'] = [
    			//['type'=>'delete'],
    			//['type'=>'edit'],
    			[
    					'url'=>iurl('show','id=__id__'),
    					'icon'=>'glyphicon glyphicon-eye-open',
    					'title'=>'详情',
    					//'target'=>'_blank',
    			],
    	];
    	$this->tab_ext['page_title'] || $this->tab_ext['page_title'] = M('name').' 我提交的申请';
    	$this->tab_ext['top_button'] = $this->page_top_botton();
    	
    	$this->assign('field_db',$f_array);
    	$this->assign('model_list',$this->m_model->getTitleList());
    	//$this->assign('fid',$fid);
    	$data_list = $this->getListData($map,'',0,[],false);    //获取列表数据 false不转义,只要原始数据
    	return $this->getMemberTable($data_list);
    }
	
}
