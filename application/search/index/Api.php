<?php
namespace app\search\index;
use app\common\controller\IndexBase;
use think\Db;
class Api extends IndexBase{
	/**
	 * 关键词搜索json输出
	 * @param string $keyword 关键词
	 * @param string $type    模块目录名例如：cms 为空就是全部
	 * @param int $rows       每页读取的数量 默认20条
	 * @param int $page       当前页码
	 * @return array|\think\response\Json|void
	 */
	public function index($keyword='',$type='',$rows=20,$page=0){
		$keyword=filtrate($keyword);
		if(empty($keyword)){
			return $this->err_js('关键词不能为空');
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
		$resou=Db::name('search_keyword')->order('searchnums desc')->limit(30)->select();
		$datalist=\app\search\index\Labelsearch::showlist([
			'cfg'=>serialize([
				'data'=>$keyword,
				'type'=>$type,
				'rows'=>$rows
			])
		],$page);
		if($datalist['total']==0){
			return $this->err_js('暂无结果');
		}
		return $this->ok_js($datalist);
	}
	/**
	 * 热搜词调用
	 * @param int $rows 数量
	 * @param int $page 页码
	 * @return array|\think\response\Json|void
	 */
	public function resou($rows=30,$page=0){
		$resou=\app\search\index\Labelsearch::Searchlist([
			'cfg'=>serialize([
				'rows'=>$rows
			])
		],$page);
		return $this->ok_js($resou);
	}
}
