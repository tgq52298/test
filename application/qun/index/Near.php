<?php
namespace app\qun\index;

use app\common\controller\index\C; 

//附近的圈子
class Near extends C
{
	public function index($type='',$fid=0){
	    $this->assign('type',$type);
	    $this->assign('fid',$fid);
	    if (empty(in_weixin())||$type=='mp') {
	        $tpl = 'index';
	    }elseif($type=='wxapp'){
	        $tpl = 'wxapp';
	    }else{
	        $tpl = 'choose';
	    }
	    return $this->fetch($tpl);
	}
	
	public function point_address($x='23.1200491',$y='113.30764968'){
	    $string = file_get_contents('http://api.map.baidu.com/geocoder/v2/?callback=renderReverse&location='.$x.','.$y.'&output=xml&pois=1&ak=MGdbmO6pP5Eg1hiPhpYB0IVd');
	    $postObj = simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA);
	    $jsonStr = json_encode($postObj);
	    $jsonArray = json_decode($jsonStr,true);
	    $address = $jsonArray['result']['formatted_address'];
	    return $this->ok_js($address);
	}
	
}
