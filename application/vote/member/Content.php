<?php
namespace app\vote\member;

use app\common\controller\member\C;
use app\vote\traits\Content AS TraitsContent;

class Content extends C
{	
    use TraitsContent;
	public function index($fid=0,$mid=0)
	{
	    $listdb = $this->model->getListByUid($this->user['uid']);
	    $pages = $listdb->render();
	    $this->assign('listdb',$listdb);
	    $this->assign('pages',$pages);
	    return $this->fetch();
	}
	
	/**
	 * 采集公众号的文章
	 * @param number $fid
	 * @return mixed|string
	 */
	public function copynews($fid=0){
	    $this->assign('fid',$fid);
	    return $this->fetch();
	}

    
	/**
	 * 新发表主题
	 * @param number $fid
	 * @param number $mid
	 * @return mixed|string
	 */
	public function add($fid=0,$mid=0){

		if (!$this->user) {
		    $this->error('请先登录!');
		}
		$data = $this->request->post();
		

		$data && $check_msg= $this->post_check($data);
		if($check_msg){
		      return $this->error($check_msg);
		}

		isset($data['fid']) && $fid = $data['fid'];
	        if(!$mid && !$fid){
	            $this->error('参数有误！');
	        }elseif($fid && !$mid){ //根据栏目选择发表内容
	            $mid = $this->model->getMidByFid($fid);
	        }        
	        $this->mid = $mid;

	        //接口
	        hook_listen('cms_add_begin',$data);
	        if (($result=$this->add_check($mid,$fid,$data))!==true) {
	           $this->error($result);
	        }
	        
	        // 保存数据
	        if ($this -> request -> isPost()) {
	            input('?get.ext_id') && $this->request->post(['ext_id'=>input('get.ext_id')]);
	            $data = $this->reform_data($data);//是否默认通过审核
	            $this->saveAdd($mid,$fid,$data);
	            
	        }
	        
	        //发表时可选择的栏目
	        $sort_array = $this->s_model->getTreeTitle(0,$mid);
	        //发布页要填写的字段
	        $this->form_items = $this->getEasyFormItems();     //发布表单里的自定义字段
	        //如果栏目存在才显示栏目选择项
	        if(count($sort_array)>1){
	            $this->form_items = array_merge(
	                    [
	                            [ 'select','fid','所属项目','',$sort_array,$fid],
	                    ],
	                    $this->getEasyFormItems()
	                    );
	        }
	        
	        //联动字段
	       $this->tab_ext['trigger'] = $this->getEasyFieldTrigger();
	       
	        //分组显示处理
	        $this->tab_ext['group'] = $this->get_group_form($this->form_items);
	        if( $this->tab_ext['group'] ){
	            unset($this->form_items);
	        }
	        
	        $this->tab_ext['page_title'] = '发布 '.$this->m_model->getNameById($this->mid);        
	        return $this->addContent();

		// return parent::add($fid,$mid);
	}

	/**
	 * 修改主题
	 * @param number $id
	 * @return \think\response\Json
	 */
	public function edit($id=0){
	    //修改数据检测
	   $data = $this->request->post();
	  $data && $check_msg= $this->post_check($data,1);
	    if($check_msg){
	        return $this->error($check_msg);
	    }

	        $info = $this->getInfoData($id);
	        if(empty($info)){
	            $this->error('内容不存在!');
	        }
	        
			//表单数据
		    $data = $this->request->post();

	        //接口
	        hook_listen('cms_edit_begin',$data);
	        if (($result=$this->edit_check($id,$info,$data))!==true) {
	            $this->error($result);
	        }
	        
	        $this->mid = $info['mid'];
	        
	        // 保存数据
	        if ($this -> request -> isPost()) {
	            $this->saveEdit($this->mid,$data);
	        }
	        
	        //发表时可选择的栏目
	        $sort_array = $this->s_model->getTreeTitle(0,$this->mid);
	        //发布页要填写的字段
	        $this->form_items = $this->getEasyFormItems();     //发布表单里的自定义字段
	        //如果栏目存在才显示栏目选择项
	        if(count($sort_array)>1){
	            $this->form_items = array_merge(
	                    [
	                            [ 'select','fid','所属项目','',$sort_array],
	                    ],
	                    $this->getEasyFormItems()
	                    );
	        }
	        
	        //联动字段
	        $this->tab_ext['trigger'] = $this->getEasyFieldTrigger();
	        
	        $this->tab_ext['page_title'] = $this->m_model->getNameById($this->mid);
	        
	        //分组显示
	        $this->tab_ext['group'] = $this->get_group_form($this->form_items);
	        if( $this->tab_ext['group'] ){
	            unset($this->form_items);
	        }
	        
	        //修改内容后，最好返回到模型列表页，因为有可能修改了栏目
	        return $this->editContent($info , '' ,'member');


	    // return parent::edit($id);
	}

}
