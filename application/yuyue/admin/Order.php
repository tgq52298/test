<?php
namespace app\yuyue\admin;

use app\common\controller\admin\Order AS _Order;
//use app\yuyue\model\Order as OrderModel;
use app\yuyue\model\Content AS ContentModel;

class Order extends _Order
{
    protected $form_items = [
            ['text', 'linkman', '联系人'],
            ['text', 'telphone', '联系电话'],
            //['image', 'picurl', '分享图片'],
            ['radio', 'ifolpay', '支付类型', '', [1 => '在线付款', 0 => '货到付款'], 1],
    ];
    protected $tab_ext = [
            'page_title'=>'订单记录',
            'top_button'=>[ ['type'=>'delete']],
    ];
    
//     protected function _initialize()
//     {
//         parent::_initialize();
//     }

    public function index() {
        
        //列表定义显示的字段
        $list_field = \app\common\field\Table::get_list_field(-1);
        $array = [
                ['order_sn', '订单号', 'text'],
                ['shopid', '订购商品', 'callback',function($id){
                    $info = ContentModel::getInfoByid($id);
                    return "<a href='".iurl('content/show',['id'=>$id])."' target='_blank'>{$info['title']}</a>";
                }],
                ['uid', '订购者', 'username'],
                ['fewmoney', '订金', 'text'],
                ['few_ifpay', '付订与否', 'yesno'],
                ['pay_money', '尾款', 'text'],
                ['pay_status', '尾款状态', 'callback',function($key,$rs){
                    if($rs['receive_status']==1){
                        return '交易完成';
                    }elseif($key==1){
                        return '线上已付';
                    }else{
                        return '待付';
                    }
                }],
                ['linkman', '联系人', 'text'],
                //['telphone', '联系电话', 'text'],
                //['address', '联系地址', 'text'],
                ['create_time', '下单日期', 'text'],
        ];
        $this->list_items = $list_field ? array_merge($array,$list_field) : $array;
        
        //搜索字段
        $search = \app\common\field\Table::get_search_field(-1);
        $this -> tab_ext['search'] = array_merge(['uid'=>'用户uid','shopid'=>'商品id','order_sn'=>'订单号'],$search);
        
        //筛选字段
        $this->tab_ext['filter_search'] =  [
                'few_ifpay'=>['未付订金','已付订金'],
                'pay_status'=>['线下付尾款','已线上付尾款','交易完成'],
        ];
        $array = \app\common\field\Table::get_filtrate_field(-1);
        if (is_array($array)) {
            $this->tab_ext['filter_search'] = array_merge($this->tab_ext['filter_search'],$array);
        }
        //右边菜单
        $this -> tab_ext['right_button'] = [
                ['type'=>'delete'],
                ['type'=>'edit'],
                [
                        'icon'=>'fa fa-file-o',
                        'title'=>'详情',
                        'url'=>auto_url('show','id=__id__'),
                ],
        ];
        $map= [];
        if (input('search_field')=='pay_status' && input('keyword')==2) {   //注意:线下付尾款的话, receive_status为1  pay_status还是为0的
            $map['pay_status']=['>',-1];
            $map['receive_status']=1;
        }
        
        $listdb = self::getListData($map, $order = []);
        return $this -> getAdminTable($listdb);
    }
    
    
    /**
     * 查看详情
     * @param number $id
     * @return \app\common\traits\unknown
     */
    public function show($id=0){
        
        $form_items = \app\common\field\Form::get_all_field(-1);    //自定义字段
        $this->form_items = array_merge(
                [
                        ['callback','uid', '购买者帐号','',function($key){
                            $username = get_user_name($key);
                            $url = get_url('user',$key);
                            return "<a href='$url' target='_blank'>$username</a>";
                        }],
                        ['text','order_sn', '订单号'],
                        ['text','shipping_code', '序列号(验证码/物流单号)'],
                        ['text','fewmoney', '订金'],
                        ['radio','few_ifpay', '订金支付与否','',['未支付','已支付']],
                        ['text','pay_money', '尾款'],
                        ['callback','pay_status', '尾款状态','',function($key,$rs){
                            if($rs['receive_status']==1){
                                return '交易完成';
                            }elseif($key==1){
                                return '线上已付';
                            }else{
                                return '待付';
                            }
                        }],
                        ['date','create_time', '下单日期'],
                        ['callback','introducer_1', '直接推荐人','',function($key){
                            if(empty($key)){
                                return ;
                            }
                            $username = get_user_name($key);
                            $url = get_url('user',$key);
                            return "<a href='$url' target='_blank'>$username</a>";
                        }],
                        ['callback','introducer_2', '间接推荐人','',function($key){
                            if(empty($key)){
                                return  ;
                            }
                            $username = get_user_name($key);
                            $url = get_url('user',$key);
                            return "<a href='$url' target='_blank'>$username</a>";
                        }],
                ],
                $form_items
                );
        
        $info = getArray( $this->getInfoData($id) );
        $info = fun('field@format',$info,'','show','',$this->form_items);  //数据转义
        
        return $this->getAdminShow($info) ;
    }
    
    
    
}
