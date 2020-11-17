<?php
namespace app\qun\index\wxapp;

use app\common\controller\index\wxapp\Index AS _Index; 

//附近的
class Near extends _Index
{
    /**
     * 查询数据,按距离排序
     * {@inheritDoc}
     * @see \app\common\controller\index\wxapp\Index::index()
     */
    public function index($point='100,20',$rows=10,$fid=0,$mid=0){
        $map = [];
        if ($fid>0) {
            $map['fid'] = ['in',get_sort($fid,'sons')];
            $this->mid = $this->model->getMidByFid($fid);
        }elseif($mid && model_config($mid)){
            $this->mid = $mid;
        }else{
            $this->mid = 1;
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
    
    /**
     * 计算两地距离
     * @param string $point
     * @param string $destinations
     * @return string
     */
    public function distance($point='100,20',$destinations='100,20'){
        list($latitude,$longitude)=explode(',',$point);//起始地
        list($latitude2,$longitude2)=explode(',',$destinations);//起始地
        $strcode=file_get_contents("http://api.map.baidu.com/routematrix/v2/driving?output=json&tactics=11&origins=$longitude,$latitude&destinations=$longitude2,$latitude2&ak=MGdbmO6pP5Eg1hiPhpYB0IVd");
        $data=json_decode($strcode,true);
        if($data['status']<1){
            $distance='距离约：'.$data['result']['0']['distance']['text'];
        }else{
            $distance="未知距离";
        }
        return $distance;
    }

}













