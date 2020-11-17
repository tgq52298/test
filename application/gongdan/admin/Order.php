<?php
namespace app\gongdan\admin;

use app\common\controller\AdminBase; 
use app\common\traits\AddEditList;
use app\gongdan\model\Order AS OrderModel;
use app\gongdan\model\Content AS ContentModel;

class Order extends AdminBase
{
    use AddEditList;
    protected $model;
    protected $list_items;
    protected $form_items = [
            ['text', 'linkman', '联系人'],
            ['text', 'telphone', '联系电话'],
            //['image', 'picurl', '分享图片'],
            ['radio', 'ifolpay', '支付类型', '', [1 => '在线付款', 0 => '货到付款'], 1],
    ];
    protected $tab_ext = [
        'page_title'=>'工单记录',
        'top_button'=>[ ['type'=>'delete']],
        'right_button'=>[ ['type'=>'delete']],
    ];
    
    protected function _initialize()
    {
        parent::_initialize();
        $this->model = new OrderModel();     
        
        $this->list_items = [            
            ['shopid','工单模板','callback',function($key,$rs){
                $info = ContentModel::getInfoByid($key);
                $f_array = fun('field@order_field_post',$info['order_filed']);
                $order_info = fun('field@order_field_format',$rs['order_field'],$f_array);
                $listdb = fun('field@fields_to_table',$f_array,$order_info);
                $code = '<a href="'.iurl('content/show',['id'=>$rs['shopid']]).'" target="_blank" class="glyphicon glyphicon-file">'.$info['title'].'</a><br>';
                foreach(fun('field@fields_to_table',$f_array,$order_info) AS $vs){
                    if($f_array[$vs['name']]['listshow']){
                        $code .= "{$vs['title']}：{$vs['value']}<br>";
                    }
                }
                return $code;
            }],
            ['uid', '下单者', 'username'],
            ['create_time', '下单日期', 'text'],
            ['status', '工单状态', 'callback',function($key,$rs){
                $info = ContentModel::getInfoByid($rs['shopid']);
                return status_type($info,$rs['status']);
            }],
        ];
    }

    
    
}
