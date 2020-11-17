<?php
namespace app\gongdan\member;

use app\common\controller\member\KehuOrder AS _Order;
use app\gongdan\model\Cnt AS CntModel;
use app\gongdan\model\Content AS ContentModel;
//use app\qun\model\Member AS MemberModel;

class KehuOrder extends _Order
{
    /**
     * 权限检测
     * @param array $info 订单信息
     * {@inheritDoc}
     * @see \app\common\controller\member\KehuOrder::check_power()
     */
    protected function check_power($info = []){
        if ($info['shop_uid']==$this->user['uid'] || $info['robuid']==$this->user['uid']){
            return true;
        }elseif ( status_power(end($info['shop_db'])?:$info['shopid'],$this->user,true) ){
            if ($info['robuid'] && check_notice(end($info['shop_db'])?:$info['shopid'],$this->user) ) {
                return '该工单已被他人抢走了,你没权限再访问!';
            }
            return true;
        }
        return '你没权限';
    }
    
    
    /**
     * 抢单
     * @param number $id 订单ID
     */
    public function rob($id=0){
        $info = $this->model->getInfo($id);
        if (!$info){
            $this->error('信息有误!');
        }elseif ($info['shop_db'][0]['robtype']==0) {
            $this->error('该工单不能竟抢!');
        }elseif($info['uid']==$this->user['uid']){
            $this->error('你不能抢自己的单!');
        }
        $result = $this->check_power($info);
        if ($result!==true) {
            $this->error($result);
        }
        if ($info['robuid']) {
            if ($info['robuid']==$this->user['uid']) {
                $this->error('你抢成功了,请不要重复抢单!');
            }else{
                $this->error('很抱歉,你来晚了一步,该工单已被人抢走了!');
            }
        }elseif($info['roblist']!='' && in_array($this->user['uid'], explode(',', $info['roblist']))){
            $this->error('请不要重复抢单，请等待客户确认！');
        }
        $url = get_url(urls('order/show',['id'=>$id]));
        $data = [];
        if ($info['shop_db'][0]['robtype']==1) { //无须用户确认的抢单
            $data['robuid'] = $this->user['uid'];
            $msg = '你已成功抢单,请及时跟进服务!';
            $title = '你的工单被承接了';
            $content = '你提交的工单:'.$info['shop_db'][0]['title'].' 任务被 '.$this->user['username'].' 承接了,<a href="'.$url.'" target="_blank">点击查看详情</a>';
        }else{
            $data['roblist'] =  $this->user['uid'].( $info['roblist'] ? (','.$info['roblist']) : '') ;
            $msg = '你的信息已提交,请等待客户确认!';
            $title = '请确认工单承接者';
            $content = '你提交的工单:'.$info['shop_db'][0]['title'].' 任务， '.$this->user['username'].' 想承接，你若接受他的请求，就请进入工单系统确认通过。<a href="'.$url.'" target="_blank">进入工单系统</a>';
        }
        $result = $this->model->where('id',$id)->update($data);
        if ($result) {
            send_msg($info['uid'],$title,$content);
            send_wx_msg($info['uid'], $content);
            $this->success($msg);
        }else{
            $this->error('数据库执行失败');
        }
    }
    
    
    /**
     * 人工派单
     * @param number $id
     * @param number $uid
     */
    public function choose_rober($id=0,$uid=0){
        $info = $this->model->getInfo($id);
        if ($info['shop_uid']!=$this->user['uid']) {
            $this->error('你没权限');
        }elseif(!$uid){
            $this->error('uid不存在');
        }elseif($uid==$info['robuid']){
            $this->error('不能重复指派');
        }
        
        $result = $this->model->where('id',$id)->update([
            'robuid'=>$uid,
        ]);
        if ($result) {
            $title = '恭喜你抢单成功';
            $content = '恭喜你抢单成功，你竞抢 '.get_user_name($info['uid']).' 提交的工单：'.$info['shop_db'][0]['title'].'，'.$this->user['username'].'指派并授权你跟进服务! <a href="'.get_url(urls('kehu_order/show',['id'=>$id])).'" target="_blank">点击查看详情</a>';
            send_msg($uid,$title,$content);
            send_wx_msg($uid, $content);
            $this->success('操作成功');
        }else{
            $this->error('数据库执行失败');
        }
    }
    
    public function show($id){
//         $info = $this->model->getInfo($id);        
//         $shopinfo = $info['shop_db'][0];        
//         if ($shopinfo['notice_group']!='') {
//             $array = explode(',', trim($shopinfo['notice_group'],','));
//             $qun_id = $shopinfo['ext_id'];
//             if (!$qun_id) {
//                 $qun_id = end(fun('qun@getByuid',$shopinfo['uid']))['id']; //圈子ID
//             }
//             $listdb = MemberModel::where('aid',$qun_id)->where('type','IN',$array)->column(true);
//             foreach($listdb AS $rs){
//             }
//         }
        
        return parent::show($id);
    }
    
    public function index($type=null,$aid=0,$excel=0){
        $shop_uid = 0;
        $map2 = [
            'shop_uid'=>$this->user['uid'],
            'robuid'=>$this->user['uid'],
        ];
        $map = [];
        if ($aid) {
            $map['shopid'] = $aid;
        }
        
        if($type=='ispay'){
            $map['pay_status'] = 1;
        }elseif($type=='nopay'){
            $map['pay_status'] = 0;
        }
        $shopdb = $this->content_model->getIndexByUid($shop_uid?:$this->user['uid']);
        
        $list_data = $this->model->getList($map,10,$excel,$map2);
        if ($excel==1) {
            $this->excel($list_data,$aid);
        }
        
        $this->assign([
            'listdb'=>getArray($list_data)['data'],
            'pages'=>$list_data->render(),
            'aid'=>$aid,
            'type'=>$type,
            'shopdb'=>$shopdb,
        ]);
        return $this->fetch();
    }
    
    /**
     * 删除工单
     * @param unknown $id
     */
    public function delete($id){
        $info = getArray($this->model->getInfo($id));
        if ($info['shop_uid']!=$this->user['uid']) {
            $this->error('你没权限');
        }
        if ($this->model->destroy($id)) {
            CntModel::where('orderid',$id)->delete();
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    
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
            'uid'=>'客户UID',
            'username'=>'客户帐号',
            'create_time'=>'下单日期',
            'robuid'=>'接单者',
            'pingfen'=>'用户评分',
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
}