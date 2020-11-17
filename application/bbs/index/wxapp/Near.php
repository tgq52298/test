<?php
namespace app\bbs\index\wxapp;

use app\common\controller\IndexBase;
use app\bbs\model\Content AS ContentModel;
use think\Db;

//附近的
class Near extends IndexBase
{
    /**
     * 动态查询数据
     * @param string $point 用户当前坐标
     * @param number $rows 取多少条
     * @param number $range 
     * @param number $fid
     * @param number $mid
     * @return void|unknown|\think\response\Json
     */
    public function index($point='100,20',$rows=10,$range=200,$fid=0,$mid=0){
        $map = ['status'=>['>',0]];
        if ($fid>0) {
            $map['fid'] = ['in',get_sort($fid,'sons')];
        }
        if($mid && !model_config($mid)){
            return $this->err_js('mid参数有误');
        }else{
            $mid = 1;
        }
        
        $array = getArray( ContentModel::getListByMid($mid,$map,'id desc',$rows) );
        foreach($array['data'] AS $key => $rs){
            $rs['content'] = Db::name(ContentModel::getContentsTable())->where('id',$rs['id'])->value('content');
            $rs['picurls'] = $rs['picurls']?:fun('content@get_images',$rs['content']);
            $rs['create_time'] = date('Y-m-d H:i',$rs['create_time']);
            $rs['user_name'] = get_user_name($rs['uid']);
            $rs['user_icon'] = get_user_icon($rs['uid']);            
            $rs['content'] = del_html($rs['_content']=$rs['content']); 
            $array['data'][$key] = $rs;
        }
        
        return $this->ok_js($array); 
    }

}













