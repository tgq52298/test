<?php
namespace app\shop\member;

use app\common\controller\MemberBase;
use app\common\traits\AddEditList;
use app\shop\model\Fx AS FxModel;
use app\shop\model\Content AS ContentModel;

/**
 * 分享日志,不一定交易成功
 *
 */
class Fxuser extends MemberBase
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
        $map = [
            'introducer_1'=>$this->user['uid']
        ];
        $this->list_items = [
            ['uid','访问用户','username'],
            ['create_time','访问时间','datetime'],
            ['ifbuy','成功交易','yesno'],
            ['aid','访问商品','callback',function($id,$rs){
                $info = ContentModel::getInfoByid($id);
                return "<a href='".iurl('content/show',['id'=>$info['id']])."' target='_blank'>{$info['title']}</a>";
            }],
        ];
        $this->tab_ext['page_title'] = '我的分享记录';
        $this->tab_ext['top_button'] = [];
        $this->tab_ext['right_button'] = [];
        return $this -> getMemberTable(self::getListData($map, $order='id desc' ));
    }
}