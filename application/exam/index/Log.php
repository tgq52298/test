<?php
namespace app\exam\index;

use app\common\controller\IndexBase;
use app\exam\model\Answer;
use app\exam\model\Content AS ContentModel;

//错题记录
class Log extends IndexBase
{
    protected function _initialize(){
        parent::_initialize();
        if (empty($this->user)) {
            $this->error('你还没登录!');
        }
    }
    
    /**
     * 错题集
     * @return mixed|string
     */
	public function index(){
	    return $this->fetch();
	}
	
	
	/**
	 * 查看错题 记录ID,不是试题ID
	 * @param number $id
	 * @param string $type
	 * @return mixed|string
	 */
	public function view($id=0,$type='next')
	{
	    if ($type=='prev') {
	        $answerinfo = Answer::get_prev($id,$this->user['uid'],['is_true'=>-1]);     //上一道用户的答题
	    }elseif($type=='next'){
	        $answerinfo = Answer::get_next($id,$this->user['uid'],['is_true'=>-1]);     //下一道用户的答题
	    }else{
	        $answerinfo = Answer::get($id);
	    }
	    
	    if (empty($answerinfo)) {
	        $this->error('已经到尽头了!','index');
	    }
	    
	    $info = ContentModel::getInfoById($answerinfo['aid']);     //原试题
	    
	    $info['answer1'] = $answerinfo['answer'];
	    
	    //模板里要用到的变量值
	    $vars = [
	            'info'=>$info,
	            'id'=>$answerinfo['id'],
	    ];
	    return $this->fetch('view',$vars);
	}
	
	/**
	 * 重做错题
	 * @param number $id 记录ID,不是试题ID
	 * @param string $type
	 * @return mixed|string
	 */
	public function redo($id=0,$type='next')
	{
	    if ($type=='prev') {
	        $answerinfo = Answer::get_prev($id,$this->user['uid'],['is_true'=>-1]);     //上一道用户的答题
	    }else{
	        $answerinfo = Answer::get_next($id,$this->user['uid'],['is_true'=>-1]);     //下一道用户的答题
	    }
	    
	    if (empty($answerinfo)) {
	        $this->error('已经到尽头了!','index');
	    }
	    
	    $info = ContentModel::getInfoById($answerinfo['aid']);     //原试题
	    
	    $info['answer1'] = $answerinfo['answer'];
	    
	    //模板里要用到的变量值
	    $vars = [
	            'info'=>$info,
	            'id'=>$answerinfo['id'],
	    ];
	    return $this->fetch('redo',$vars);
	}
	
	
 
	
}
