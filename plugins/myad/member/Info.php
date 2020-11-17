<?php
namespace plugins\myad\member;

use app\common\controller\MemberBase;
use app\common\traits\AddEditList;
use plugins\myad\model\Info as InfoModel;

class Info extends MemberBase
{
    use AddEditList;
    protected $validate = '';
    protected $model;
    protected $form_items = [];
    protected $list_items;
    protected $tab_ext = [
            'page_title'=>'广告管理',
            'top_button'=>[
                    [
                            'type'=>'add',
                            'title'=>'申请广告',
                    ],
            ],
    ];
    
    protected function _initialize(){
        parent::_initialize();
        $this->model = new InfoModel();
    }
    
    public function index($type=0) {
        $this->list_items = [
            ['title', '广告名称', 'text'],
            ['status', '审核与否', 'yesno'],
            ['picurl', '图片', 'callback',function($k,$rs){
                if($rs['picurl']==''){
                    return '';
                }
                $url = tempdir($rs['picurl']);
                return <<<EOT
<a href="$url" target="_blank"><img src="$url" width="80"></a>
EOT;
            }],
            ['begin_time', '开始时间', 'datetime'],
            ['end_time', '结束时间', 'datetime'],
        ];
        
        $map = [
            'uid'=>$this->user['uid'],
        ];
        $order = 'id desc';
        
        $this->tab_ext['right_button'] = [
                ['type'=>'delete'],
                ['type'=>'edit']
        ];
        
        return $this -> getMemberTable(self::getListData($map, $order ));
    }
    
    
    private function make_form(){
        return [
            ['radio','fid','广告位置','',str_array($this->webdb['ad_place'])],
            ['text','title','广告名称'],
            ['radio','type','广告类型','',['文字广告','单图广告','多图广告']],
            ['image','picurl','单图'],
            ['images','picurls','多图'],
            ['textarea','about','广告介绍',''],
            ['text','url','网址','http://或https://开头'],
            ['datetime','begin_time','广告开始时间',''],
            ['datetime','end_time','广告结束时间',''],
        ];
    }
    
    public function add(){
        if (!$this->webdb['is_allow_add']) {
            $this->error('系统设置,当前禁止申请');
        }
        if ($this -> request -> isPost()) { //处理提交的数据
            $data = $this->request->post();
            if (!$data['name']) {
                $this->error('广告名称不能为空');
            }
            $data['end_time'] && $data['end_time'] = strtotime($data['end_time']);
            $data['begin_time'] && $data['begin_time'] = strtotime($data['begin_time']);
            $data['uid'] = $this->user['uid'];
            $result = $this -> model -> create($data);
            if ($result) {
                $this->success('增加成功','index');
            }else{
                $this->error('增加失败 ');
            }
        }
        $this->form_items =  $this->make_form();
        $this->tab_ext['trigger'] = [
            ['type','1','picurl'],
            ['type','2','picurls'],
        ];
        return $this->addContent();
    }
    
    public function edit($id=0){
        
        if ($this -> request -> isPost()) {     //处理提交的数据
            $data = $this -> request -> post();
            $data['end_time'] && $data['end_time'] = strtotime($data['end_time']);
            $data['begin_time'] && $data['begin_time'] = strtotime($data['begin_time']);
            if ($this -> model -> update($data)) {
                $this->success('修改成功','index');
            } else {
                $this->error('修改失败 ');
            }
        }
        
        $this->form_items = $this->make_form();
        $info = $this->model->get($id);
        $this->tab_ext['trigger'] = [
            ['type','1','picurl'],
            ['type','2','picurls'],
        ];
        return $this->editContent($info);
    }
    
    public function delete($ids=0){
        $info = $this->model->get($ids);
        if (empty($info)) {
            $this->error('内容不存在');
        }elseif ($info['uid']!=$this->user['uid']) {
            $this->error('你没权限!');
        }
        if ($this -> deleteContent($ids)) {
            $this -> success('删除成功');
        } else {
            $this -> error('删除失败');
        }
    }

}
