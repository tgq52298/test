<?php
namespace app\yuyue\member;

use app\common\controller\MemberBase;
use app\common\traits\AddEditList;
use app\yuyue\model\Youhui AS YouhuiModel;
use app\yuyue\model\Yhlog AS YhlogModel;
use app\yuyue\model\Content AS ContentModel;

/**
 * 用户领取的优惠券
 *
 */
class Yhlog extends MemberBase
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
        $this->model = new YhlogModel();
    }
    
    public function index($yid=0) {
        if ($yid) {
            $map = [
                'yid'=>$yid,
            ];
        }else{
            $map = [
                'uid'=>$this->user['uid'],
            ];
        }
        $this->list_items = [
            ['aid','内容','callback',function($id,$rs){
                $info = ContentModel::getInfoByid($id);
                return "<a href='".iurl('content/show',['id'=>$info['id']])."' target='_blank'>{$info['title']}</a>";
            }],
            ['money','面值','text'],
            ['end_time','有效截止日期','datetime'],
            ['use_time','使用日期','datetime'],
            ['uid','领取者','username'],
            ['aid','分享者','callback',function($id,$rs){
                $info = YouhuiModel::where('id',$rs['yid'])->find();
                return "<a href='".get_url('user',$info['uid'])."'' target='_blank'>".get_user_name($info['uid'])."</a>";
            }],
            ['id','使用','callback',function($id,$rs){
                return $rs['ifuse']?'已用':"<a href='".iurl('content/show',['id'=>$rs['aid']])."?yid={$id}' target='_blank' class='glyphicon glyphicon-hand-right'></a>";
            }],
        ];
        $this->tab_ext['page_title'] = '我领取的优惠券';
        $this->tab_ext['top_button'] = [];
        $this->tab_ext['right_button'] = [];
        return $this -> getMemberTable(self::getListData($map, $order='id desc' ));
    }
}