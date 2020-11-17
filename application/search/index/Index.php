<?php
namespace app\search\index;
use app\common\controller\IndexBase;
use think\Db;
use think\Request;
class Index extends IndexBase{
	/**
	 * 搜索首页
	 * @return mixed
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function index(){
		$resou=Db::name('search_keyword')->order('searchnums desc')->limit(30)->select();
		return $this->fetch('',['resou'=>$resou]);
	}
	/**
	 * 列表显示
	 * @param string $keyword 关键词
	 * @param int $page 分页码
	 * @param string $wap 手机版下一页区分
	 * @param string $type 模块化搜索
	 * @return mixed|string
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function lists($keyword='',$type=''){
		$keyword=filtrate($keyword);
		if(empty($keyword)){
			$this->error('关键词不能为空！');
		}
		$map=[];
		$keyword=str_replace("　"," ",$keyword);
		$keyword=str_replace(","," ",$keyword);
		$keyword=str_replace("，"," ",$keyword);
		$keyword=str_replace("、"," ",$keyword);
		$likeList=explode(' ',$keyword);
		if(count($likeList)>1){
			foreach($likeList as $k=>$rs){
				$likeList[$k]="%{$rs}%";
			}
			$map['data']=['like',$likeList,'or'];
		}else{
			$map['data']=['like',"%{$keyword}%"];
		}
		$this->get_hook('search_begin',$map);
		$res=Db::name('search_keyword')->where('keyword',$keyword)->count();
		if($res){
			Db::name('search_keyword')->where('keyword',$keyword)->setInc('searchnums');
		}else{
			if(isset($keyword{2})){
				$datakey=['keyword'=>$keyword,'searchnums'=>1];
				Db::name('search_keyword')->insert($datakey);
			}
		}
		$model=explode(',',config("webdb.M__search")['search_model']);
		 foreach($model as $k=>$rs){
			 	$modellist[$k]['type']=$rs;
				$modellist[$k]['title']=modules_config($rs)['name'];
			}
		$resou=Db::name('search_keyword')->order('searchnums desc')->limit(30)->select();
		return $this->fetch('',['resou'=>$resou,'keyword'=>$keyword,'type'=>$type,'modellist'=>$modellist]);
	}
}
