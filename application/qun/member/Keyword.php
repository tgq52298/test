<?php
namespace app\qun\member;

use app\common\controller\MemberBase;
use app\common\traits\AddEditList;
use app\qun\model\Keyword AS Model;

class Keyword extends MemberBase
{
    use AddEditList;
    
    protected $validate = '';
    protected $model;
    protected $form_items;
    protected $list_items;
    protected $tab_ext;
    protected $mid;
    
    protected function _initialize()
    {
        parent::_initialize();
        $this->model = new Model();
        
        $this->tab_ext['page_title'] = '群聊关键字回复管理';
        
        $this->tab_ext['right_button'] = [
            [
                'type'=>'delete',
                'title'=>'删除',
            ],
            [
                'type'=>'edit',
                'title'=>'修改',
            ],
        ];
    }
    

    public function index($aid=0) {
        if (empty($aid)) {
            $quns = fun('qun@getByuid',$this->user['uid']);
            if (count($quns)>1) {
                $url = url('choose/index').'?url='.urlencode( urls('index').'?aid=' );
                $this->redirect($url);
            }else{
                $aid = $quns[0]['id'];
            }
        }

        $this->tab_ext['top_button'] = [
            [
                'title'=>'关键字管理',
                'href'=>urls('index',['aid'=>$aid]),
            ],
            [
                'type'=>'add',
                'title'=>'添加关键字',
                'href'=>urls('add',['aid'=>$aid]),
            ],
        ];
        
        if ($this->request->isPost()) {
            //修改排序
            return $this->edit_order();
        }
        
        $this->list_items = [
            ['ask','关键字','text'],
            ['answer','回复内容','text'],
        ];
        
        $map = [
            'uid'=>$this->user['uid'],
            'aid'=>$aid,
        ];
        $listdb = $this->getListData($map, $order = 'list desc,id asc');
        return $this -> getAdminTable($listdb);
    }    

    public function add($aid=0,$type=1) {
        if (empty($aid)) {
            $this->error(QUN.'ID不存在');
        }
        
        if ($this->request->isPost()) {
            $data = $this -> request -> post();
            if (empty($data['ask'])) {
                $this -> error('关键字不能为空');
            }elseif (empty($data['answer'])) {
                $this -> error('回复内容不能为空');
            }
            $data['ask'] = trim(str_replace('，', ',', $data['ask']),',');
            $this -> request -> post(['ask'=>$data['ask']]);
            if ($this -> saveAddContent()) {
                $data = $this -> request -> post();
                $url = urls('index',['aid'=>$aid]);
                $this -> success('添加成功', $url);
            } else {
                $this -> error('添加失败');
            }
        }
        
        $this->form_items = [
            ['hidden','aid',$aid],
            ['text','ask','关键字','多个用逗号,隔开'],
            ['text','answer','回复内容'],
        ];
        $this->assign('aid',$aid);
        return $this -> addContent();
    }
    
    public function edit($id = null) {
        
        if (empty($id)) $this -> error('缺少参数');
        
        $info = $this -> getInfoData($id);
        if ($info['uid']!=$this->user['uid']) {
            $this -> error('你没权限');
        }
        
        if ($this->request->isPost()) {
            $data = $this -> request -> post();
            $data['ask'] = trim(str_replace('，', ',', $data['ask']),',');
            $this -> request -> post(['ask'=>$data['ask']]);
            if ($this -> saveEditContent()) {
                $url = urls('index',['aid'=>$info['aid']]);
                $this -> success('修改成功', $url);
            } else {
                $this -> error('修改失败');
            }
        }
        $this->form_items = [
            ['text','ask','关键字','多个用逗号,隔开'],
            ['text','answer','回复内容'],
        ];
        
        return $this -> editContent($info);
    }
    
    public function delete($ids = null) {
        $ids = is_array($ids)?$ids:[$ids];
        foreach($ids AS $key){
            $info = $this -> getInfoData($key);
            if ($info['uid']!=$this->user['uid']) {
                $this -> error('你没权限');
            }
        }
        if ($this -> deleteContent($ids)) {
            $this -> success('删除成功');
        } else {
            $this -> error('删除失败');
        }
    }
    
}
