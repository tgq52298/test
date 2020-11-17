<?php
namespace plugins\links\index;
use app\common\controller\IndexBase;
use plugins\links\model\Links;
class Link extends IndexBase{
	/**
	 * 友情链接标签调用
	 * @param $tagArray
	 * @param int $page
	 * @return \think\Paginator
	 * @throws \think\exception\DbException
	 */
	public function labelShow($tagArray,$page=0){
		$map=[];
		$cfg=unserialize($tagArray['cfg']);
		$cfg['rows']||$cfg['rows']=10;
		$cfg['order']||$cfg['order']='id';
		$cfg['by']||$cfg['by']='desc';
		$page=intval($page);
		if($page<1){
			$page=1;
		}
		$min=($page-1)*$cfg['rows'];
		if($cfg['where']){
			$_array=label_format_where($cfg['where']);
			if($_array){
				$map=array_merge($map,$_array);
			}
		}
		$array=Links::where($map)->order($cfg['order'],$cfg['by'])->limit($min,$cfg['rows'])->paginate($cfg['rows'],false,['page'=>$page]);
		$array->each(function($rs,$key){
			$rs['title']=$rs['name'];
			$rs['picurl']=tempdir($rs['image']);
			$rs['url']=$rs['link'];
			return $rs;
		});
		return $array;
	}
}