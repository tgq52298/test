<?php
namespace app\bbs\index\wxapp;

//use app\common\controller\IndexBase;
use app\common\controller\index\wxapp\Index AS _Index;
use app\bbs\model\Content AS ContentModel;
use think\Db;

//小程序显示内容
class Index extends _Index
{
    /**
     * 列表数据
     * @param number $type
     * @return \think\response\Json
     */
    public function index($fid=0,$type='',$rows=5,$notfid=''){
        $map = [
            'status'=>['>',0],            
        ];
        if ($notfid!='') {
            $detail = explode(',', $notfid);
            foreach ($detail AS $key=>$value){
                if (!is_numeric($value)) {
                    unset($detail[$key]);
                }
            }
            $map = [
                'fid'=>['not in',implode(',', $detail)],
            ];
        }
        $mid = $fid ? (get_sort($fid,'mid')?:1) : 1;
        $fid && $map['fid'] = $fid;
        $order = 'id desc';
        if($type=='star'){
            $map['status'] = ['>',1];
        }elseif($type=='hot'){
            $order = 'view desc';
        }elseif($type=='new'){
            $order = 'id desc';
        }elseif($type=='reply'){
            $order = 'list desc';
        }
        
        $array = getArray( ContentModel::getListByMid($mid,$map,$order,$rows) );
        foreach($array['data'] AS $key => $rs){
            unset($rs['sncode']);
            //$rs['content'] = Db::name(ContentModel::getContentsTable())->where('id',$rs['id'])->value('content');
            $rs['picurls'] = $rs['picurls']?:fun('content@get_images',$rs['full_content']?:$rs['content']);
            //$rs['content'] = del_html($rs['_content']=$rs['content']); 
            $rs['create_time'] = date('Y-m-d H:i',$rs['create_time']);
            $rs['update_time'] = format_time($rs['update_time'],true);
            $user = get_user($rs['uid']);
            $rs['user_name'] = $user['username'];
            //$rs['user_icon'] = tempdir($user['icon']);
            //$rs['user_url'] = get_url('user',$rs['uid']);
            $array['data'][$key] = $rs;
        }
        
        return $this->ok_js($array); 
    }

}













