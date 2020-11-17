<?php
namespace app\yuyue\index;

use app\common\controller\IndexBase;
use app\yuyue\model\Content;

//
class Api extends IndexBase
{
	public function check_buy($id=0){	    
	    $info = Content::getInfoByid($id);
	    $result = check_buytime($info);
	    if ($result!==true){
	        return $this->err_js($result);
	    }elseif ($info['max_user'] && $info['stocktype']!=2 && $info['fewnum']>=$info['max_user']){
	        return $this->err_js('已经满人了');
	    }
	    if (empty($this->user)){
	        return $this->err_js('你还没有登录');
	    }
	}
	
}
