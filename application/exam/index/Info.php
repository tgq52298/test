<?php
namespace app\exam\index;

use app\common\controller\IndexBase;
use app\exam\model\Category as CategoryModel;
use app\exam\model\Content as ContentModel;
use app\exam\model\Info as InfoModel;
use app\exam\model\Answer;
use app\exam\model\Putin;
use think\Cache;
use think\Image;


class Info extends IndexBase
{
    public function index($fid=0){
        return $this->fetch();
    }
    
    //秒换算成时分秒
    public function sec_to_time($times){
    	$result = '00:00:00';
    	if ($times>0) {
    		$hour = floor($times/3600);
    		$hour = $hour<10 ? '0'.$hour : $hour;
    		$minute = floor(($times-3600 * $hour)/60);
    		$minute = $minute<10 ? '0'.$minute : $minute;
    		$second = floor((($times-3600 * $hour) - 60 * $minute) % 60);
    		$second = $second<10 ? '0'.$second : $second;
    		
    		$result = $hour.' : '.$minute.' : '.$second;
    	}
    	return $result;
    }
    
    protected function format_answer($answer='',$mid=0){
        if ($mid==3) {
            return get_status($answer,['','A、正确','B、错误']);
        }elseif ($mid==2) {
            $detail = explode(',',$answer);
            $array = [];
            foreach ($detail AS $value){
                $array[] = get_status($value,['','A','B','C','D']);
            }
            return implode('、', $array);
        }else{
            return get_status($answer,['','A','B','C','D']);
        }
    }
    
    /**
     * 显示试卷里的某条试题
     * @param number $fid
     * @param number $id
     * @return mixed|string
     */
    public function show($fid=0,$aid=0)
    {
        $s_info = getArray(CategoryModel::get($fid));   //试卷信息,也即辅栏目信息
        if (empty($s_info)) {
            $this->error('当前试卷不存在!');
        }
        
        $thisPutin = Putin::getInfo(['uid'=>$this->user['uid'],'paperid'=>$fid]);        
        if ($thisPutin) {
            if ($s_info['just_test']) {     //练习题可重复考试,把之前的成绩清空
                Putin::where(['uid'=>$this->user['uid'],'paperid'=>$fid])->delete();
            }else{
                $this->error('当前试卷您已经考过了，不能重复考试！', auto_url('putinover',['fid'=>$fid]));
            }            
        }

        //考试开始时间
        if($s_info['begin_time'] && $s_info['begin_time']>time()){
        	$this->error("还没到开考时间，开始考试时间为".format_time($s_info['begin_time'],'Y-m-d H:i:s'));
        }
        //考试结束时间
        if($s_info['end_time'] && $s_info['end_time']<time()){
        	$this->error("该考试已结束，考试结束时间为".format_time($s_info['end_time'],'Y-m-d H:i:s'));
        }
        
        //考试时间
        $limit_time = $s_info['limit_time'];
        
        $cache_name = $this->user['uid'].'_'.$fid.'startexam';//考生所对应的试卷标识
        $check_user_mark = cache($cache_name); //获取该考生试卷的开始答题时间
        
        if(!$check_user_mark){
            if ( $s_info['money']>0 ) {
                if ($this->user['money']<$s_info['money']) {
                    $this->error('你的积分不足：'.$s_info['money'].'个，请联系管理员充值',purl('marketing/jifen/add',[],'member'));
                }
                add_jifen($this->user['uid'],-$s_info['money'],'参与考试：'.$s_info['name'].' 扣除');
                add_jifen($s_info['uid'],$s_info['money'],$this->user['username'].' 参与考试，'.$s_info['name'].' 赚取');
            }
            $check_user_mark = time();
            cache($cache_name,$check_user_mark); //缓存开始答题时间            
        }
        
        //设置了考试时间
        if($limit_time){
        	$user_limittime = $check_user_mark + $limit_time*60; //用户开始考试后的终止时间
        	$remainder_time = $user_limittime - time();//答题剩余时间
        	$show_remainder_time = $this->sec_to_time($remainder_time);
        }
        
        
        //获取试题内容数据
        $info = ContentModel::getInfoById($aid);
        $this->mid = $info['mid'];
        $info['_answer'] =  $this->format_answer($info['answer'],$info['mid']);

        ContentModel::addView($aid);     //更新试题点击率
        
        //$GLOBALS['fid'] = $info['fid']; //标签可能会用到        
        
        $answerinfo = Answer::getInfo(['uid'=>$this->user['uid'],'paperid'=>$fid,'aid'=>$aid]);     //已选择的答案

        //$info['answer'] = $s_info['just_test']?$info['_answer']:$answerinfo['answer'];
        $info['user_answer'] = $answerinfo['answer'];
        
        $info['answer_a'] = preg_replace("/^<p>(.*?)<\/p>$/i",'\\1',$info['answer_a']);
        $info['answer_b'] = preg_replace("/^<p>(.*?)<\/p>$/i",'\\1',$info['answer_b']);
        $info['answer_c'] = preg_replace("/^<p>(.*?)<\/p>$/i",'\\1',$info['answer_c']);
        $info['answer_d'] = preg_replace("/^<p>(.*?)<\/p>$/i",'\\1',$info['answer_d']);
        $info['title'] = preg_replace("/^<p>(.*?)<\/p>$/i",'\\1',$info['title']);
        
        //统计已经进行到第几题
        $have_num = $this->have_exam($fid,$aid);

        //模板里要用到的变量值
        $vars = [
                'info'=>$info,
                'aid'=>$aid,
                'fid'=>$fid,
                's_info'=>$s_info,
        		'limit_time'=>$limit_time, //考试时间
        		'remainder_time'=>$remainder_time,//剩余时间
        		'show_remainder_time'=>$show_remainder_time,//格式化显示剩余时间
                'have_num'=>$have_num,
        ];
        $template = getTemplate('show'.$this->mid) ?: getTemplate('show');
        return $this->fetch($template,$vars);        
    }
    
    /**
     * 统计已经进行到第几题
     * @param number $fid
     * @param number $aid
     * @return unknown
     */
    private function have_exam($fid=0,$aid=0){
        $id = InfoModel::where(['cid'=>$fid,'aid'=>$aid])->value('id');
        $have_num = InfoModel::where(['cid'=>$fid])->where('id','>',$id)->order("list DESC,id DESC")->count('id');
        $have_num++;
        return $have_num;
    }
    
    /**
     * 获取试卷中的下一道题
     * @param unknown $id
     * @return mixed|string
     */
    public function next($fid,$aid)
    {
        $next_aid = InfoModel::getNextAidByAid($aid,$fid);
        if (empty($next_aid)) {
            return  $this->over($fid);
        }
        return $this->show($fid,$next_aid);
    }
    
    
    /**
     * 获取试卷中的上一道题
     * @param unknown $id
     * @return mixed|string
     */
    public function prav($fid,$aid)
    {
        $next_aid = InfoModel::getPravAidByAid($aid,$fid);
        if (empty($next_aid)) {
            $this->error('已经到尽头了');
        }
        return $this->show($fid,$next_aid);
    }
    
    
    /**
     * 考试结束
     * @param unknown $id
     * @return mixed|string
     */
    public function over($fid)
    {
       $s_info = getArray(CategoryModel::get($fid));
       $aid0 = InfoModel::where(['cid'=>$fid])->order('list DESC,id DESC')->value('aid');
       
       $numbers = InfoModel::where(['cid'=>$fid])->count();
       $answers = Answer::where(['uid'=>$this->user['uid'],'paperid'=>$fid])->count();
        
       return $this->fetch('over',['s_info'=>$s_info,'aid0'=>$aid0,'fid'=>$fid,'numbers'=>$numbers,'answers'=>$answers]);
    }
    
    
    /**
     * 学生考试选择的试题答案
     * @param number $fid 试卷ID
     * @param number $aid 试题ID
     * @param string $answer 用户选择的答案
     * @return void|\think\response\Json
     */
    public function answer($fid=0,$aid=0,$answer='')
    {
        $info = ContentModel::getInfoById($aid);
        if (empty($info)) {
            return $this->err_js('试题不存在');
        }elseif ($answer==='') {
            return $this->err_js('没有选择答案');
        }
        $Putinfo = Putin::getInfo(['uid'=>$this->user['uid'],'paperid'=>$fid]); //检查用户是否已交卷
        if (empty($Putinfo)) {  //考生还没交卷，添加或修改试题答案
            $thisinfo = Answer::getInfo(['uid'=>$this->user['uid'],'paperid'=>$fid,'aid'=>$aid]);
            if(!table_field('exam_answer','is_true')){
                query("ALTER TABLE  `qb_exam_answer` ADD  `is_true` TINYINT( 1 ) NOT NULL COMMENT  '1全对，-1全错，2对一部分';");
            }
            $if_true = fun('exam@check_answer',$info,$answer);  //核对答案是否正确
            
            if (empty($thisinfo)) { //添加答案
                Answer::create(['uid'=>$this->user['uid'],'paperid'=>$fid,'aid'=>$aid,'answer'=>$answer,'is_true'=>$if_true]);
                if ($if_true==1 && $this->webdb['each_title_dou']) {
                    add_dou($this->user['uid'], $this->webdb['each_title_dou'],'答题正确');
                }
            }else{  //修改答案
                Answer::update(['id'=>$thisinfo['id'],'answer'=>$answer,'is_true'=>$if_true]);
                if ($this->webdb['each_title_dou']) {
                    if($if_true==1 && $thisinfo['is_true']!=1){         //原来做错了,后来改对了,重新奖励
                        add_dou($this->user['uid'], $this->webdb['each_title_dou'],'答题正确');
                    }elseif($if_true!=1 && $thisinfo['is_true']==1){    //原来做对的奖励了金豆,后来又做错了,要扣除掉
                        add_dou($this->user['uid'], -abs($this->webdb['each_title_dou']),'把答案改错');
                    }                    
                }
            }
            return $this->ok_js();
        }else{
            return $this->err_js('考生已交卷，不能修改答案');
        }
    }
    
    
    /**
     * 用户提交试卷 考生交卷
     * @param unknown $id
     * @return mixed|string
     */
    public function putin($fid=0)
    {     
        $thisinfo = Putin::getInfo(['uid'=>$this->user['uid'],'paperid'=>$fid]);
        
        if (empty($thisinfo)) {                                 //还没考试过的
            $fenone = $this->fenone($fid);              //每题多少分
            $answerok = $this->answerok($fid);      //答对的题目数量 
            
            $total_fen = round($fenone*$answerok,2);    //考生本次考试成绩
            
            $cache_name = $this->user['uid'].'_'.$fid.'startexam';//考生所对应的试卷标识
            $use_time = time()- Cache::get($cache_name); //考试用时

            $result = Putin::create(['uid'=>$this->user['uid'],'paperid'=>$fid,'fen'=>$total_fen,'use_time'=>$use_time]);
            
            if ($result) {                
                $this->add_paper_dou($total_fen);   //奖励
                
                //试卷统计总考试人数及平均分
                CategoryModel::update([
                        'id'=>$fid,
                        'user_num'=>fun('exam@test_num',$fid),
                        'ave_fen'=>fun('exam@average',$fid),
                		'use_time'=>$use_time,
                ]);
                
                $array = [
                        'user'=>$this->user,
                        'paperid'=>$fid,
                        'fen'=>$total_fen,
                ];
                
                hook_listen('exam_paper_end',$array);     //钩子扩展
           
                $this->success("提交成功", auto_url('putinover',['fid'=>$fid]));
            }else{
                $this->error('数据执行失败');
            }
        }else{
            $this->error('当前试卷您已经考过了，不能重复交卷！', auto_url('putinover',['fid'=>$fid]));
           // Putin::update(['id'=>$thisinfo['id'],'fen'=>$total_fen]);
        }
    }
    
    /**
     * 考试奖励
     * @param number $total_fen 考试成绩分数
     */
    private function add_paper_dou($total_fen=0){
        if (empty($this->webdb['paper_fen_dou'])) {
            return ;
        }
        $this->webdb['paper_fen_dou'] = str_replace('，', ',', $this->webdb['paper_fen_dou']);
        $data = [];
        $detail = explode(',',$this->webdb['paper_fen_dou']);
        foreach($detail AS $str){            
            list($_dou,$_fen) = explode('/',$str);
            if (empty($_dou) || empty($_fen)) {
                continue;
            }
            $data[$_fen] = $_dou;
        }
        krsort($data);
        foreach($data AS $_fen=>$_dou){
            if ($total_fen>=$_fen) {
                add_dou($this->user['uid'], $_dou,'考试奖励');
                break;
            }
        }
    }
    
    /**
     * 试卷中每条题的分数
     * @param unknown $id
     * @return mixed|string
     */     
    protected function fenone($fid=0){
        $numbers= InfoModel::where(['cid'=>$fid])->count('id');
        $fenone=round(100/$numbers,2);
        return $fenone;
    }
    
    /**
     * 得到用户答对题目的条数
     * @param unknown $id
     * @return mixed|string
     */
    protected function answerok($fid=0){
        $aiddb = InfoModel::getAllIdByFid($fid);        //试卷中的所有试题ID
        foreach ($aiddb AS $value){                     //$value为试题ID
            $info = ContentModel::getInfoById($value);  //试题数据
            //$answer0[$value] = $info['answer'];         //试题答案
            $answer0[$value] = $info;                   //试题答案
        }
        
        $answer1 = Answer::where(['uid'=>$this->user['uid'],'paperid'=>$fid])->select();   //当前用户此份试卷的所有答案     
        $answer1 = getArray($answer1);
        
        $answerok = 0;
        foreach ($answer1 AS $rs){
            if(fun('exam@check_answer',$answer0[$rs['aid']],$rs['answer'])==1){
            //if($answer0[$rs['aid']]==$rs['answer']){
                $answerok++;
            }
        }        
        return $answerok;
    }
    
    /**
     * 交卷后展示考试结果
     * @param unknown $id
     * @return mixed|string
     */
    public function putinover($fid=0){

        $s_info = getArray(CategoryModel::get($fid));
        $numbers= InfoModel::where(['cid'=>$fid])->count();
        $answers= Answer::where(['uid'=>$this->user['uid'],'paperid'=>$fid])->count();
        $fenone=round(100/$numbers,2);        
        $answerok=$this->answerok($fid);
        $total_fen=round($fenone*$answerok,2);
        $aid0= InfoModel::where(['cid'=>$fid])->order('list DESC,id DESC')->value('aid');
        $thisPutin = Putin::getInfo(['uid'=>$this->user['uid'],'paperid'=>$fid]);
        
        //生成证书
//         $diploma_url = $this->diploma($fid,$s_info,$total_fen);
//         $diploma_url = $diploma_url ? tempdir($diploma_url) : '';
        $haobao_info = $this->get_haibao_info($fid,$s_info,$total_fen,$thisPutin);
        return $this->fetch('putinover',[
                's_info'=>$s_info,
                'fenone'=>$fenone,
                'fid'=>$fid,
                'numbers'=>$numbers,
                'answers'=>$answers,
                'total_fen'=>$total_fen,
                'answerok'=>$answerok,
                'aid0'=>$aid0,
                'haobao_info'=>$haobao_info,
                'codeimg'=>get_qrcode(urls('category/index',['fid'=>$fid,'p_uid'=>$this->user['uid']])),
                'diploma_url'=>$diploma_url                
        ]);
    }
    
    /**
     * 获取证书相关文本内容
     * @param number $fid
     * @param array $data
     * @param number $fen
     * @return array|mixed[]|NULL[]
     */
    protected function get_haibao_info($fid=0,$data=[],$fen=0,$paper=[]){
        if(empty($this->webdb['is_prize_open'])){
            return []; //后台若没启用证书功能则直接退出
        }
        if(!$data){
            $data = getArray(CategoryModel::get($fid));//如没传试卷参数进来泽根据试卷ID进行查询
        }
        $array = [];
        //试卷或模块设置的分数对应的评语和称号
        $prize_about = $prize_about ?: $this->webdb['prize_about'];
        //试卷或模块设置的证书颁发机构署名
        $array['prize_cop'] = $data['prize_cop'] ?: $this->webdb['prize_cop'];
        
        if(!$prize_about && !$array['prize_cop']){
            return []; //分数对应的评语称号和证书颁发机构署名都没则不生成证书
        }
        
        //各分数对应的评语和称号处理
        $prize_about_arr = explode("\r\n",$prize_about);
        $prize_arr = $prize_arr2 = array();
        foreach ($prize_about_arr AS $v){
            if(!$v){
                continue;
            }
            $prize_arr = explode('|',$v);
            $prize_arr2[$prize_arr[0]]=$prize_arr;
        }
        krsort($prize_arr2);//分数由高到低排序
        foreach($prize_arr2 AS $k=>$v){
            if($fen>=$k){
                $user_prize_about = $v;//考试得分所对应的评语称号
                break;
            }
        }
        if(!$user_prize_about){
            $user_prize_about = end($prize_arr2);//上面没有符合分数就取最低分的评语称号
        }
        $array['content'] = $user_prize_about[1];
        $array['title'] = $user_prize_about[2];
        $array['time'] = date('Y年m月d日',strtotime($paper['create_time'])?:time());
        return $array;
    }
    
    /**
     * 生成证书
     * @param number $fid 试卷ID
     * @param array $data 试卷内容参数
     * @param number $fen 成绩分数
     * @return mixed|string 返回证书路径
     */
    protected function diploma($fid=0,$data=[],$fen=0){
    
    	if(empty($this->webdb['is_prize_open'])){
    		return false; //后台若没启用证书功能则直接退出
    	}
    	if(!$data){
    		$data = getArray(CategoryModel::get($fid));//如没传试卷参数进来泽根据试卷ID进行查询
    	}
    	
    	//试卷或模块设置的分数对应的评语和称号
    	$prize_about = $data['prize_about'] ? $data['prize_about'] : $this->webdb['prize_about'];
    	//试卷或模块设置的证书颁发机构署名
    	$prize_cop = $data['prize_cop'] ? $data['prize_cop'] : $this->webdb['prize_cop'];
    	
    	if(!$prize_about || !$prize_cop){
    		return false; //分数对应的评语称号和证书颁发机构署名都没则不生成证书
    	}
    	
    	//各分数对应的评语和称号处理
    	$prize_about_arr = explode("\r\n",$prize_about);
    	$prize_arr = $prize_arr2 = array();
    	foreach ($prize_about_arr AS $v){
    		if(!$v){
    			continue;
    		}
    		$prize_arr = explode('|',$v);
    		$prize_arr2[$prize_arr[0]]=$prize_arr;
    	}
    	krsort($prize_arr2);//分数由高到低排序
    	foreach($prize_arr2 AS $k=>$v){
    		if($fen>=$k){
    			$user_prize_about = $v;//考试得分所对应的评语称号
    			break;
    		}
    	}
    	if(!$user_prize_about){
    		$user_prize_about = end($prize_arr2);//上面没有符合分数就取最低分的评语称号
    	}
    	
   
    	//生成的证书存放目录
    	$new_file = config('upload_path') . DS . 'exam_urlcode' . DS . $fid . DS ;
    	if(!is_dir($new_file)) {
    		makepath($new_file); //目录不存在则创建
    	}
    	
    	
    	$this_dir = config('system_dirname');//模块目录名称
    	
    	//模块默认证书目录
    	$this_static_dir = PUBLIC_PATH."static/{$this_dir}/diploma/";
    	
    	$background_img = $this_static_dir.'diploma_bg.png';//默认证书背景图
    	$official_seal_img = $this_static_dir.'official_seal.gif';//默认公章
    	$minfont = $this_static_dir.'font/mnjmh.ttf';//小号字体
    	$maxfont = $this_static_dir.'font/mnhzgb.ttf';//大号字体
    	
    	
    	$diploma_name = $fid.'_'.$this->user['uid'].'_diploma.png'; //证书名
    	$diploma_url = $new_file.$diploma_name; //生成证书的完整路径

    	$return_path = str_replace(PUBLIC_PATH,'',$new_file).$diploma_name;//返回证书相对路径
  
    	if(file_exists($diploma_url)){
    		return $return_path;//证书已存在则直接返回证书路径
    	}
    	
    	//背景图
    	$image = Image::open($background_img);
    	
    	
    	//给背景图添加二维码水印
    	$qrcode_url = get_url( get_qrcode(urls('category/index',['fid'=>$fid,'p_uid'=>$this->user['uid']])) );//该试卷考试二维码网址
    	$qrcode_imgname = $this->user['uid'].'_'.$fid.'.png';//该试卷考试二维码网址图片名称
    	$exam_qrcode_img = $new_file.$qrcode_imgname;//该试卷考试二维码网址图片完整路径
    	copy($qrcode_url,$exam_qrcode_img);//把二维码复制下来
    	Image::open($exam_qrcode_img)->thumb(110, 110)->save($exam_qrcode_img);//生成110尺寸的二维码缩略图
    	$image->water($exam_qrcode_img,[68,265])->save($diploma_url);//给背景图添加二维码
    	unlink($exam_qrcode_img);//删除复制下来的二维码图片
    	
    	//给背景图添加用户头像
    	$user_icon = $this->user['icon'];
    	if($user_icon){
    		$new_usericon = $new_file.$this->user['uid'].'.png'; //新保存头像完整路径
    		$user_icon_url = tempdir($user_icon);
    		//把用户头像复制下来
    		if (copy($user_icon_url,$new_usericon) && getimagesize($new_usericon) ) {
    		    Image::open($new_usericon)->thumb(80, 80)->save($new_usericon);//缩小头像
    		    $image->water($new_usericon,[500,86])->save($diploma_url);//给背景图添加头像
    		    unlink($new_usericon);//删除复制下来的头像图片
    		}
    	}
    	
    	$diploma_usrname = $this->user['username'].' 同志'; //用户名
    	$diploma_descript = $user_prize_about[1]; 
    	//证书描述
    	$diploma_descript1 = get_word($diploma_descript,44,0);
    	$diploma_descript2 = get_word(str_replace($diploma_descript1, '', $diploma_descript),52,0);
    	
    	$diploma_title = get_word($user_prize_about[2],18,0); //证书称号
    	$diploma_companyname = $prize_cop; //证书颁发机构署名
    	$diploma_date = date('Y年m月d日',time()); //证书颁发日期
    	
    	$image->text($diploma_usrname,$minfont,16,'#020000',[68,160])->save($diploma_url);//给证书添加用户名水印
    	//给证书添加说明描述
    	$image->text($diploma_descript1,$minfont,16,'#3D3B2E',[128,188])->save($diploma_url);
    	$diploma_descript2 && $image->text($diploma_descript2,$minfont,16,'#3D3B2E',[60,215])->save($diploma_url);
    	
    	$image->text($diploma_title,$maxfont,30,'#EE0010',[230,250])->save($diploma_url);//给证书添加称号
    	$image->text($diploma_companyname,$minfont,12,'#3D3B2E',9,[-80,-100])->save($diploma_url);//给证书添加颁发机构署名
    	$image->text($diploma_date,$minfont,12,'#3D3B2E',9,[-80,-66])->save($diploma_url); //给证书添加日期
    	
    	//给证书添加公章
    	$image->water($official_seal_img,[461,300])->save($diploma_url);
    	
    	if(file_exists($diploma_url)){
    		return $return_path;//返回证书路径
    	}else{
    		return false;
    	}
    }
    
    
    /**
     * 对比答题与正确答案
     * @param number $fid
     * @param number $id
     * @return mixed|string
     */
    public function checkshow($fid=0,$aid=0)
    {
        $s_info = getArray(CategoryModel::get($fid));
        
        //获取内容数据
        $info = ContentModel::getInfoById($aid);
        
        $answerinfo=Answer::getInfo(['uid'=>$this->user['uid'],'paperid'=>$fid,'aid'=>$aid]);
        $info['answer1'] = $answerinfo['answer'];
        
        //统计已经进行到第几题
        $have_num = $this->have_exam($fid,$aid);
        
		$info['content'] = format_math($info['content']);
        //模板里要用到的变量值
        $vars = [
                'info'=>$info,
                'aid'=>$aid,
                'fid'=>$fid,
                's_info'=>$s_info,
                'have_num'=>$have_num,
        ];
        return $this->fetch('checkshow',$vars);
    }
    
    /**
     * 获取试卷中的下一道题
     * @param unknown $id
     * @return mixed|string
     */
    public function nextcheck($fid,$aid)
    {
        $next_aid = InfoModel::getNextAidByAid($aid,$fid);
        if (empty($next_aid)) {
            return $this->putinover($fid);
        }
        return $this->checkshow($fid,$next_aid);
    }
    
    /**
     * 获取试卷中的上一道题
     * @param unknown $id
     * @return mixed|string
     */
    public function pravcheck($fid,$aid)
    {
        $next_aid = InfoModel::getPravAidByAid($aid,$fid);
        if (empty($next_aid)) {
            return $this->putinover($fid);
        }
        return $this->checkshow($fid,$next_aid);
    }
    
    /**
     * 试卷打开介绍
     * @param unknown $id
     * @return mixed|string
     */
    public function open($fid=0){
        $s_info = getArray(CategoryModel::get($fid));
        $numbers = InfoModel::where(['cid'=>$fid])->count();
        $fenone = round(100/$numbers,2);
        $aid0 = InfoModel::where(['cid'=>$fid])->order('list DESC,id DESC')->value('aid');
        return $this->fetch('open',['s_info'=>$s_info,'fenone'=>$fenone,'fid'=>$fid,'numbers'=>$numbers,'aid0'=>$aid0]);
    }
}