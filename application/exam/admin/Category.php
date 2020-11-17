<?php
namespace app\exam\admin;

use app\common\controller\admin\Category AS _Category;
use app\exam\model\Info;

//试卷
class Category extends _Category
{
    /**
     * 列表要显示的数据
     * @param array $map 查询条件
     * @param string $order 排序方式
     * @param unknown $rows 每页显示多少条
     * @return unknown
     */
    protected function getListData($map = [], $order = '',$rows=20,$pages=[]) {
        $map = array_merge($this -> getMap(), $map);
        
        $order = $this -> getOrder() ? $this -> getOrder() : $order ;
        if (empty($order)) {
            $data_list = $this -> model -> where($map) -> orderRaw('1 desc') -> paginate(
                    empty($rows)?null:$rows,    //每页显示几条记录
                    empty($pages[0])?false:$pages[0],
                    empty($pages[1])?['query'=>input('get.')]:$pages[1]
                    );
        }else{
            $data_list = $this -> model -> where($map) -> order($order) -> paginate(
                    empty($rows)?null:$rows,    //每页显示几条记录
                    empty($pages[0])?false:$pages[0],
                    empty($pages[1])?['query'=>input('get.')]:$pages[1]
                    );
        }
        return $data_list;
    }
    
    protected function set_config(){
        $this->list_items = [
                ['name', '试卷名称', 'link',iurl('category/index',['fid'=>'__id__']),'_blank'],
//                 ['grade', '所属年级', 'select',fun('exam@get_sort','grade')],
//                 ['kemu', '所属科目', 'select',fun('exam@get_sort','kemu')],
//                 ['step', '所属章节', 'select',fun('exam@get_sort','step')],
        ];
        
        $this->form_items = [
                ['hidden', 'pid'],
                ['text', 'name', '试卷名称'],
//                 [ 'select','grade','所属年级','',fun('exam@get_sort','grade')],
//                 [ 'select','kemu','所属科目','',fun('exam@get_sort','kemu')],
//                 [ 'select','step','所属章节','',fun('exam@get_sort','step')],
                //['select', 'pid', '归属上级分类','不选择，则为顶级分类',$this->model->getTreeTitle()],
        ];
        
        $this->tab_ext = [
                'page_title'=>'试卷管理',
                'top_button'=>[
                        [
                                'title' => '创建新的试卷',
                                'icon'  => 'fa fa-fw fa-th-list',
                                'class' => '',
                                'href'  => auto_url('add')
                        ],
                ],
                'right_button'=>[
                        [
                                'title' => '管理试题',
                                'icon'  => 'fa fa-fw fa-file-text-o',
                                'href'  => auto_url('info/index', ['cid' => '__id__'])
                        ],
                        [
                                'type'=>'delete',
                        ],
                        [
                                'type'=>'edit',
                        ]
                ],
        ];
    }

    /**
     * 快速随机出卷
     */
    public function randomadd() {

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

    				$create_num = Info::create_info($create_data);
    				$this->success('生成成功',urls('category/index'));

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
							$create_num = Info::create_info($create_data);
							if($create_num){
								$c_n++;
							}
						}
					}
					if($c_n>0){
						$this->success('生成成功',urls('category/index'));
					}else{
						return $this->error('生成失败');
					}
            }
    	}
    	
    	$this->form_items = [
    			['hidden', 'uid',$this->user['uid']],
    			['text', 'name', '试卷名称'],
    			[ 'select','grade','所属年级','',fun('exam@get_sort','grade')],
    			[ 'select','kemu','所属科目','',fun('exam@get_sort','kemu')],
    			[ 'select','step','所属章节','',fun('exam@get_sort','step')],
    			['number', 'single_num', '单选题数量','数量最多不能超过题库数量，为0即不选择该题型'],
    			['number', 'multiple_num', '多选题数量','数量最多不能超过题库数量，为0即不选择该题型'],
    			['number', 'judge_num', '判断题数量','数量最多不能超过题库数量，为0即不选择该题型'],
    	        ['number', 'write_num', '填空题数量','数量最多不能超过题库数量，为0即不选择该题型'],
                ['number', 'category_num', '随机生成试卷份数','默认随机生成1份，需要多份可修改数值',1],

    	];
    	$this->tab_ext['page_title'] = '随机出卷';
    	return $this->addContent('index');
    

    }
    

    
    
}













