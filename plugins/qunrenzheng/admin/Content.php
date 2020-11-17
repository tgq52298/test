<?php
namespace plugins\qunrenzheng\admin;

use app\common\controller\admin\C;
use plugins\qunrenzheng\traits\Content AS TraitsContent;


class Content extends C
{
    use TraitsContent;
    protected $validate;
    
    public function add($fid=0,$mid=0){
        return parent::add($fid,$mid);
    }
    public function edit($id){
        return parent::edit($id);
    }
    
    public  function postnew($mid = 0){
        if (config('post_need_sort')==true) {
            return self::chooseSort($mid);
        }else{
            return self::chooseModule();
        }
    }
    
    /**
     * 认证及取消认证操作
     * 
     * 
     */
    public function rzact($id=0){
    	if(empty($id)){
    		$this->error('参数有误');
    	}
    	//QUN数据
    	$qun_info = $this->model->getQqunInfoByid($id);
    	if(!$qun_info){
    		$this->error('查询不到该'.QUN.'数据，无法进行相关操作！');
    	}
    	
    	//已认证的则进行取消认证操作
    	if($qun_info['status']>1){
    		$data = ['status'=>1];
    		$data2 = ['status'=>0];
    		$tip = '已取消认证';
    	}else{
    		$data = ['status'=>2];
    		$data2 = ['status'=>1];
    		$tip = '已通过认证';
    	}
    	if($this->model->updateQunRz($id,$data,$data2)){
    		$this->success($tip,'index');
    	}else{
    		$this->error('操作失败，可尝试刷新页面后再进行操作！');
    	}

    }
    
    
    
    /**
     * 显示所有模型的内容
     * {@inheritDoc}
     * @see \app\common\controller\admin\C::listall()
     */
    public function listall(){
        //列表选项
        $this->list_items =  [
        		['qun_id', '认证'.QUN, 'callback',function($v){
        			$qun_info = $this->model->getQqunInfoByid($v);
        			$qun_url = iurl('qun/content/show',['id'=>$qun_info['id']]);
        				return "<a href='{$qun_url}' target='_blank'>{$qun_info['title']}</a>";
        			}
        		],
        		['rz_rmb', '费用', 'text'],
        		['pay_status', '支付状态', 'callback',function($v){if($v)return '已支付';}],
        		['qun_id', '认证', 'callback',function($qun_id){
        			$qun_info = $this->model->getQqunInfoByid($qun_id);
        			if($qun_info['status']>1){
        				return '已认证';
        			}else{
        				return '待认证';
        			}
        		}],
        		//['status', '认证状态', 'select',['未认证','认证','已推荐']],
        		['linkman', '联系人', 'text'],
        		['telphone', '联系电话', 'text'],
                ['uid', '提交者', 'username'],
                ['create_time', '提交日期', 'datetime'],
        ];
        
        $this->tab_ext['page_title'] = '所有'.QUN.'认证管理';
        $this->tab_ext['nav'] = [ $this->nav() , 0];    //导航菜单
        
        //右边菜单
        $this->tab_ext['right_button'] = [
                ['type'=>'delete'],
                ['type'=>'edit'],
                [
                        'title'=>'查看',
                        'icon'=>'fa fa-wpforms',
                        'url'=>iurl('content/show',['id'=>'__id__']),
                        'target'=>'_blank',
                ],
        		[
        				'title'=>'认证及取消认证操作',
        				'icon'=>'fa fa-fw fa-compress',
        				'url'=>purl('rzact',['id'=>'__qun_id__']),
        		],
        ];
        //顶部菜单
        $this->tab_ext['top_button'] = [
                [
                        'type'       => 'delete',
                ],
        ];
        
        $data = $this->model->getAll();
        return $this->getAdminTable($data);
    }
    
    /**
     * 按模型显示内容列表
     * {@inheritDoc}
     * @see \app\common\controller\admin\C::index()
     */
    public function index($fid=0,$mid=0,$type=''){
        
        if($type=='listall'){   //放在这里的话,就省去再单独的设置后台权限
            return $this->listall();
        }elseif($type=='excel'){
            return $this->excel($mid,input()['ids']);
        }
        
        if(!$mid && !$fid){
            return $this->listall();
        }elseif($fid){
            $mid = $this->model->getMidByFid($fid);
        }
        
        $this->mid =$mid;   //指定模型内容
        
        $this->tab_ext['page_title'] = model_config($mid)['title'] . ' 内容管理';
        
        $this->tab_ext['nav'] = [ $this->nav() , $mid];     //导航菜单
        
        //列表显示哪些字段
        $this->list_items = array_merge(
                [
                        //['fid','所属分类','select2',get_sort(0,'name','all')],
                ],
                $this->getEasyIndexItems(),  //列表要显示的自定义字段
                [
                		['qun_id', '认证'.QUN, 'callback',function($v){return $this->model->getQqunInfoByid($v)['title'];}],
                		['rz_rmb', '费用', 'text'],
                		['pay_status', '支付状态', 'callback',function($v){if($v)return '已支付';}],
                		['qun_id', '认证', 'callback',function($qun_id){
                			$qun_info = $this->model->getQqunInfoByid($qun_id);
                			if($qun_info['status']>1){
                				return '已认证';
                			}else{
                				return '待认证';
                			}
                		}],
                		//['status', '认证状态', 'select',['未认证','认证','已推荐']],
                		['linkman', '联系人', 'text'],
                		['telphone', '联系电话', 'text'],
                		['uid', '提交者', 'username'],
                		['create_time', '提交日期', 'datetime'],
                 ]
                );
        
        //顶部菜单
        $this->tab_ext['top_button'] = [
                [
                        'type'       => 'delete',
                ],
                /* [
                        'title'       => '导出Excel表格',
                        'icon'        => 'fa fa-indent',
                        'class'       => 'btn btn-primary ajax-post confirm',
                        'target-form' => 'ids',
                        'href'        => auto_url('index',['mid'=>$mid,'type'=>'excel'])
                ], */
        ];
        
        //右边菜单
        $this->tab_ext['right_button'] = [
                ['type'=>'delete'],
                ['type'=>'edit'],
                [
                        'title'=>'查看',
                        'icon'=>'fa fa-wpforms',
                        'url'=>iurl('content/show',['id'=>'__id__']),
                        'target'=>'_blank',
                ],
        		[
        				'title'=>'认证及取消认证操作',
        				'icon'=>'fa fa-fw fa-compress',
        				'url'=>purl('rzact',['id'=>'__qun_id__']),
        		],
        ];
        
        $data = self::getListData($fid ? ['fid'=>$fid] : ['mid'=>$mid]);
        return $this->getAdminTable($data);
    }
    
}

