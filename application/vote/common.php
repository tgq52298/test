<?php 
// use app\common\model\Module;
use think\Db;

if (!function_exists('get_option_ranking')) {
    /**
     * 获取投票选项当前排名
     * @param number $mid 模型ID
     * @param number $id 选项ID
     * @return number 当前排名
     */
    function get_option_ranking($mid=1,$id=0){
	$table=config('system_dirname').'_content'.$mid;
	$this_contentdb = Db::name($table)->where('id',$id)->find();
	$this_result = Db::name($table)->where('agree','>',$this_contentdb['agree'])->count();
	$option_ranking=$this_result+1;
	return $option_ranking;
    }
}



if (!function_exists('get_users_vote')) {
    /**
     * 获取用户投票记录
     * @param number $fid 投票项目ID
     * @param number $aid 投票选项ID
     * @param number $row 数据条数
     */
    function get_users_vote($fid,$aid,$row=10,$order='id',$by='DESC'){
        $table=config('system_dirname').'_member';
        $user_votes = Db::name($table)->where(['fid'=>$fid,'aid'=>$aid])->order($order,$by)->limit($row)->select();
        foreach ($user_votes AS $v){
            $v['show_time'] = date('Y-m-d H:i:s',$v['create_time']);
            $v['username'] = get_user_name($v['uid']);
            $v['icon'] = get_user_icon($v['uid']);
            $data[] = $v;
        }
        $result[data] = $data;
        return $result;
    }
}