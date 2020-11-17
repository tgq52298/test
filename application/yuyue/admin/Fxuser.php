<?php
namespace app\yuyue\admin;

use app\common\controller\AdminBase;
use app\common\traits\AddEditList;
use app\yuyue\model\Fx AS FxModel;
use app\yuyue\model\Content AS ContentModel;


class Fxuser extends AdminBase
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
        $this->model = new FxModel();
    }
    
    public function index() {
        $map = [];
        $this->list_items = [
            ['introducer_1','分享用户','username'],
            ['uid','访问用户','username'],
            ['create_time','访问时间','datetime'],
            ['ifbuy','成功交易','yesno'],
            ['aid','访问商品','callback',function($id,$rs){
                $info = ContentModel::getInfoByid($id);
                return "<a href='".iurl('content/show',['id'=>$info['id']])."' target='_blank'>{$info['title']}</a>";
            }],
        ];
        $this -> tab_ext['search'] = ['introducer_1'=>'分享用户UID','uid'=>'访问用户UID','aid'=>'商品ID'];    //支持搜索的字段
        $this->tab_ext['page_title'] = '用户的分享记录';
        $this->tab_ext['top_button'] = [
            ['type'=>'delete'],
        ];
        $this->tab_ext['right_button'] = [
            ['type'=>'delete'],
        ];
        return $this -> getAdminTable(self::getListData($map, $order='id desc' ));
    }
}