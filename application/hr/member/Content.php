<?php
namespace app\hr\member;

use app\common\controller\member\C;
use app\hr\model\Content AS _Content;
use app\hr\traits\Content AS TraitsContent;

class Content extends C
{	
    use TraitsContent;
	public function index($fid=0,$mid=0)
	{
	        if(!$mid && !$fid){
	            //没有指定栏目或模型的话， 就显示默认模型的内容
	            $mid = $this->m_model->getId();
	        }elseif($fid){
	            $mid = $this->model->getMidByFid($fid);
	        }
	        
	        $this->mid = $mid;
	    // $listdb = $this->model->getListByUid($this->user['uid']);
	    $map['uid'] = $this->user['uid'];
	    $listdb = $this->model->getListByMid($mid,$map); //按模型获取数据
	    $pages = $listdb->render();

	    $this->assign('listdb',$listdb);
	    $this->assign('pages',$pages);

	    return $this->fetch();
	}

	/**
	* 简历的增加、修改或查看，根据模型判断，已操作则进入修改，没则进入添加
	* @param number $mid
	* @param number $type 0增加更新，1查看
	*/
	public function checkVita($mid=2,$type=0){
		$vitadb=$this->model->getVitaInfo($mid); //获取用户简历内容
		if($vitadb){
			if($type==1){
				$this_dir = config('system_dirname');
				if(in_wap()){
					$to_url = urls("index/$this_dir/content/show",['id'=>$vitadb['id']]);
				}else{
					$to_url = urls("index/$this_dir/content/show",['id'=>$vitadb['id'],'from'=>'member']);
				}
				
				$this->redirect($to_url);
			    // $this->assign('vitadb',$vitadb);
			    // return $this->fetch('showvita');
			}else if($type==2){
				$this_dir = config('system_dirname');
				$to_url = urls("index/$this_dir/content/show",['id'=>$vitadb['id']]);
				$this->redirect($to_url);
			}else{
				$this->redirect('edit', ['id' => $vitadb['id']]);
			}
		}else{
			$this->redirect('add', ['mid' => $mid]);
		}
	}
	public function delapply($ids){
		$this_uid = $this->user['uid'];
		if(!$ids){
			$this->error('参数有误');
		}
		if(!$this_uid){
			$this->error('登陆后才可进行相关操作！');
		}
		$applydb = $this->model->getOneApply($ids);
		if($applydb['uid']!=$this_uid && $applydb['cuid']!=$this_uid){
			$this->error('你没权限删除该记录！');
		}
		if($this->model->delApplyJob($ids)){
			 $this->success('删除成功！');
		}else{
			$this->error('操作失败！');
		}
	}

	/**
	* 收到的简历||应聘的职位
	* @param number $id 职位ID
	* @param number $type 0增加更新，1查看
	*/
	public function jobvita($mid=1,$id=0){
		$login_uid=$this->user['uid'];
		if(!login_uid){
			$this->error('该页面需登录后才可进入！');
		}
		if($mid==1){
			$map = ['A.uid'=>$login_uid];
			$listdb = $this->model->getJobVita($mid,$map);
			$template = 'applyjob';
		}else if($mid==2){
			if($id){
				$map['A.aid'] = $id;
			}
			$map['A.cuid'] = $login_uid;
			$listdb = $this->model->getJobVita($mid,$map);
			$template = 'receive_vita';
		}else{
			$this->error('默认模型ID有误');
		}
	// print_r($listdb);	

	    // $listdb = $this->model->getListByMid($mid,$map); //按模型获取数据
	    $pages = $listdb->render();

	    $this->assign('listdb',$listdb);
	    $this->assign('pages',$pages);

	    return $this->fetch($template);
	}

    
    /**
     * 发布页，可以根据栏目ID或者模型ID，但不能为空，不然不知道调用什么字段
     * @param number $fid
     * @param number $mid
     * @return mixed|string
     */
    public function add($fid=0,$mid=0)
    {
        $data = $this->request->post();
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
                            [ 'select','fid','所属栏目','',$sort_array,$fid],
                    ],
                    $this->getEasyFormItems()
                    );
        }
        
        //联动字段
       $this->tab_ext['trigger'] = $this->getEasyFieldTrigger();
       
       $this->tab_ext['area'] = config('use_area'); //是否启用地区
       
        //分组显示处理
        $this->tab_ext['group'] = $this->get_group_form($this->form_items);
        if( $this->tab_ext['group'] ){
            unset($this->form_items);
        }
        
        $this->tab_ext['page_title'] = '发布 '.$this->m_model->getNameById($this->mid);        
        return $this->addContent();
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
	
}
