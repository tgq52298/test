<?php
namespace app\yuyue\member;

use app\common\controller\MemberBase;
use app\common\traits\AddEditList;
use app\yuyue\model\Hexiao AS MemberModel;


class Hexiao extends MemberBase
{
    use AddEditList;
    protected $validate = '';
    protected $model;
    protected $form_items;
    protected $tab_ext;
    
    protected function _initialize()
    {
        parent::_initialize();
        $this->model = new MemberModel();
    }
    
    public function delete($ids=0){
        if (is_numeric($ids)) {
            $id_array[] = $ids;
        }else{
            $id_array = $ids;
        }
        foreach ($id_array AS $id){
            $uid = $this->model->where('id',$id)->value('uid');
            if ($uid==$this->user['uid']) {
                $this->model->destroy($id);
            }
        }
        $this->success('删除成功');
    }
    
    public function add($aid=0,$ad_id=0){
        if($this->request->isPost()){
            $data = $this->request->post();
            if (empty($data['username'])) {
                $this->error('帐号不能为空');
            }elseif ($data['username']==$this->user['username']) {
                $this->error('不能添加自己的帐号');
            }
            $reslt = get_user($data['username'],'username');
            if (empty($reslt)) {
                $this->error('帐号不存在');
            }elseif($this->model->where('hxuid',$reslt['uid'])->find()){
                $this->error('请不要重复添加');
            }
            $array = [
                    'uid'=>$this->user['uid'],
                    'hxuid'=>$reslt['uid'],
            ];
            $reslt = $this->model->create($array);
            if ($reslt) {
                $this->success('添加成功','index');
            }else{
                $this->success('添加失败');
            }
        }
        $this->form_items = [
                ['text', 'username', '用户帐号', '添加已经注册好的帐号,才有核销订单权限'],
        ];
        return $this->addContent();
    }
    
    
    public function index($type=''){
        $this->list_items = [
                ['hxuid','核销帐号','username'],
        ];
        $this->tab_ext['top_button'] = [
            ['type'=>'add','title'=>'添加核销帐号']
        ];
        $this->tab_ext['right_button'] = [
                ['type'=>'delete']
        ];
        $data_list= $this->model->where('uid',$this->user['uid'])->order("id desc")->paginate(15);
        $this->tab_ext['page_title'] = '多人核销帐号管理';
        return $this->getMemberTable($data_list);
    }
    

}
