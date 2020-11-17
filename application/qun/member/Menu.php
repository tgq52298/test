<?php
namespace app\qun\member;

use app\common\controller\MemberBase;
use app\common\traits\AddEditList;
use app\qun\model\Menu AS Model;
/**
 * 
 * 会员中心用到的我的分类功能
 *
 */
class Menu extends MemberBase
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
        preg_match_all('/([_a-z]+)/',get_called_class(),$array);
        $dirname = $array[0][1];
        $this->model        = new Model();
        
        $this->tab_ext['page_title'] = '菜单管理';
        
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
    
    /**
     * 菜单列表
     * @param number $aid 圈子ID
     * @param number $type 菜单分类
     * @return unknown|mixed|string
     */
    public function index($aid=0,$type=1) {
        if (empty($aid)) {
            $this->error(QUN.'ID不存在');
        }
        $menu_name = '添加菜单';
        if($type==1){
            $menu_name = '添加底部菜单';
        }elseif($type==2){
            $menu_name = '添加头部菜单';
        }elseif($type==3){
            $menu_name = '添加浮动按钮菜单';
        }
        $this->tab_ext['top_button'] = [                            
            [
                'title'=>'预览效果',
                'href'=>iurl('content/show',['id'=>$aid]),
            ],
            [
                'type'=>'add',
                'title'=>$menu_name,
                'href'=>urls('add',['aid'=>$aid,'type'=>$type]),
            ],
        ];
        
        if ($this->request->isPost()) {
            //修改排序
            return $this->edit_order();
        }
        
        $this->list_items = [
            ['style','图标','icon'],
            ['name','菜单名称','text'],
        ];
        
        $map = [
            //'uid'=>$this->user['uid'],
            'aid'=>$aid,
            'type'=>$type,
        ];
        $this ->assign('type',$type);
        $listdb = $this->getListData($map, $order = 'list desc,id asc');
        return $this -> getAdminTable($listdb);
    }
    
    /**
     * 新增菜单
     * @param number $aid 圈子ID
     * @param number $type 菜单分类
     * @return mixed|string
     */
    public function add($aid=0,$type=1) {
        if (empty($aid)) {
            $this->error(QUN.'ID不存在');
        }
        
        if ($this->request->isPost()) {
            if ($this -> saveAddContent()) {
                $data = $this -> request -> post();
                cache('qun_menu_'.$data['type'].'_'.$data['aid'],null);
                $url = urls('index',['aid'=>$aid,'type'=>$type]);
                $this -> success('添加成功', $url);
            } else {
                $this -> error('添加失败');
            }
        }
        
        $this->form_items = [
            ['hidden','aid',$aid],
            ['hidden','type',$type],
            ['text','url','菜单链接'],
            ['text','name','菜单名称'],                
            ['icon','style','图标'],
            ['text','list','排序值'],
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
            if ($this -> saveEditContent()) {
                $url = urls('index',['aid'=>$info['aid'],'type'=>$info['type']]);
                cache('qun_menu_'.$info['type'].'_'.$info['aid'],null);
                $this -> success('修改成功', $url);
            } else {
                $this -> error('修改失败');
            }            
        }
        
        $this->form_items = [
            ['text','url','菜单链接'],
            ['text','name','菜单名称'],
            ['icon','style','图标'],
            ['text','list','排序值'],
        ];
                
        $this->assign('aid',$info['aid']);
        
        return $this -> editContent($info);
    }
    
    /**
     * 删除菜单
     * @param unknown $ids
     */
    public function delete($ids = null) {
        $ids = is_array($ids)?$ids:[$ids];
        foreach($ids AS $key){
            $info = $this -> getInfoData($key);
            if ($info['uid']!=$this->user['uid']) {
                $this -> error('你没权限');
            }
            cache('qun_menu_'.$info['type'].'_'.$info['aid'],null);
        }        
        if ($this -> deleteContent($ids)) {
            $this -> success('删除成功');
        } else {
            $this -> error('删除失败');
        }
    }    
    
}