<?php
namespace app\gongdan\member;

use app\common\controller\member\Order AS _Order;
use app\gongdan\model\Content AS ContentModel;

class Order extends _Order
{
    protected function excel($array=[],$shopid=0){        
        if (!$shopid) {
            $this->error('必须先选择一个工单模板!');
        }
        $info = ContentModel::getInfoByid($shopid);
        $f_array = fun('field@order_field_post',$info['order_filed']);
        
        if(!$array){
            $this->error('没有数据可导出!');
        }
        
        $outstr="<table width=\"100%\" border=\"1\" align=\"center\" cellpadding=\"5\"><tr>";
        
        $fieldDB = [
            'id'=>'序号',
            'order_sn'=>'工单号',
//             'uid'=>'我的UID',
//             'username'=>'我的帐号',
            'create_time'=>'下单日期',
            'robuid'=>'接单者',
            'pingfen'=>'我的评分',
        ];
        foreach($f_array AS $name=>$rs){
            if(in_array($rs['type'], ['images','image','file','files'])){
                continue;
            }
            $fieldDB[$name] = $rs['title'];
        }
        
        foreach($fieldDB AS $title){
            $outstr.="<th bgcolor=\"#A5A0DE\">$title</th>";
        }
        $outstr.="</tr>";
        foreach($array  AS $rs){
            $outstr.="<tr>";
            $vs = fun('field@order_field_format',$rs['order_field'],$f_array);
            $rs = array_merge($rs,$vs);
            foreach($fieldDB AS $k=>$v){
                $value = $rs[$k];
                if ($k=='username') {
                    $value = get_user_name($rs['uid']);
                }elseif($k=='create_time'){
                    $value = format_time($value);
                }elseif($k=='pingfen'){
                    $value = $value?($value.'颗星'):'';
                }elseif($k=='robuid'){
                    $value = $value?get_user_name($value):'';
                }
                $outstr.="<td align=\"center\">{$value}</td>";
            }
            $outstr.="</tr>";
        }
        $outstr.="</table>";
        ob_end_clean();
        header('Last-Modified: '.gmdate('D, d M Y H:i:s',time()).' GMT');
        header('Pragma: no-cache');
        header('Content-Encoding: none');
        header('Content-Disposition: attachment; filename=MicrosoftExce.xls');
        header('Content-type: text/csv');
        echo "<!doctype html>
        <html lang='en'>
        <head>
        <meta charset='UTF-8'>
        <title></title>
        </head>
        <body>
        $outstr
        </body>
        </html>";
        exit;
    }
    
    /**
     * 查看我的订单列表
     * @param unknown $type
     * @return mixed|string
     */
    public function index($type=null,$aid=0,$excel=0){
        $map = [
            'uid'=>$this->user['uid'],
        ];
        if ($aid) {
            $map['shopid'] = $aid;
        }
        
        if($type=='ispay'){
            $map['pay_status'] = 1;
        }elseif($type=='nopay'){
            $map[ 'pay_status'] = 0;
        }
        $list_data = $this->model->getList($map,15,$excel);
        if ($excel==1) {
            $this->excel($list_data,$aid);
        }
        
        $this->assign('listdb',getArray($list_data)['data']);
        $this->assign('pages',$list_data->render());
        $this->assign('type',$type);        
        $listdb = getArray($list_data)['data'];
        $shopdb = [];
        foreach ($listdb AS $rs){
            $shopdb[$rs['shop_db'][0]['id']] = $rs['shop_db'][0];
        }
        $this->assign([
            'listdb'=>$listdb,
            'pages'=>$list_data->render(),
            'aid'=>$aid,
            'type'=>$type,
            'shopdb'=>$shopdb,
        ]);
        return $this->fetch();
    }
    
    /**
     * 确认抢单人选
     * @param number $id
     * @param number $uid
     */
    public function choose_rober($id=0,$uid=0){
        $info = $this->model->getInfo($id);
        if ($info['uid']!=$this->user['uid']) {
            $this->error('你没权限');
        }elseif(!$uid){
            $this->error('uid不存在');
        }
        
        $result = $this->model->where('id',$id)->update([
            'robuid'=>$uid,
        ]);
        if ($result) {
            $title = '恭喜你抢单成功';
            $content = '恭喜你抢单成功，你竞抢 '.$this->user['username'].' 提交的工单：'.$info['shop_db'][0]['title'].'，他已经授权你跟进服务了! <a href="'.get_url(urls('kehu_order/show',['id'=>$id])).'" target="_blank">点击查看详情</a>';
            send_msg($uid,$title,$content);
            send_wx_msg($uid, $content);
            $this->success('操作成功');
        }else{
            $this->error('数据库执行失败');
        }
    }
}