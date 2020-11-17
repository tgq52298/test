<?php
namespace app\search\hook;
use think\Db;
class Add{
	/**
	 * 新增数据行为调用
	 * @param int $id 信息id
	 * @param array $data 信息内容和模块
	 */
	public function cmsAddEnd($id=0,$data=[]){
		if(strpos(config('webdb.M__search')['search_model'],request()->module())!==false){
		$des=get_word(str_replace(["\r\n","\t",'&ldquo;','&rdquo;','&nbsp;'],'',strip_tags($data['data']['content'])),config('webdb.search_word_leng')?:250);
		$data['module'] || $data['module'] = request()->module();
		$uid = $data['data']['uid'] ?: intval(login_user('uid')) ;
		$datas=['aid'=>$id,'uid'=>$uid,'create_time'=>time(),'module'=>$data['module'],'data'=>$data['data']['title'].'####'.$des];
		Db::name('search_content')->insert($datas);
	}
}
	/**
	 * 编辑信息行为调用
	 * @param array $data 编辑后的数据
	 * @param array $result 返回状态和模块
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function cmsEditEnd($data=[],$result=[]){
		 
		if(strpos(config('webdb.M__search')['search_model'],$result['module'])!==false){
			
		$res=Db::name('search_content')->where('aid',$data['id'])->where('module',$result['module'])->count();
		$des=get_word(str_replace(["\r\n","\t",'&ldquo;','&rdquo;','&nbsp;'],'',strip_tags($data['content'])),config('webdb.search_word_leng')?:250);
		if($res){
			Db::name('search_content')->where('aid',$data['id'])->where('module',$result['module'])->update(['data'=>$data['title'].'####'.$des]);
		}else{
			$datas=['aid'=>$data['id'],'create_time'=>time(),'module'=>$result['module'],'data'=>$data['title'].'####'.$des];
			Db::name('search_content')->insert($datas);
		}
	}
	}

	/**
	 * 删除信息
	 * @param $info 信息数组
	 * @param $module 模块
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function cmsDeleteEnd($info,$module){
		if(strpos(config('webdb.M__search')['search_model'],$module)!==false){
		Db::name('search_content')->where('aid',is_array($info)?$info['id']:$info)->where('module',$module)->delete();
	}
		}
}