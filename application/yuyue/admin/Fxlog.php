<?php
namespace app\yuyue\admin;

use app\common\controller\AdminBase;
use app\common\traits\AddEditList;
use app\yuyue\model\Fxlog AS FxlogModel;
use app\yuyue\model\Content AS ContentModel;


class Fxlog extends AdminBase
{
    use AddEditList;
    protected $validate = '';
    protected $model;
    protected $form_items;
    protected $list_items;
    protected $tab_ext;
    
    protected function _initialize()
    {
        parent::_initialize();
        $this->model = new FxlogModel();
    }
    
    public function index() {
        $map = [];
        $this->list_items = [
            ['introducer_uid','分享用户','username'],
            ['uid','访问用户','username'],
            ['create_time','下订时间','datetime'],
            ['money','收益','text'],
            ['introducer_step','分享关系','select2',[1=>'徒弟',2=>'徒孙',3=>'徒曾孙']],
            ['aid','购买商品','callback',function($id,$rs){
                $info = ContentModel::getInfoByid($id);
                return "<a href='".iurl('content/show',['id'=>$info['id']])."' target='_blank'>{$info['title']}</a>";
            }],
        ];
        $this->tab_ext['page_title'] = '我的分享收益';
        $this->tab_ext['top_button'] = [
            ['type'=>'delete'],
        ];
        $this->tab_ext['right_button'] = [
            ['type'=>'delete'],
        ];
        $this -> tab_ext['search'] = ['introducer_uid'=>'分享用户UID','uid'=>'访问用户UID','aid'=>'商品ID'];    //支持搜索的字段
        return $this -> getAdminTable(self::getListData($map, $order='id desc' ));
    }
}