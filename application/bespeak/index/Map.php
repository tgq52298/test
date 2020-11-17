<?php
namespace app\bespeak\index;
use app\common\controller\IndexBase;
use app\bespeak\model\Content;

class Map extends IndexBase
{
    public function index(){
        $id = input('id');
        $info = Content::getInfoByid($id,false);
        $type = 'map';
        if(in_weixin()){
            $type = 'wxmap';
            //百度转谷歌坐标,因为微信地图用的是谷歌坐标
            $obj  = new \app\common\util\MapGps();
            list($latitude,$longitude) = explode(',',$info['map']);
            $po = $obj->bd_decrypt($longitude, $latitude);
            $longitude = $po['lon'];
            $latitude = $po['lat'];
            $this->assign('x',$latitude);
            $this->assign('y',$longitude);
        }else{
            $strcode = file_get_contents("http://api.map.baidu.com/geoconv/v1/?coords=".$info['map']."&ak=MGdbmO6pP5Eg1hiPhpYB0IVd&from=5&to=6&output=json&qq-pf-to=pcqq.c2c");
            $data = json_decode($strcode);
            $result=$data->result;

            $mobilemap_x=$result[0]->x;
            $mobilemap_y=$result[0]->y;
            $this->assign('x',$mobilemap_x);
            $this->assign('y',$mobilemap_y);
        }
        $this->assign('info',$info);
        // $template = get_style_tpl($type,$this->info['style']);
        // return $this->fetch($template?:$type);
        return $this->fetch($type);
    }
}
