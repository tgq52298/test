<?php
namespace app\exam\index;

use app\common\controller\index\Category AS _Category;

//试卷
class Category extends _Category
{
    /**
     * 指定的试卷展示所有的试题
     * {@inheritDoc}
     * @see \app\common\controller\index\Category::index()
     */
    public function index($fid)
    {
        if(!$fid){
            $this->error('参数有误！');
        }
        if(!$this->user){
        	$this->error('请先登录,登陆后才可进入考试页面');
        }
        //获取列表数据
        //$data_list = $this->getListData(['cid'=>$fid]);
        
        //模板里要用到的变量值
        $vars = [
                //'listdb'=>$data_list,
                'fid'=>$fid,
                'info'=>$this->model->getInfoById($fid),
                //'pages'=>$data_list->render()
        ];
        
        $template = getTemplate('index');
   
        return $this->fetch($template,$vars);
    }
}













