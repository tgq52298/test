<?php
namespace app\yuyue\member;

use app\common\controller\MemberBase;
use app\common\traits\AdminSort;
use app\yuyue\model\Time AS TimeModel;
use app\yuyue\model\Timesort AS TimesortModel;


class Time extends MemberBase
{
    use AdminSort;
    
    protected $validate = '';
    protected $model;
    protected $form_items;
    protected $list_items;
    protected $tab_ext;
    protected $mid;
    
    protected function _initialize()
    {
        parent::_initialize();
        $this->model        =  new TimeModel;
        $this->list_items = [
            ['week','星期几','select',['每天','周一','周二','周三','周四','周五','周六','周日']],
            ['name','当天时间段','text'],
            ['num','库存','callback',function($value){
                return $value?:'';
            }],
            ['type','分类','select2',TimesortModel::getsort($this->user['uid'])],
            ];
        $this->tab_ext['page_title'] = '预约时间管理';
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
    
    
    public function index() {
        if ($this->request->isPost()) {
            //修改排序
            return $this->edit_order();
        }
        
        $map = [
            'uid'=>$this->user['uid'],
        ];
        
        
        $this->tab_ext['top_button'] = [
            [
                'type'=>'add',
                'title'=>'新增预约时间',
                'href'=>url('add'),
            ],
            [
                'type'=>'sort',
                'title'=>'分类管理',
                'href'=>url('sort'),
                'icon'=>'fa fa-list-ul',
            ],
        ];
        
        $listdb = $this->getListData($map,'type asc,week asc');
        return $this -> getAdminTable($listdb);
    }
    
    /**
     * 时间段分类管理
     * @return mixed|string
     */
    public function sort(){
        $info = getArray(TimesortModel::where('uid',$this->user['uid'])->find());
        if ($this -> request -> isPost()) {
            if (!$info) {
                $result = TimesortModel::create([
                    'uid'=>$this->user['uid'],
                ]);
                $id = $result->id;
            }else{
                $id = $info['id'];
            }
            $data = $this -> request -> post();
            $reuslt = TimesortModel::where('id',$id)->update([
                'name'=>$data['name'],
            ]);
            if ($reuslt) {
                $this->success('修改成功','index');
            }else{
                $this->error('修改失败');
            }
        }
        $this->tab_ext['page_title'] = '分类名称管理';
        $this->form_items = [
            ['array','name','分类名称'],
        ];
        return $this -> editContent($info,$url='');
    }
    
    public function add($ext_id=0,$ext_sys=0) {
        $this->form_items = [
            ['textarea','name','当天时间段','比如早上或上午或具体的10点-12点同时添加多个,则每个换一行'],
            ['select','week','星期几','',['每天','周一','周二','周三','周四','周五','周六','周日']],
            ['number','num','库存','一般留空,则以商品设置为准'],
            ['radio','type','分类','',TimesortModel::getsort($this->user['uid']),0],
            //['money','price','价格','一般留空,则以商品设置为准'],
        ];
        $url = url('index',[
            'ext_id'=>$ext_id,
            'ext_sys'=>$ext_sys,
        ]);
        return $this -> addContent($url);
    }
    
    public function edit($id = null) {
        $this->form_items = [
            ['text','name','当天时间段'],
            ['select','week','星期几','',['每天','周一','周二','周三','周四','周五','周六','周日']],
            ['number','num','库存','一般留空,则以商品设置为准'],
            ['radio','type','分类','',TimesortModel::getsort($this->user['uid']),0],
            //['money','price','价格','一般留空,则以商品设置为准'],
        ];
        if (empty($id)) $this -> error('缺少参数');
        $info = $this -> getInfoData($id);
        if ($info['uid']!=$this->user['uid']) {
            $this -> error('你没权限');
        }
        $url = url('index',[
            'ext_id'=>$info['ext_id'],
            'ext_sys'=>$info['ext_sys'],
        ]);
        return $this -> editContent($info,$url);
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