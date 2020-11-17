<?php
namespace plugins\msgtask\admin;

use app\common\controller\AdminBase;
use app\common\traits\AddEditList;
use app\common\model\User AS UserModel;
use plugins\msgtask\model\Task AS TaskModel;
use plugins\msgtask\model\Log AS LogModel;
//use think\Db;

class Info extends AdminBase
{
	use AddEditList;	
	protected $validate = '';
	protected $model;
	protected $form_items = [];
	protected $list_items;
	protected $tab_ext = [
			'page_title'=>'群发消息',
	];
	
	protected function _initialize(){
	    parent::_initialize();
	}
	
	/**
	 * 群发消息
	 * @param number $page
	 * @param number $num
	 * @return mixed|string
	 */
	public function add($page=1,$num=0){
	    $this->tab_ext['top_button'] = [];
	    $this->form_items = [
	        ['text','title','信息标题','可为空,仅显示在系统短消息或邮件那里'],
	        ['textarea','content','信息内容',''],
	        ['checkbox','typs','哪种方式发送','',['0'=>'系统短消息','1'=>'微信消息','2'=>'手机短信','3'=>'邮件'],'0'],
	        ['checkbox','groups','哪些用户组','不选择,则给所有用户发送',getGroupByid()],
	        ['radio','sendtype','发送模式','',[0=>'页面反复跳转的形式(没发送完不可离开当前页面)',1=>'后台慢慢执行(需要先配置定时任务)']],
	        ['datetime','begin_time','何时才开始群发'],
	        ['number','rows','发送速度','即页面每刷新一次发送几个用户,若同时发送手机、邮件、微信的话，建议设置为1，因为效率会比较低，仅仅系统短消息的话，设置100也没问题。',1],
	        ['textarea','sncode','序列号/密码','每个换一行,每人会自动分别发放一个'],
	    ];
	    
	    $this->tab_ext['trigger'] = [
	        ['sendtype','1','begin_time'],
	        ['sendtype','0','rows'],
	    ];
	    
	    $this->tab_ext['help_msg'] = '1.页面跳转的形式发送不支持定时群发，定时群发需要配置定时任务。
                                    <br>2.群发手机短信,标题用不到<br>3.用户只有关注并绑定了公众号,才能发微信消息';
	    
	    if ($this -> request -> isPost()) {
	        $data = $this->request->post();
	        if (empty($data['content'])) {
	            $this->error('内容不能为空!');
	        }
	        $data['title'] || $data['title']='系统消息';
	        cache('qunfa_data',$data,3600);
	        $this->send($data,$page,$num);
	    }elseif($page>1){
	        $data = cache('qunfa_data');
	        $this->send($data,$page,$num);
	    }
	    return $this->addContent();
	}
	
	/**
	 * 处理发送消息
	 * @param array $data
	 * @param number $page
	 * @param number $num
	 */
	private function send($data=[],$page=1,$num=0){
	    if (empty($data['content'])) {
	        $this->error('发送的内容不能为空!');
	    }elseif (empty($data['groups'])) {
	        $this->error('至少要选择一个用户组!');
	    }
	    if($page<1){
	        $page = 1;
	    }
	    if ($data['sendtype']==1) {
	        $this->task_send($data,$page);
	    }else{
	        $this->refresh_send($data,$page,$num);
	    }
	}
	
	/**
	 * 定时任务在后台发送消息
	 * @param array $data
	 * @param number $page
	 * @param number $num
	 */
	private function task_send($data=[],$page=1){
	    if ($page==2) {
	        $url = purl('task/index');
	        echo "<script language='javascript' type='text/javascript'>setTimeout(\"javascript:location.href='$url'\", 1500); </script>任务已完成,你可以关闭本页面...";
	        $url = iurl('index/task/index');
	        echo "<iframe src='$url' width='1' height='1'></iframe>";
	        exit;
	    }
	    $result = TaskModel::create([
	        'title'=>$data['title'],
	        'content'=>$data['content'],
	        'sncode'=>$data['sncode'],
	        'uid'=>$this->user['uid'],
	        'begin_time'=> $data['begin_time'] ? strtotime($data['begin_time']) : 0,
	        'type'=> is_array($data['typs']) ? implode(',', $data['typs']) : $data['typs'].'',
	    ]);
	    $tid = $result->id;
	    $data['rows'] = 3000;  //每次取3千条记录
	    $num = 0;
	    $obj = new LogModel();
	    set_time_limit(0);
	    do{
	        $array = [];
	        $listdb = $this->get_listdb($data,$page);
	        foreach ($listdb AS $rs){
	            $num++;
	            $ar = [];
	            in_array(1, $data['typs']) && $rs['weixin_api'] && $ar['weixin_api']=$rs['weixin_api'];
	            in_array(2, $data['typs']) && $rs['mobphone'] && $ar['mobphone']=$rs['mobphone'];
	            in_array(3, $data['typs']) && $rs['email'] && $ar['email']=$rs['email'];	            
	            $array[] = [
	                'touid'=>$rs['uid'],
	                'touser'=>json_encode($ar),
	                'tid'=>$tid,
	            ];
	        }
	        $obj->saveAll($array);
	        usleep(300000);    //休息300毫秒,即0.3秒,让服务器缓解一下压力
	        $page++;
	    }while($listdb);
	    task_config(true);
	    $url = purl('add',['page'=>2]);
	    $this->success("总共有 {$num} 位用户，已添加到任务栏，请稍候...",$url,'',0);
	}
	
	/**
	 * 分批取出要发送的用户
	 * @param array $data
	 * @param number $page
	 * @return unknown
	 */
	private function get_listdb($data=[],$page=1){
	    $map = [];
	    if ($data['groups']) {
	        $map['groupid'] = ['in',$data['groups']];
	    }
	    $page<1 && $page=1;
	    $rows = $data['rows']?:1;
	    $min = ($page-1)*$rows;
	    $listdb = UserModel::where($map)->order('uid asc')->limit($min,$rows)->column('uid,weixin_api,email,mobphone');
	    return $listdb;
	}
	
	/**
	 * 反复刷新网页的形式发送消息
	 * @param array $data
	 * @param number $page
	 * @param number $num
	 */
	private function refresh_send($data=[],$page=1,$num=0){
	    $ck = false;
	    $detail = [];
	    if($data['sncode']!=''){    //存在序列号或消费码
	        $detail = str_array($data['sncode'],"\n");
	    }
	    $i=0;
	    $listdb = $this->get_listdb($data,$page);
	    foreach ($listdb AS $rs){
	        $content = $data['content'];
	        if($detail[$i]){
	            $content .= '，你的消费码是:'.$detail[$i];
	            unset($detail[$i]);
	        }
	        if (in_array(0, $data['typs'])) {
	            send_msg($rs['uid'],$data['title'],$content);
	        }
	        if (in_array(1, $data['typs']) && $rs['weixin_api']) {
	            send_wx_msg($rs['weixin_api'], $content);
	        }
	        if (in_array(2, $data['typs']) && $rs['email']) {
	            send_mail($rs['email'], $data['title'], $content);
	        }
	        if (in_array(3, $data['typs']) && $rs['mobphone']) {
	            send_sms($rs['mobphone'], $content);
	        }
	        $ck = true;
	        $num++;
	        $i++;
	    }
	    
	    if($data['sncode']!=''){
	        $data['sncode'] = implode("\r\n", $detail);
	        cache('qunfa_data',$data,3600);
	    }
	    
	    
	    if($ck==false){
	        $this->success('发送完毕,总共发送了'.$num.'位用户','add','',3600);
	    }else{
	        $page++;
	        $url = purl('add',['page'=>$page,'num'=>$num]);
	        if ($page==2) {
	            $this->success("正在发送第 {$num} 位用户,请稍候...",$url,'',0);
	        }else{
	            echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$url'>正在发送第 {$num} 位用户,请稍候...";exit;
	        }
	    }
	}
	
	
}
