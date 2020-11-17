<?php
namespace plugins\form\member;

use app\common\controller\member\C;
use plugins\form\traits\Content AS TraitsContent;

class Content extends C
{
    use TraitsContent;
    
    /**
     * 发布信息
     * {@inheritDoc}
     * @see \app\common\controller\member\C::add()
     */
    public function add($mid=0){
        return parent::add(0,$mid);
    }
    
    /**
     * 修改信息
     * {@inheritDoc}
     * @see \app\common\controller\member\C::edit()
     */
    public function edit($id){
        return parent::edit($id);
    }
    
    /**
     * 信息列表
     * {@inheritDoc}
     * @see \app\common\controller\member\C::index()
     */
    public function index($mid=0){
        return parent::index(0,$mid);
    }
    
    /**
     * 新发表成功后执行的方法
     * @param number $id
     * @param array $data
     */
    protected function end_add($id=0,$data=[]){
        parent::end_add($id,$data);
        $this->send_form_msg($id,$data);
    }
    
	
}
