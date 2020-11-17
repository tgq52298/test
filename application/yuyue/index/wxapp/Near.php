<?php
namespace app\yuyue\index\wxapp;

use app\common\controller\index\wxapp\Index AS _Index; 

//附近的
class Near extends _Index
{

    public function index($point='100,20',$rows=10,$fid=0){
        $map = [
            'status'=>['>',0]
        ];
        if ($fid>0) {
            $map['fid'] = ['in',get_sort($fid,'sons')];
            $this->mid = $this->model->getMidByFid($fid);
        }
        $array = getArray( $this->model->getListByMap($this->mid,$map,$point,$rows) );
        foreach($array['data'] AS $key => $rs){
            $rs['create_time'] = date('Y-m-d H:i',$rs['create_time']);
            $rs['_province'] = $rs['province_id']?fun('area@get',$rs['province_id']):'';
            $rs['_city'] = $rs['city_id']?fun('area@get',$rs['city_id']):'';
            $rs['_zone'] = $rs['zone_id']?fun('area@get',$rs['zone_id']):'';
            $rs['_street'] = $rs['street_id']?fun('area@get',$rs['street_id']):'';
            $array['data'][$key] = $rs;
        }
        
        return $this->ok_js($array); 
    }

}













