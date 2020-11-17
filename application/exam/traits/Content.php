<?php
namespace app\exam\traits;

use app\exam\model\Info AS InfoModel;
use app\exam\model\Category AS PaperModel;

trait Content
{
	/**
	 * 手工录入试题
	 */
	public function add($fid=0,$mid=0)
	{
		$this->check_power();
		$data = $this->request->post();
		isset($data['fid']) && $fid = $data['fid'];

		if($fid && !$mid){
			$mid = $this->model->getMidByFid($fid);
		}elseif( !$fid && !$mid ){  //栏目与模型都为空
			return self::postnew($mid);
		}elseif( config('post_need_sort') && !$fid ){  //指定必须要选择栏目的频道
			return self::postnew($mid);
		}
		$this->mid = $mid;
		
		//接口
		hook_listen('cms_add_begin',$data);
		if (($result=$this->add_check($mid,$fid,$data))!==true) {
			$this->error($result);
		}
		
		// 保存数据
		if ($this -> request -> isPost()) {
			$data['grade'] = is_array($data['grade']) ? ','.implode(',', $data['grade']).',' : ''.$data['grade'] ;
			$data['kemu'] = is_array($data['kemu']) ? ','.implode(',', $data['kemu']).',' : ''.$data['kemu'] ;
			$data['step'] = is_array($data['step']) ? ','.implode(',', $data['step']).',' : ''.$data['step'] ;
			
			$this->saveAdd($mid,$fid,$data);
		}
		
		$this->form_items = array_merge(
				[
						[ 'checkbox','grade','所属年级','',fun('exam@get_sort','grade')],
						[ 'checkbox','kemu','所属科目','',fun('exam@get_sort','kemu')],
						[ 'checkbox','step','所属章节','',fun('exam@get_sort','step')],
				],
				$this->getEasyFormItems()   //发布表单里的自定义字段
				);
		
		//联动字段
		$this->tab_ext['trigger'] = $this->getEasyFieldTrigger();
		
		$this->tab_ext['page_title'] = '新增试题';
		
		return $this->addContent('index',['fid'=>$fid]);
	}
	
	
	/**
	 * 修改试题
	 * @see \app\common\controller\admin\C::edit()
	 */
	public function edit($id)
	{
		$this->mid = $this->model->getMidById($id);
		
		// 保存数据
		if ($this -> request -> isPost()) {
			//表单数据
			$data = $this->request->post();
			
			$data['grade'] = is_array($data['grade']) ? ','.implode(',', $data['grade']).',' : ''.$data['grade'] ;
			$data['kemu'] = is_array($data['kemu']) ? ','.implode(',', $data['kemu']).',' : ''.$data['kemu'] ;
			$data['step'] = is_array($data['step']) ? ','.implode(',', $data['step']).',' : ''.$data['step'] ;
			
			$this->saveEdit($this->mid,$data);
		}
		
		$this->form_items = array_merge(
				[
						[ 'checkbox','grade','所属年级','',fun('exam@get_sort','grade')],
						[ 'checkbox','kemu','所属科目','',fun('exam@get_sort','kemu')],
						[ 'checkbox','step','所属章节','',fun('exam@get_sort','step')],
				],
				$this->getEasyFormItems()   //发布表单里的自定义字段
				);
		
		//联动字段
		$this->tab_ext['trigger'] = $this->getEasyFieldTrigger();
		
		$this->tab_ext['page_title'] = $this->m_model->getNameById($this->mid);
		
		if(empty($id)) $this->error('缺少参数');
		
		$info = $this->getInfoData($id);
		
		//修改内容后，最好返回到模型列表页，因为有可能修改了栏目
		return $this->editContent($info);
	}
	
	/**
	 * 检查文本是不是UTF8格式
	 * @param unknown $text
	 * @return boolean
	 */
	protected function is_utf8($text) {
	    if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$text) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$text) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$text) == true)
	    {
	        return true;
	    }
	    else
	    {
	        return false;
	    }
	}
	
	/**
	 * 文本试题库
	 * @param string $file
	 * @return number[]
	 */
	private function read_txt($file=''){
	    $content = check_bom($file);
	    if ( !$this->is_utf8($content) ){
	        //$current_encode = mb_detect_encoding($content, array("ASCII","GB2312","GBK",'BIG5','UTF-8'));
	        //$content = mb_convert_encoding($content, 'UTF-8', $current_encode);
	        $content =  mb_convert_encoding($content, "UTF-8", "GBK");
	    }
	    $detail = explode("\r\n",$content);
	    $blank = false;
	    foreach($detail AS $key=>$value){
	        if(trim($value)==''){
	            if($blank){
	                unset($detail[$key]);
	            }
	            $blank = true;
	        }else{
	            $blank = false;
	        }
	    }
	    $listdb = [];
	    $array = explode("\r\n\r\n", implode("\r\n", $detail));
	    foreach($array AS $key=>$value){
	        $_ar = explode("\r\n",$value);
	        if (trim($_ar[0])=='') {
	            unset($_ar[0]);
	        }elseif (trim(end($_ar))=='') {
	            unset($_ar[count($_ar)-1]);
	        }
	        
	        $rs = array_values($_ar);
	        if (count($_ar)<2) {
	            if (count($_ar)==1 && empty($listdb) && empty($this->paper_title)) {
	                $this->paper_title = $rs[0];       //存在试卷标题
	            }
	            continue;
	        }
	        $num = count($rs);
	        if ($num<4) {       //判断题或填空题
	            if(trim($rs[1])==1 || trim($rs[1])==2){
	                $rs['mid'] = 3;
	            }else{
	                $rs['mid'] = 4; //填空题
	            }
	        }else{
	            if (($num==4||$num==5)&&is_numeric(trim(end($rs)))) {
	                $rs[5] = trim(end($rs));
	                if ($num==5) {
	                    $rs[4]='';
	                }else{
	                    $rs[3]=$rs[4]='';
	                }
	            }
	            if( strlen( trim(end($_ar)) )>1 ){     //多选题
	                $rs['mid'] = 2;
	            }else{      //单选题
	                $rs['mid'] = 1;
	            }
	        }
	        $listdb[] = $rs;
	    }
	    return $listdb;
	}
	
	/**
	 * 把123这种给他加上逗号
	 * @param string $answer
	 * @return string
	 */
	private function format_answer($answer=''){
	    $answer = str_replace('，', ',', $answer);
	    $answer = trim($answer,',');
	    if ($answer>10){
	        $i = 0;
	        do{
	            $v = substr($answer, $i,1);
	            if ($v) {
	                $detail[] = $v;
	            }
	            $i++;
	        }while($v);
	        return implode(',',$detail);
	    }
	    return $answer;
	}

	
	//excel批量导入试题
	public function batchadd(){
		$this->check_power();
		if($this -> request -> isPost()){
		    $postdb = $this->request->post();
		    
		    $excel_file = $postdb['excel_file']; //上传的文件
		    if($postdb['mid'] && !preg_match('/\.(xls|txt)$/',$excel_file)){
		        $this->error('只能是.xls结尾的2000版或2003版excel表格');
		    }
		    if(preg_match('/\.txt$/',$excel_file)){
		        $postdb['mid'] = 0 ;
		    }
		    if (preg_match("/^(http|https):/", $excel_file)) {
		        if(($str = file_get_contents($excel_file))==false){
		            $str = http_curl($excel_file);
		        }
		        if (!$str) {
		            $this->error('数据读取失败!');
		        }
		        $xls = RUNTIME_PATH.basename($excel_file);
		        file_put_contents($xls, $str);
		    }else{
		        $xls = ROOT_PATH.'public/'.$excel_file; //文件路径
		    }
		    
		    
		    $listdb = $postdb['mid'] ? read_excel($xls) : $this->read_txt($xls);
		    
		    $vertical_num = count($listdb); //多少行,即多少条记录
		    if($vertical_num<1){
		        $this->error('没有任何数据!');
		    }
		    
		    $grade = is_array($postdb['grade']) ? ','.implode(',', $postdb['grade']).',' : ''.$postdb['grade'] ;
		    $kemu = is_array($postdb['kemu']) ? ','.implode(',', $postdb['kemu']).',' : ''.$postdb['kemu'] ;
		    $step = is_array($postdb['step']) ? ','.implode(',', $postdb['step']).',' : ''.$postdb['step'] ;
		    $mid = $postdb['mid'];
		    $this->mid = $mid;
		    isset($postdb['fid']) && $fid = $postdb['fid'];
		    $fid = $fid ? $fid : 0;
		    
		    set_time_limit(0);
		    
		    $ids = [];
		    //$listdb 是取自excel表格内的记录
		    //第一行是标题,不需要入库,从第二行开始入库
		    //每行中的第一列的$key为0,第二列的$key为1以此类推
		    foreach($listdb AS $i=>$rs){
		        unset($data);
		        if($postdb['mid'] && $i==0){
		            continue;
		        }
		        if (!$postdb['mid']) {  //文本题库
		            $mid = $rs['mid'];
		            $this->mid = $mid;
		        }
		        if(!$rs[0]){ //标题不存在直接跳过
		            continue;
		        }
		        
		        $data['grade'] = $grade;
		        $data['kemu'] = $kemu;
		        $data['step'] = $step;
		        $data['mid'] = $mid;
		        
		        //单选题 (单选1、多选2)
		        if($mid<3){
		            $rs[5] = $this->format_answer(str_replace(array("a","b","c","d"),array("1","2","3","4"),strtolower($rs[5])));
		            $data['title'] = $rs[0];
		            $data['answer_a'] = $rs[1];
		            $data['answer_b'] = $rs[2];
		            $data['answer_c'] = $rs[3]?:'';
		            $data['answer_d'] = $rs[4]?:'';
		            $data['answer'] = trim($rs[5],' 　')?:'';
		            $data['content'] = $rs[6]?:'';
		        }else if($mid==3){  //判断题
		            $rs[1] = str_replace(array("正确","错误","对","错"),array("1","2","1","2"),$rs[1]);
		            $data['title'] = $rs[0];
		            $data['answer'] = trim($rs[1],' 　');
		            $data['content'] = $rs[2]?:'';
		        }else if($mid==4){  //填空题
		            $data['title'] = $rs[0];
		            $data['answer'] = trim($rs[1],' 　')?:'';
		            $data['content'] = $rs[2]?:'';
		        }else{
		            $this->error('未知题型，可联系管理员进行处理！');
		        }
		        
		        
		        $save_result = $this->saveAdd($mid,$fid,$data,false);
		        if($save_result){
		            $ids[] = $save_result;
		        }
		    }
		    
		    unlink($xls);
		    
		    if ($ids && $this->paper_title) {
		        $result = PaperModel::create([
		            'uid'=>$this->user['uid'],
		            'name'=>$this->paper_title,
		            'award_type'=>'no',
		        ]);
		        if ($result) {
		            $paper_id = $result->id;
		            $array = [];
		            foreach($ids AS $aid){
		                $array[] = [
		                    'aid'=>$aid,
		                    'cid'=>$paper_id,
		                ];
		            }
		            $obj = new InfoModel;
		            $obj->saveAll($array);
		        }
		    }
		    $this->success("excel成功导入 ".count($ids)." 条试题", auto_url('index') );
		    
		}
		
		$this->form_items = [
		    [ 'checkbox','grade','所属年级','<script> $(function(){ if($("#form_group_grade input").length<1){ $("#form_group_grade").remove();}  });</script>',fun('exam@get_sort','grade')],
		    [ 'checkbox','kemu','所属科目','<script>$(function(){ if($("#form_group_kemu input").length<1){ $("#form_group_kemu").remove();} });</script>',fun('exam@get_sort','kemu')],
		    [ 'checkbox','step','所属章节','<script>$(function(){ if($("#form_group_step input").length<1){ $("#form_group_step").remove();}  });</script>',fun('exam@get_sort','step')],
		    ['radio', 'mid', '题型', '单选题、多选题、判断题只能是excel表格，自动识别只能.txt文本格式', ['自动识别', '单选题', '多选题', '判断题'], 1],
		    ['file', 'excel_file', 'excel表格/txt文本','注意事项：excel表格只能是.xls结尾的2000版或2003版excel表格，请点击下载各种题型的样本，<a href="http://down.qibosoft.com/exam/a.xls" target="_blank">单选题范例</a>、<a href="http://down.qibosoft.com/exam/b.xls" target="_blank">多选题范例</a>、<a href="http://down.qibosoft.com/exam/c.xls" target="_blank">判断题范例</a>、<a href="http://down.qibosoft.com/exam/exam.txt" target="_blank">自动识别范例(含试卷)</a>'],
		];
		$this->tab_ext['page_title'] = '批量导入试题(试卷)';
		return $this->addContent('index');
	}
	
	
    /**
    * 处理提交的新发表数据
    * @param number $mid 模型ID
    * @param number $fid 栏目ID
    * @param array $data POST表单的数据
    */
	protected function saveAdd($mid=0,$fid=0,$data=[],$jump=true){

        //主要针对多选项的数组进行处理
        $data = $this->format_post_data($data);

        if(!empty($this->validate)){
            // 验证
            $result = $this->validate($data, $this->validate);
            if(true !== $result) $this->error($result);
        }
        $data['uid'] = $this->user['uid'];
        $data['mid'] = $this->mid;     

        $id = $this->model->addData($this->mid,$data);  
        
        if(is_numeric($id)){
            //以下两行是接口
            hook_listen('cms_add_end',$id,['data' =>$data, 'module' =>$this->request->module()]);       
            $this->end_add($id,$data);
            if($jump==true){
            	$this->success('新增成功', auto_url('index',$fid ? ['fid'=>$fid] : ['mid'=>$mid]) );
            }else{
            	return $id;
            }
            
        }else{
        	if($jump==true){
        		$this -> error('新增失败:'.$id);
        	}else{
        		return false;
        	}
            
        }
        
    }



    /**
     * 同时适用于前台与后台 新增加后做个性拓展
     * @param number $id 内容ID
     * @param number $data 内容数据
     */
//     protected function end_add($id=0,$data=[]){
//     }
    
    /**
     * 同时适用于前台与后台 修改后做个性拓展
     * @param number $id 内容ID
     * @param array $data 内容数据
     */
//     protected function end_edit($id=0,$data=[]){
//     }
    
    /**
     * 同时适用于前台与后台 删除后做个性拓展
     * @param number $id 内容ID
     * @param array $info 内容数据
     */
//     protected function end_delete($id=0,$info=[]){
//     }
}