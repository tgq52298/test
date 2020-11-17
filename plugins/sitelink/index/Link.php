<?php
namespace plugins\sitelink\index;
use think\Db;
class Link{
	public function cmsContentShow(&$data){
		$Keywords=Db::name('sitelink_content')->where('status',1)->select();
		foreach($Keywords as $v){
			$word1='/((?<!<))' . preg_quote($v['name'], '/') . '(?![^<>]*(?:>|<\/a>))/';
			$replacement='<a href="'.$v['link'].'" target="_blank" class="keylink">'.$v['name'].'</a>';
			if($v['num']){
				$data['content']=preg_replace($word1,$replacement,$data['content'],$v['num']);
			}else{
				$data['content']=preg_replace($word1,$replacement,$data['content']);
			}
		}
	}
}