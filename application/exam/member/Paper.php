<?php
namespace app\exam\member;


use app\exam\model\Category as CategoryModel;
use app\exam\model\Info as InfoModel;
use app\exam\model\Content as ContentModel;
use app\common\traits\AddEditList;
use app\common\controller\MemberBase;

//试卷

class Paper extends MemberBase
{
    use AddEditList;
	protected $validate = 'Category';
	protected $model;
	protected $m_model;
	protected $form_items;
	
	protected $list_items;
	protected $tab_ext;
	
	protected function _initialize()
	{
		parent::_initialize();
		preg_match_all('/([_a-z]+)/',get_called_class(),$array);
		$dirname = $array[0][1];
		$this->model = get_model_class($dirname,'category');
		//$this->s_model = get_model_class($dirname,'sort');
		//$this->m_model = get_model_class($dirname,'module');
		$this->set_config();
	}
	
	protected function set_config(){
		$this->tab_ext = ['page_title'=>'创建试卷',];
		$this->form_items = [
				['hidden', 'pid'],
				['text', 'name', '试卷名称'],
				[ 'select','grade','所属年级','',fun('exam@get_sort','grade')],
				[ 'select','kemu','所属科目','',fun('exam@get_sort','kemu')],
				[ 'select','step','所属章节','',fun('exam@get_sort','step')],
				//['select', 'pid', '归属上级分类','不选择，则为顶级分类',$this->model->getTreeTitle()],
		];
	}
	
	
    public function  index()
    {
    	$this->check_power();
        $listdb=CategoryModel::where(['uid'=>$this->user['uid']])->paginate(10);
         
        $pages = $listdb->render();
        $listdb=getArray($listdb)['data'];
        
        foreach($listdb AS $key=>$rs){
            $rs['number']=InfoModel::where(['cid'=>$rs['id']])->count();
            $rs['fenone']=round(100/ $rs['number'],2);
            $listdb1[]=$rs;
        }

        $this->assign('listdb',$listdb1);
        $this->assign('pages',$pages);
  
        return $this->fetch();
    }
    
    /**
     * 手工出试卷
     * @return mixed|string
     */
    public function add(){
    	$this->check_power();
    	
    	if($this->request->isPost()){
    		$data = $this -> request -> post();
    		$data = \app\common\field\Post::format_all_field($data,-3); //对一些特殊的字段进行处理,比如多选项,以数组的形式提交的
    		$this -> request -> post($data);
    		
    		$result = $this -> saveAddContent();//保存新增数据
    		$insert_id = $result->id; //新增试卷ID
    		if($insert_id){
    			
    			//如有提交题目则进行相关处理
    			if($data['issue_db']){
    				ksort($data['issue_db']);//题目排序，最先生成的表单排在前面
    				$insert_data = [];
    				foreach ($data['issue_db'] AS $v){
    					if($v['title'] && ($v['answer_a']||$v['answer_b']||$v['answer_c'])){
    						$insert_cid = ContentModel::addData(1,$v);//题目入库
    						if($insert_cid){
    							$insert_data[] = ['aid'=>$insert_cid,'cid'=>$insert_id];
    						}
    					}
    				}
    				if($insert_data){
    					InfoModel::create_info($insert_data); //试卷对应题目索引入库
    				}
    			}
    			
    			$this -> success('添加成功','index');
    		}else{
    			$this -> error('添加失败');
    		}
    		
    		
    		
    	}
    	
    	$form_field =  \app\common\field\Form::get_all_field(-3);
    	if ($form_field) {  //把用户自定义字段,追加到基础设置那里
    		$this->form_items = array_merge($this->form_items,$form_field);
    	}
    	
    	//联动字段,比如点击哪项就隐藏或者显示哪一项
    	$this->tab_ext['trigger'] = \app\common\field\Form::getTrigger($this->mid);
    	
    	return $this -> addContent();
    	
    }
    
    
    public function edit($id = null)
    {
    	if($this->request->isPost()){
    		$data = $this -> request -> post();
    		$data = \app\common\field\Post::format_all_field($data,-3); //对一些特殊的字段进行处理,比如多选项,以数组的形式提交的
    		
    		if ($this -> model -> update($data)) {
    			$this -> success('修改成功', 'index');
    		} else {
    			$this -> error('修改失败');
    		}
    	}
    	
    	if(empty($id)) $this->error('缺少id');
    	
    	if (empty($this->form_items)) {
    		$this->form_items = [
    				['text', 'name', '辅栏目名称'],
    				['select', 'pid', '归属上级分类','不选择，则为顶级分类',$this->model->getTreeTitle($id)],
    		];
    	}
    	
    	$form_field =  \app\common\field\Form::get_all_field(-3);
    	if ($form_field) {  //把用户自定义字段,追加到基础设置那里
    		$this->form_items = array_merge($this->form_items,$form_field);
    	}
    	
    	//联动字段,比如点击哪项就隐藏或者显示哪一项
    	$this->tab_ext['trigger'] = \app\common\field\Form::getTrigger($this->mid);
    	
    	$info = $this->getInfoData($id);
    	
    	return $this->editContent($info);
    }
    
    
    
    /**
     * 删除试卷
     * @return mixed|string
     */
    public function delete($ids=0,$aid=0){
    	if(!$ids){
    		$this->error('参数有误');
    	}
    	$check_category = $this->model->where('id','=',$ids)->find();

    	if($check_category['uid']!= $this->user['uid']){
    		$this->error('你没权删除该试卷!');
    	}
    	$map['cid'] = $ids;
    	$aid && $map['id'] = $aid;

    	$result = InfoModel::where($map)->delete();
    	if($aid){
    		if($result){
    			return true;
    		}else{
    			return false;
    		}
    	}else{
    		$result = $this->model->where('id','=',$ids)->delete();
    	}
    	
    	if($result){
    		$this->success('删除成功');
    	}else{
    		$this->error('删除失败');
    	}

    }
    
    
    
    /**
     * 随机批量出试卷
     * @return mixed|string
     */
    public function batchadd(){
    	$this->check_power();
    	if($this -> request -> isPost()){
    		$postdb = $this->request->post();
    		if(!$postdb['single_num']&&!$postdb['multiple_num']&&!$postdb['judge_num']){
    			$this->error('至少必须选择一种题型才可进行出卷！');
    		}
    		$postdb['name'] = $postdb['name'] ? $postdb['name'] : date('Y_md_Hi',time()).'随机试题';
    		if($postdb['grade']){
    			$map['grade']  = ['like','%,'.$postdb['grade'].',%'];
    		}
    		if($postdb['kemu']){
    			$map['kemu']  = ['like','%,'.$postdb['kemu'].',%'];
    		}
    		if($postdb['step']){
    			$map['step']  = ['like','%,'.$postdb['step'].',%'];
    		}
    		$map['uid'] = $this->user['uid']; //只挑选自己的试题
    		$single = $multiple = $judge = 0;
    		//单选
    		if($postdb['single_num']){
    			$content1 = get_contentlist_bymid(1,$map); //单选数据
    			$content1_num = count($content1); //单选题总数量
    			if($postdb['single_num']>$content1_num){
    				$this->error("单选题题库数量不足，题目数量为{$content1_num}道，生成失败");
    			}
    			$content1_arr = array();
    			foreach($content1 AS $v){
    				$content1_arr[] = $v['id'];
    			}
    			$content1_arr = array_flip($content1_arr); //试题id作为键名
    		}
    		// 多选
    		if($postdb['multiple_num']){
    			$content2 = get_contentlist_bymid(2,$map); //多选数据
    			$content2_num = count($content2); //多选题总数量
    			if($postdb['multiple_num']>$content2_num){
    				$this->error("多选题题库数量不足，题目数量为{$content2_num}道，生成失败");
    			}
    			$content2_arr = array();
    			foreach($content2 AS $v){
    				$content2_arr[] = $v['id'];
    			}
    			$content2_arr = array_flip($content2_arr);
    		}
    		// 判断
    		if($postdb['judge_num']){
    			$content3 = get_contentlist_bymid(3,$map); //判断数据
    			$content3_num = count($content3); //判断题总数量
    			if($postdb['judge_num']>$content3_num){
    				$this->error("判断题题库数量不足，题目数量为{$content3_num}道，生成失败");
    			}
    			$content3_arr = array();
    			foreach($content3 AS $v){
    				$content3_arr[] = $v['id'];
    			}
    			$content3_arr = array_flip($content3_arr);
    		}
    		//填空题
    		if($postdb['write_num']){
    		    $content4 = get_contentlist_bymid(4,$map); //判断数据
    		    $content4_num = count($content4); //判断题总数量
    		    if($postdb['write_num']>$content4_num){
    		        $this->error("填空题题库数量不足，题目数量为{$content4_num}道，生成失败");
    		    }
    		    $content4_arr = array();
    		    foreach($content4 AS $v){
    		        $content4_arr[] = $v['id'];
    		    }
    		    $content4_arr = array_flip($content4_arr);
    		}
    		
    		if($postdb['category_num']<=1){//随机生成一份试卷
    			
    			$content1_ids = array_rand($content1_arr,$postdb['single_num']); //要入库的单选试题ID
    			$content2_ids = array_rand($content2_arr,$postdb['multiple_num']); //要入库的单选试题ID
    			$content3_ids = array_rand($content3_arr,$postdb['judge_num']); //要入库的单选试题ID
    			$content4_ids = array_rand($content4_arr,$postdb['write_num']); //要入库的 试题ID
    			
    			$create_category = $this->model->create($postdb);
    			$cid = $create_category->id;
    			if($cid){
    				if(is_array($content1_ids)){
    					$content1_idstr = implode(',',$content1_ids);
    				}else{
    					$content1_idstr = $content1_ids;
    				}
    				if(is_array($content2_ids)){
    					$content2_idstr = implode(',',$content2_ids);
    				}else{
    					$content2_idstr = $content2_ids;
    				}
    				if(is_array($content3_ids)){
    					$content3_idstr = implode(',',$content3_ids);
    				}else{
    					$content3_idstr = $content3_ids;
    				}
    				if(is_array($content4_ids)){
    				    $content4_idstr = implode(',',$content4_ids);
    				}else{
    				    $content4_idstr = $content4_ids;
    				}
    				$idstr = $content1_idstr.','.$content2_idstr.','.$content3_idstr.','.$content4_idstr;
    				$new_ids = explode(',',$idstr); //最终要入库的试题ID数组(没值需过滤掉)
    				
    				$create_data = array();
    				foreach($new_ids AS $k=>$v){
    					if(!$v){
    						continue;
    					}
    					$create_data[$k]['aid'] = $v;
    					$create_data[$k]['cid'] =$cid;
    				}
    				
    				$create_num = InfoModel::create_info($create_data);
    				$this->success('生成成功',murl('paper/index'));
    				
    			}else{
    				$this->error('试卷生成失败，请重新操作！');
    			}
    		}else{//多份试卷
    			$c_n = 0;
    			$new_name = $postdb['name'];
    			for($i=1;$i<=$postdb['category_num'];$i++){
    				
    				$content1_ids = array_rand($content1_arr,$postdb['single_num']); //要入库的单选试题ID
    				$content2_ids = array_rand($content2_arr,$postdb['multiple_num']); //要入库的单选试题ID
    				$content3_ids = array_rand($content3_arr,$postdb['judge_num']); //要入库的单选试题ID
    				$content4_ids = array_rand($content4_arr,$postdb['write_num']); //要入库的 试题ID
    				
    				$postdb['name'] = $new_name.'(随机测试'.$i.')';
    				$create_category = $this->model->create($postdb);
    				$cid = $create_category->id;
    				if($cid){
    					
    					if(is_array($content1_ids)){
    						$content1_idstr = implode(',',$content1_ids);
    					}else{
    						$content1_idstr = $content1_ids;
    					}
    					if(is_array($content2_ids)){
    						$content2_idstr = implode(',',$content2_ids);
    					}else{
    						$content2_idstr = $content2_ids;
    					}
    					if(is_array($content3_ids)){
    						$content3_idstr = implode(',',$content3_ids);
    					}else{
    						$content3_idstr = $content3_ids;
    					}
    					if(is_array($content4_ids)){
    					    $content4_idstr = implode(',',$content4_ids);
    					}else{
    					    $content4_idstr = $content4_ids;
    					}
    					$idstr = $content1_idstr.','.$content2_idstr.','.$content3_idstr.','.$content4_idstr;
    					$new_ids = explode(',',$idstr); //最终要入库的试题ID数组(没值需过滤掉)
    					
    					$create_data = array();
    					foreach($new_ids AS $k=>$v){
    						if(!$v){
    							continue;
    						}
    						$create_data[$k]['aid'] = $v;
    						$create_data[$k]['cid'] =$cid;
    					}
    					$create_num = InfoModel::create_info($create_data);
    					if($create_num){
    						$c_n++;
    					}
    				}
    			}
    			if($c_n>0){
    				$this->success("成功生成{$c_n}份试卷",murl('paper/index'));
    			}else{
    				return $this->error('生成失败');
    			}
    		}
    	}
    	
    	$this->form_items = [
    			['hidden', 'uid',$this->user['uid']],
    			['text', 'name', '试卷名称'],
    			[ 'select','grade','所属年级','<script> $(function(){ if($("#atc_grade").children().length<1){ $("#form_group_grade").remove();}  });</script>',fun('exam@get_sort','grade')],
    			[ 'select','kemu','所属科目','<script>$(function(){ if($("#atc_kemu").children().length<1){ $("#form_group_kemu").remove();} });</script>',fun('exam@get_sort','kemu')],
    			[ 'select','step','所属章节','<script>$(function(){ if($("#atc_step").children().length<1){ $("#form_group_step").remove();}  });</script>',fun('exam@get_sort','step')],
    			['number', 'single_num', '单选题数量','数量最多不能超过题库数量，为0即不选择该题型'],
    			['number', 'multiple_num', '多选题数量','数量最多不能超过题库数量，为0即不选择该题型'],
    			['number', 'judge_num', '判断题数量','数量最多不能超过题库数量，为0即不选择该题型'],
    	    ['number', 'write_num', '填空题数量','数量最多不能超过题库数量，为0即不选择该题型'],
    			['number', 'category_num', '随机生成试卷份数','默认随机生成1份，需要多份可修改数值',1],
    			
    	];
    	$this->tab_ext['page_title'] = '随机出卷';
    	return $this->addContent('index');
    	
    }
    
    //判断用户是否有权增加试卷
    protected function check_power(){
    	if($this->webdb['can_add_paper_group'] && !in_array($this->user['groupid'],$this->webdb['can_add_paper_group'])){
    		$this->error('你所在用户组没权限进行试卷相关操作');
    	}
    }
    
}