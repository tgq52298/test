<?php
namespace app\gongdan\index;

use app\common\controller\index\Order AS _Order;
use app\gongdan\model\Content AS ContentModel;
use app\gongdan\model\Cnt AS CntModel;
use app\qun\model\Member AS MemberModel;

//下单
class Order extends _Order
{
    public function add(){
        $money = $this->car_model->getMoney($this->user['uid']);
        $this->assign('money',$money);  //统计需要支付的金额        
        return parent::add();
    }
    
    protected function end_add($order_ids=[],$car_ids=[],$car_db=[]){
        foreach($car_db AS $rs){
            ContentModel::addField($rs['shopid'],'order_num',true,$rs['num']);  //下单数量
        }
        parent::end_add($order_ids,$car_ids,$car_db);
    }
    
    protected function add_shoper_end($id=0,$shop_array=[],$data=[]){
        $shopinfo = end($shop_array);
        $shopid = $shopinfo['id'];
        
        $f_array = fun('field@order_field_post',$shopinfo['order_filed']);
        $order_info = fun('field@order_field_format',$data['order_field'],$f_array);
        
        $array = [];
        foreach ($order_info AS $name=>$value){
            if ($f_array[$name]) {
                $array[] = [
                    'aid'=>$shopid,
                    'orderid'=>$id,
                    'name'=>$f_array[$name]['title'],
                    'about'=>in_array($f_array[$name]['type'], ['select','radio','checkbox'])?$value:'',
                    'content'=>in_array($f_array[$name]['type'], ['select','radio','checkbox'])?'':$value,
                ];
            }            
        }
        $obj = new CntModel;
        $obj->saveAll($array);
        
        if ($shopinfo['notice_group']!='') {
            $array = explode(',', trim($shopinfo['notice_group'],','));
            $title = "有人提交了一个新工单:".$shopinfo['title'];
            $content = '<a href="'.get_url(murl('kehu_order/show',['id'=>$id])).'" target="_blank">'.$this->user['username'].' 提交了一个新工单 《'.$shopinfo['title']."》，点击查看详情</a>";
            
            $qun_id = $shopinfo['ext_id'];
            if (!$qun_id) {
                $qun_id = end(fun('qun@getByuid',$shopinfo['uid']))['id']; //圈子ID
            }
            $listdb = MemberModel::where('aid',$qun_id)->where('type','IN',$array)->column(true);
            foreach($listdb AS $rs){
                send_msg($rs['uid'],$title,$content);
                send_wx_msg($rs['uid'], $content);
            }
        }
    }
    
    protected function send_msg($shop_uid=0,$order_id=0,$shop=[],$msg=''){        
    }
    
    /**
     * 付款之后返回的页面
     * @param string $orders_id 订单ID,可能有多个订单
     * @param number $ispay 是否支付成功
     */
    public function endpay($orders_id = '',$ispay=1){
        return parent::endpay($orders_id,$ispay);
    }
}

