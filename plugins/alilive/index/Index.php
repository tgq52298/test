<?php
namespace plugins\alilive\index;

use app\common\controller\IndexBase;
use plugins\alilive\model\Log AS LogModel;

class Index extends IndexBase
{
    /**
     * 标签调用
     * @param array $tag_array
     */
    public function label($tag_array=[]){
        $cfg = unserialize($tag_array['cfg']);
        $rows = $cfg['rows']?:10;
        $map = [
            'ext_id'=>['>',0],
            'create_time'=>['>',time()-3600*2],
            'end_time'=>0
        ];
        $array = LogModel::where($map)->order('id desc')->paginate($rows);
        $listdb = [];
        foreach($array AS $rs){
            if (!fun('Qun@live',$rs['ext_id'],'live_video')) {
                LogModel::where('id',$rs['id'])->update(['end_time'=>time()]);
                couninue;
            }
            $listdb[] = array_merge(
                fun('qun@getByid',$rs['ext_id']),
                ['start_time'=>$rs['create_time']]
                );
        }
        return $listdb;
    }
    
    /**
     * 直播状态
     * @return void|unknown|\think\response\Json
     */
    public function status(){
        $map = [
            'ext_id'=>['>',0],
            'create_time'=>['>',time()-3600*6],
            'end_time'=>0
        ];
        $array = LogModel::where($map)->order('id desc')->limit(20)->column(true);
        $listdb = [];//fun('qun@getByid',$rs['ext_id'])
        foreach($array AS $rs){
            unset($rs['push_url']);
            $rs['id'] = $rs['ext_id'];
            $listdb[$rs['id']] = $rs;
        }
        return $this->ok_js($listdb);
    }
}
