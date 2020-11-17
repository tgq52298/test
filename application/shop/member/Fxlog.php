<?php
namespace app\shop\member;

use app\common\controller\MemberBase;
use app\common\traits\AddEditList;
use app\shop\model\Fxlog AS FxlogModel;
use app\shop\model\Content AS ContentModel;


/**
 * 交易成功分销的日志
 *
 */
class Fxlog extends MemberBase
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
        $map = [
            'introducer_uid'=>$this->user['uid']
        ];
        $this->list_items = [
            ['uid','访问用户','username'],
            ['create_time','下订时间','datetime'],
            ['money','收益','text'],
            ['introducer_step','与我的关系','select2',[1=>'徒弟',2=>'徒孙',3=>'徒曾孙']],
            ['aid','购买商品','callback',function($id,$rs){
                $info = ContentModel::getInfoByid($id);
                return "<a href='".iurl('content/show',['id'=>$info['id']])."' target='_blank'>{$info['title']}</a>";
            }],
        ];
        $this->tab_ext['page_title'] = '我的分享收益';
        $this->tab_ext['top_button'] = [];
        $this->tab_ext['right_button'] = [];
        return $this -> getMemberTable(self::getListData($map, $order='id desc' ));
    }
}