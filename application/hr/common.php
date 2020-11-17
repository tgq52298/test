<?php

use think\Db;

if (!function_exists('get_hy_name')) {
    /**
     * 用于后续扩展
     * 获取黄页名称  
     * @param number $uid 用户UID
     * @param number $ext_id 扩展字段,关联的ID
     * @param number $ext_sys 扩展字段,关联的系统(模块ID)
     * @return string 显示名称
     */
    function get_hy_name($uid=0,$ext_id=0,$ext_sys=0){
	$hydb = get_hy_contents($mid=1,$map=['uid'=>$uid],$dirname='hy');
	if($hydb){
		$show_name = $hydb['title'];
	}else{
		$show_name = get_user_name($uid);
	}
	return $show_name;
    }

}

if (!function_exists('get_hy_url')) {
    /**
     * 用于后续扩展
     * 获取黄页链接
     * @param number $uid 用户UID
     * @param number $ext_id 扩展字段,关联的ID
     * @param number $ext_sys 扩展字段,关联的系统(模块ID)
     * @return string 显示名称
     */
    function get_hy_url($uid=0,$ext_id=0,$ext_sys=0){
	$hydb = get_hy_contents($mid=1,$map=['uid'=>$uid],$dirname='hy');
	if($hydb){
		$this_url=iurl("/hy/show",['id'=>$hydb['id']]);
	}else{
		$this_url=murl('member/user/index',['uid'=>$uid]);
	}
	return $this_url;
    }

}


if (!function_exists('get_hy_renzheng_logo')) {
    /**
     * 用于后续扩展
     * 获取黄页对应的认证等级图标
     * @param number $uid 用户UID
     * @param number $ext_id 扩展字段,关联的ID
     * @param number $ext_sys 扩展字段,关联的系统(模块ID)
     * @return string 显示名称
     */
    function get_hy_renzheng_logo($uid=0,$ext_id=0,$ext_sys=0){
	$hydb = get_hy_contents($mid=1,$map=['uid'=>$uid],$dirname='hy');
	if($hydb){
		$this_rzimg=tempdir($hydb['picurl']);
	}else{
		$this_rzimg=get_user_icon($uid);
	}
    	
	return $this_rzimg;
    }
}

if (!function_exists('get_hy_renzheng_grade')) {
    /**
     * 用于后续扩展
     * 获取黄页对应的认证等级图标
     * @param number $uid 用户UID
     * @param number $ext_id 扩展字段,关联的ID
     * @param number $ext_sys 扩展字段,关联的系统(模块ID)
     * @return string 显示名称
     */
    function get_hy_renzheng_grade($uid=0,$ext_id=0,$ext_sys=0){
	$this_user_grade = getGroupByid(get_user($uid)['groupid']);
	return $this_user_grade;
    }
}

if (!function_exists('get_apply_num')) {
    /**
     * 获取职位应聘人数
     * @param number $aid 职位ID
     * @return number 申请人数
     */
    function get_apply_num($aid){
	$table=config('system_dirname').'_apply';
	return Db::name($table)->where('aid','=',$aid)->count();
    }
}

if (!function_exists('fav_vita_num')) {
    /**
     * 获取简历被收藏次数
     * @param number $aid 简历ID
     * @return number 收藏次数
     */
    function fav_vita_num($aid){
    $table='fav';
    $sysid = M('id');
    $map=['sysid'=>$sysid,'aid'=>$aid];
    return Db::name($table)->where($map)->count();
    }
}

if (!function_exists('get_hy_contents')) {
    /**
     * 获取黄页店铺信息
     * @param number $aid 职位ID
     * @return number 申请人数
     */
    function get_hy_contents($mid=1,$map=[],$dirname='hy'){
        if(is_dir(APP_PATH.'hy')){
            $table=$dirname.'_content'.$mid;
            if(!$map){
                return false;
            }
            return Db::name($table)->where($map)->find();            
        }else{
            return false;
        }

    }
}


