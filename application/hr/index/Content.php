<?php
namespace app\hr\index;

use app\common\controller\index\C; 


//内容页与列表页
class Content extends C
{
	
	/**
	 * 列表页
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::index()
	 */
	public function index($fid=0,$mid=0){
	    return parent::index($fid,$mid);
	}
	
	/**
	 * 内容详情页
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::show()
	 */
	public function show($id){
	    // return parent::show($id);
       $this->mid = $this->model->getMidById($id);
        
        if(empty($this->mid)){
            $this->error('内容不存在!');
        }
        
        //获取内容数据
        $info = $this->getInfoData($id);
        
        Hook_listen('cms_content_show',$info,$this->user);
        
        $this->view_check($info);   //访问权限检查
        $this->updateView($id);     //更新浏览量

        $info['field_array'] = $this->get_field_fullurl($info);     //这行必须放在 format_field 的前面,这里要用到原始数据
        $info = fun('field@format',$info,'','show');
        
        //下面代码主要是避免 format_field 函数里边强行把picurl输出<img 这样的内容,导致无法对图片做个性显示
        if($info['field_array']['pics']['value']){  //CMS图库特别处理
            $info['picurls'] = $info['field_array']['pics']['value'];
            $info['picurl'] = $info['field_array']['pics']['value'][0]['picurl'];
        }else{
            $_picurl = $info['field_array']['picurl']['value'];
            if(is_array($_picurl)){
                $info['picurl'] = $_picurl[0]['picurl'];
                $info['picurls'] = $_picurl;
            }else{
                $info['picurl'] = $_picurl;
            }
        }
        
        
         $GLOBALS['fid'] = $info['fid'];     //标签有时会用到
        
        //栏目配置信息
        $s_info = $this->sortInfo($info['fid']);
        // $from='member';
        //如果某个模型有个性模板的话，就不调用母模板
        $template = $this->get_tpl('show',$this->mid,$s_info);
  
        // 会员中心查看简历时用到指定模板
        if($info['mid']==2&&input('from')=='member'){
        	$template='showvita';
        }
        // echo $template;
        //$field_db = $this->getEasyFormItems();     //自定义字段
        
        //模板里要用到的变量值
        $vars = [
                'info'=>$info,
                'id'=>$id,
                'fid'=>$info['fid'],
                'mid'=>$info['mid'],
                'listdb'=>$info['picurls'],
                's_info'=>$s_info,
        ];
        // echo M('id');
        // print_r($info);
        // echo $template;
        return $this->fetch($template,$vars);
	}
	
    /**
     * 申请职位
     * @param number $id 职位ID
     * @param number $mid 简历模型ID
     * @return void|array|\think\db\false|PDOStatement|string|\think\Model
     */
    public function applyJob($id=0,$mid=2){
	    if (!$this->user) {
	        return $this->err_js('请先登录!');
	    }
	     $job_info = $this->getInfoData($id);
	     if(!$job_info){
	     	return $this->err_js('查询不到该职位数据，请刷新页面后操作！');
	     }

	     $ck_apply = $this->model->getApplyInfo($job_info['id']);
	     if($ck_apply){
	     	return $this->err_js('你已申请过该职位，请不要重复申请!');
	     }

	     $ck_vita = $this->model->getVitaInfo($mid);
	     if(!$ck_vita){
	     	return $this->err_js('你的简历不存在，无法进行申请操作，请进入会员中心更新简历后再进行申请操作');
	     }
	    $data = ['aid' => $id, 'jid' => $ck_vita['id'], 'uid' => $this->user['uid'], 'cuid' => $job_info['uid'], 'create_time' => time()];
	    $insertid = $this->model->addApply($data);
	    if($insertid){
	    	return $this->ok_js('申请成功');
	    }else{
	    	return $this->err_js('申请失败，可尝试刷新页面后再进行操作');
	    }
    }


}
