<?php
namespace plugins\form\index;

use app\common\controller\index\C; 
use plugins\form\traits\Content AS TraitsContent;

class Content extends C
{
    use TraitsContent;
    /**
     * 万能表单,内容前台展示页
     * {@inheritDoc}
     * @see \app\common\controller\index\C::show()
     */
    public function show($id=0){
        return parent::show($id);
    }
    
    protected function view_check($info=[]){
        if ( empty($this->user) && empty($this->webdb['allow_guest_view']) ) {            
            $this->error('系统设置游客不能访问详情!');
        }
        if ($info['uid']!=$this->user['uid'] && !in_array($this->user['uid'], explode(',',str_replace('，', ',', $this->webdb['post_form_kefu_uid']))) && empty($this->admin)) {
            $this->error('你无权查看他人的信息!');
        }
        parent::view_check($info);
    }
    
    /**
     * 前台发布页
     * {@inheritDoc}
     * @see \app\common\controller\index\C::add()
     */
    public function add($mid=0){
        if(!$mid){
            $this->error('参数不存在！');
        }
        $this->mid = $mid;
        $m = model_config($mid);
        if (empty($m)) {
            $this->error('模型不存在！');
        }
        
        if ( $this->request->isPost() ) {
            $data = $this->request->post();
            $result=$this->add_check($mid,$data['fid'],$data);
            
            if ($result!==true) {
                $this->error($result);
            }
            unset($data['id']);
            $data['uid'] = intval($this->user['uid']);
            $data = $this->format_post_data($data);
            
            $id = $this->model->addData($mid,$data);
            
            if(is_numeric($id)){
                $this->send_form_msg($id,$data);
                //$this->end_add($id,$data);
                $url = purl('content/show',['id'=>$id]);
                $this->success('提交成功',$url);
            }else{
                $this->error('添加内容失败,详情如下:'.$id);
            }
        }
        
        $tab_ext['page_title'] = $m['title'];
        $this->assign('tab_ext',$tab_ext);
        $this->assign('mid',$mid);
        $this->assign('info',input());  //方便地址栏赋值
        return $this->fetch('add');
    }
    
    public function index(){        
    }
    
    public function edit(){        
    }
}
