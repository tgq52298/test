<?php
namespace plugins\form\index;

use app\common\controller\IndexBase; 
use plugins\form\model\Content AS ContentModel;

class Quote extends IndexBase
{
    /**
     * 根据用户UID获取其相应的数据
     * @param number $uid
     * @param number $mid
     * @param number $rows
     * @return void|unknown|\think\response\Json
     */
    public function listbyuid($uid=0,$mid=0,$rows=20,$keyword=''){
        $array = [];
        $data = model_config();
        foreach($data AS $rs){
            $array[] = [
                'title'=>$rs['title'],
                'mid'=>$rs['id'],
                'id'=>0,
                'picurl'=>'',
                'content'=>'',
                'time'=>'',
                'url'=>purl('content/add',['mid'=>$rs['id']],'index'),
            ];
        }
        return $this->ok_js($array);
    }
}