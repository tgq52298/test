<?php
namespace app\vote\index;

use app\common\controller\index\C; 

//内容页与列表页
class Content extends C
{
	/**
	 * 列表页
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::index()
	 */
	public function index($fid=0,$mid=0){
	    // return parent::index($fid,$mid);
		if(!$mid && !$fid){
		    $this->error('参数不存在！');
		}elseif($fid){ //根据栏目选择发表内容
		    $mid = $this->model->getMidByFid($fid);
		    if(empty($mid)){
		        $this->error('分类不存在!');
		    }
		}
		$this->mid = $mid;
		$m_info = model_config($this->mid);//当前模型设置参数
		if(!$m_info){
		    $this->error('模型不存在!');
		}
		// $field_array = get_field($this->mid);
		//获取栏目，即投票项目的设置参数
		$s_info = $fid ? $this->sortInfo($fid) : [];


		//获取当前栏目的数据条数，即投票选项的选手人数
		$TotalNum=$this->model->getNumByMid($mid,['fid'=>$fid]);
		//累计投票
		$TotalVoteNum=$this->model->getColumnByMid($mid,['fid'=>$fid],'agree');
		//累计访问
		$TotalViewNum=$this->model->getColumnByMid($mid,['fid'=>$fid]);
	
	
		//如果某个模型有个性模板的话，就不调用母模板
		$template = $this->get_tpl('list',$mid,$s_info);
		$GLOBALS['fid'] = $fid;     //标签有时会用到
		//列表显示哪些自定义字段
		// $tab_list = $this->getEasyIndexItems($field_array);

		//模板里要用到的变量值
		$vars = [
		        // 'listdb'=>$data_list,
		        'fid'=>$fid,
		        'mid'=>$mid,
		        //'pages'=>$data_list->render(),
		        's_info'=>$s_info,
		        'info'=>$s_info,
		        'm_info'=>$m_info,
		        'TotalNum'=>$TotalNum, //参与选手,即投票选项
		        'TotalVoteNum'=>$TotalVoteNum,
		        'TotalViewNum'=>$TotalViewNum,
		        'listvotes'=>$listvotes,
		];
		return $this->fetch($template,$vars);
	}
	
	/**
	 * 内容详情页
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::show()
	 */
	public function show($id){
	    return parent::show($id);
	}
	
	//多选投票入口
	public function agree_votes(){
		 $data = input();
		 if(!($data['ids'])){
		 	return $this->err_js('您没有选中任何投票项！请先选择');
		 }
		return $this->agree_vote($data['ids'],$data['fid'],$data['type']);
	}



	/**
	 * 投票
	 * @param number $id 主题ID
	 * @return \think\response\Json
	 */
	public function agree_vote($ids,$fid,$type=0){
		if(!$ids){
			return $this->err_js('您没有选中任何投票项！请先选择');
		}
		$id_arr=array();
		if($type==0){
			$id_arr[0]=$ids;
		}else{
			$id_arr=$ids;
		}

		$this_sort = $this->sortInfo($fid); //投票项目设置参数

		// 禁止游客投票
		if($this_sort[forbidguestvote]){
			if(!$this->user){
				return $this->err_js('请先登录');
			}
		}
		if($this_sort[begintime]&&$this_sort[begintime]>time()){

		return $this->err_js('当前投票还没开始！');
		}
		if($this_sort[endtime]&&$this_sort[endtime]<time()){
			return $this->err_js('当前投票已经结束！');
		}

		// 时间限制，每次投票的时间间隔
		if($this_sort[limittime]){
			$time=$this_sort[limittime]*60;

			if( (time() - get_cookie('vote_limittime_'.$fid)) < $time )
			{	
				$msg="{$this_sort[limittime]}分钟内";
				if($this_sort[limittime]>=60){
					$h=floor($this_sort[limittime]/60);
					$i=$this_sort[limittime]%60;
					if($h>0&&$i<1){
						$msg="{$h}小时内";
					}elseif($h>0&&$i>0){
						$msg="{$h}小时{$i}分钟内";
					}
				}
				return $this->err_js("$msg,请不要重复投票,你已经投过了");
			}		
			set_cookie('vote_limittime_'.$fid,time());
		}
		$onlineip=get_ip(); //当前IP
		// 限制IP重复投票
		if($this_sort[limitip]){
			$iparray=explode(',',$this_sort[ips]);
			if(in_array($onlineip,$iparray)){
				return $this->err_js('请不要重复投票,你所在IP已经投过了');
			}
		}
		$ipstr=$this_sort[ips]?$this_sort[ips].','.$onlineip:$onlineip; //IP记录
		$log_uname=$this->user['username'];
		$name = $log_uname?$log_uname:'来自：'.$onlineip.' 的游客';

		foreach($id_arr AS $v){
			$this_resutl = $this_content = '';
			$the_content=$this->model->getInfoByid($v);
			if($the_content['status']==0){
				return $this->err_js('该内容还没通过审核，无法进行投票');
			}
			$data=['aid'=>$v,'fid'=>$fid,'uid'=>$this->user['uid'],'create_time'=>time(),'ip'=>$onlineip];
			$this_resutl = $this->model->addVote($v,$data,$ipstr);
			if($this_resutl){ //投票成功微信通知
				$wxcontent = "你参与的“{$this_sort[name]}”活动，“{$name}”给你投了一票 ";
				$this_content = $this->model->getInfoByid($v);
				send_wx_msg($this_content['uid'],$wxcontent);
			}
		}
		return $this->ok_js('投票成功');
	}
    
	/**
	 * 新发表主题
	 * @param number $fid
	 * @param number $mid
	 * @return mixed|string
	 */
	public function add($fid=0,$mid=1){
	    $fid = input()['fid'] ? input()['fid'] :0;
	    if (!$this->user) {
	        $this->error('请先登录!');
	    }
	    $data = $this->request->post();
	    if (($result=$this->add_check($mid,$fid,$data))!==true) {
		$this->error($result);
	     }


	     return parent::add($fid,$mid);

	}

	/**
	 * 修改主题
	 * @param number $id
	 * @return mixed|string
	 */
	public function edit($id=0){
	    if($id){
	        $this->mid = $this->model->getMidById($id);
	        $info = $this->getInfoData($id);
	        // print_r($info);
	        $fid = $info['fid'];
	        $mid = $info['mid'];
	        if (!$info) {
	            $this->error('ID有误,内容不存在');
	        }
	    }
	    $this->assign('id',$id);
	    $this->assign('info',$info);
	    $this->assign('fid',$fid);
	    $this->assign('mid',$mid);
	    return $this->fetch('post');
	}

	
	//用戶投票列表
	public function userVoteList($fid,$aid){
	    $userVoteList = get_users_vote($fid,$aid);
	    return $userVoteList;
	}
	//投票选项信息
	public function info($id){
	    $infos = fun('content@info',$id,'vote');
	    return $infos;
	}
	//当前排行
	public function voteRanking($id,$mid=1){
	    return get_option_ranking($mid,$id);
	}

}
