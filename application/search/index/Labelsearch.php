<?php
namespace app\search\index;
use think\Db;
class Labelsearch{
	/**
	 * 关键词标签调用
	 * @param array $tag_array
	 * @param int $page
	 * @return array|NULL[]|\unknown
	 * @throws \think\exception\DbException
	 */
	public static function Searchlist($tag_array=[],$page=0){
		$cfg=unserialize($tag_array['cfg']);
		$rows=$cfg['rows']?$cfg['rows']:5;
		$page=intval($page);
		if($page<1){
			$page=1;
		}
		$min=($page-1)*$rows;
		$order=$cfg['order']?$cfg['order']:'searchnums';
		$by=$cfg['by']?$cfg['by']:'desc';
		$data=[];
		$data=Db::name('search_keyword')->order($order,$by)->paginate($rows,false,['page'=>$page]);
		$array=getArray($data);
		foreach($array['data'] AS $key=>$rs){
			$array['data'][$key]=static::format_search($rs,$cfg,'');
		}
		return $array;
	}
	function format_search($info=[]){
		$info['title']=$info['keyword'];
		$info['url']=url('search/index/lists',['keyword'=>$info['keyword']],'html',true);
		$info['jsonurl']=url('search/api/index',['keyword'=>$info['keyword']],'html',true);
		return $info;
	}
	/**
	 * 搜索内容调用
	 * @param array $tag_array
	 * @param int $page
	 * @return array|NULL[]|\unknown
	 * @throws \think\exception\DbException
	 */
	public static function showlist($tag_array=[],$page=0){
		$cfg=unserialize($tag_array['cfg']);
		$rows=$cfg['rows']?$cfg['rows']:5;
		$page=intval($page);
		if($page<1){
			$page=1;
		}
		$min=($page-1)*$rows;
		$order=$cfg['order']?$cfg['order']:'id';
		$by=$cfg['by']?$cfg['by']:'desc';
		$data=[];
		$map=[];
		$cfg['data']=str_replace("　"," ",$cfg['data']);
		$cfg['data']=str_replace(","," ",$cfg['data']);
		$cfg['data']=str_replace("，"," ",$cfg['data']);
		$cfg['data']=str_replace("、"," ",$cfg['data']);
		$likeList=explode(' ',$cfg['data']);
		if(count($likeList)>1){
			foreach($likeList as $k=>$rs){
				$likeList[$k]="%{$rs}%";
			}
			$map['data']=['like',$likeList,'or'];
		}else{
			$map['data']=['like',"%{$cfg['data']}%"];
		}
		if(!empty($cfg['type'])){
			$map['module']=$cfg['type'];
		}
		$data=Db::name('search_content')->distinct(true)->field('aid,module,create_time,data')->where($map)->order($order,$by)->paginate($rows,false,['page'=>$page]);
		$array=getArray($data);
		foreach($array['data'] AS $key=>$rs){
			$array['data'][$key]=static::format_searchshow($rs,$cfg['data']);
		}
		return $array;
	}
	function format_searchshow($info=[],$keyword){
		$info['id']=$info['aid'];
		$info['title']=preg_replace("/($keyword)/i","<em>\\1</em>",static::get_search($info['data']));
		$info['des']=preg_replace("/($keyword)/i","<em>\\1</em>",static::get_search($info['data'],1));
		$info['create_time']=date("Y-m-d",$info['create_time']);
		$info['url']=url($info['module'].'/content/show',['id'=>$info['id']],'html',true);
		$info['picurl']=fun('Content@info',$info['id'],$info['module'])['picurl'];
		return $info;
	}
	function get_search($data,$num=0){
		$text=explode('####',$data);
		return $text[$num];
	}
}