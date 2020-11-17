<?php
namespace app\exam\index;

use app\common\controller\IndexBase;
use plugins\fav\model\Fav AS FavModel;
use app\exam\model\Content AS ContentModel;

//收藏试题, 是试卷
class Fav extends IndexBase
{
    /**
     * 收藏夹汇总
     * @return mixed|string
     */
	public function index(){
	    if (empty(plugins_config('fav'))) {
	        $this->error('系统没有安装收藏夹');
	    }
	    return $this->fetch();
	}
	
	/**
	 * 显示收藏夹中的某道题
	 * @param number $aid
	 * @return mixed|string
	 */
	public function show($aid=0)
	{	    
	    //获取内容数据
	    $info = ContentModel::getInfoById($aid);
	    
	    //模板里要用到的变量值
	    $vars = [
	            'info'=>$info,
	            'aid'=>$aid,
	            'mid'=>$info['mid'],
	    ];
	    $template = getTemplate('show'.$this->mid) ?: getTemplate('show');
	    return $this->fetch($template,$vars);
	}
	
	/**
	 * 收藏夹中的下一道题
	 * @param number $aid
	 * @return mixed|string
	 */
	public function next($aid=0){
	    $sysid = modules_config(config('system_dirname'))['id'];
	    $map = [
	            'sysid'=>$sysid,
	            'aid'=>$aid,
	    ];
	    $_id = FavModel::where($map)->value('id');
	    $id = FavModel::where('sysid',$sysid)->where('id','<',$_id)->order('id desc')->value('aid');
	    if (empty($id)) {
	        $this->error('已经到尽头了','index');
	    }
	    return $this->show($id);
	}

}
