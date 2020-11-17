<?php
namespace app\qun\index\wxapp;

use app\common\controller\IndexBase;
use app\qun\model\Member AS MemberModel;
use app\qun\model\Content;

class Member extends IndexBase
{
    protected $paymoneymsg = '';
    /**
     * 检查当前用户是否加入过某个圈子
     * @param number $id 圈子ID
     */
    public function ckjoin($id=0){
        $where = [
                'aid'=>$id,
                'uid'=>$this->user['uid'],
        ];
        $rs = MemberModel::get($where);
        if ($rs && $rs['type']==0) {    //待审核
            return $this->ok_js(0,'待审核!');
        }elseif($rs){
            return $this->ok_js($rs['type'],'正式会员!');
        }else{
            return $this->err_js('没有加入!');
        }
    }
    
    /**
     * 付费或授权码验证处理
     * @param string $sncode
     * @param number $money_type  VIP天数时长,-1是永久VIP 
     * @param array $info
     * @return string|boolean
     */
    private function check_join($sncode='',$money_type=0,&$info=[]){
        if ($sncode!='') {
            $array = explode("\r\n",$info['sncode']);
            if (!in_array($sncode, $array)) {
                return $this->err_js('授权码不正确!');
            }
            $info['sncode'] = implode("\r\n", array_diff($array,[$sncode]) );  //用户输入正确授权码后,就要把这个授权码去除,避免授权码重复使用.
        }else{
            $money = abs($this->get_moneytime($info,$money_type));
            if ($this->user['rmb']<$money) {
                $url = post_olpay([
                    'money'=>$money - $this->user['rmb'],
                    'return_url'=>urls('content/apply',['id'=>$info['id'],'type'=>'up']),
                    'banktype'=> '',//in_weixin() ? 'weixin' : 'alipay' , //在微信端,就用微信支付,否则就用支付宝支付
                    'numcode'=>'s'.date('ymdHis').rands(3),
                    'callback_class'=>'',   //执行回调方法
                ]);
                $data = [
                    'payurl'=>$url,
                ];
                return $this->err_js('你的余额不足 '.$money.' 元,请先充值!',$data);
            }
            $title = $this->user['username'].'在 '.$info['title'].' 升级会员';
            add_rmb($this->user['uid'],-$money,0,'在 '.$info['title'].' 升级会员');
            $this->paymoneymsg = ' 付费 ' . $money . ' 元，升级' . ($money_type==-1?'永久'.fun('qun@get_group',4):fun('qun@get_group',4).' '.$money_type.' 天');
            if ($this->webdb['qun_upgroup_charge']>0 && $this->webdb['qun_upgroup_charge']<1) { //平台收手续费
                $money = (1-$this->webdb['qun_upgroup_charge'])*$money;
                $this->paymoneymsg .='，平台扣取手续费 '.($this->webdb['qun_upgroup_charge']*100).'%，你最终只得 '.$money.' 元 ';
            }
            add_rmb($info['uid'],$money,0,$title);  //圈主收益
        }
        return true;
    }
    
    /**
     * 获取用户选择的VIP时长需要支付的金额
     * @param array $info 圈子信息
     * @param string $day 时长,-1是永久VIP 
     * @param string $type 要取时间还是金额
     * @return unknown|array
     */
    private function get_moneytime($info=[],$day='',$type='money'){
        if ($day<1) {
            return $type=='money'?$info['money']:0;
        }
        $string =  trim($info['money_time'], " ,;\r\n|");
        $string = str_replace("\r","",$string);
        $array = explode("\n",$string);
        $data = [];
        foreach($array AS $value){
            list($time,$money,$title) = explode('|', $value);
            if ($time==$day) {
                return $type=='money'?$money:$time;
            }
        }
        return $type=='money'?$info['money']:0;
    }
    
    /**
     * 获取VIP多个不同时长不同金额的数组
     * @param string $string
     * @return unknown[][]|string[][]|array[][]
     */
    private function get_all_moneytime($string=''){
        $string =  trim($string, " ,;\r\n|");
        $string = str_replace("\r","",$string);
        $array = explode("\n",$string);
        $data = [];
        foreach($array AS $value){
            list($time,$money,$title) = explode('|', $value);
            if ($money<0.01) {
                continue;
            }
            $data[] = [
                'money'=>$money,
                'time'=>$time,
                'title'=>$title?:$time.'天',
            ];
        }
        return $data;
    }
    
    /**
     * 加入或升级或退出圈子
     * @param string $type up升级  quit退出
     * @param number $id
     * @param string $sncode
     * @param string $money_type
     * @return void|\think\response\Json|\app\qun\index\wxapp\unknown|void|\think\response\Json|unknown
     */
    public function api($type='',$id=0,$sncode='',$money_type=''){
        if ($type=='up') {
            return $this->upgroup($id,$sncode,$money_type);
        }elseif ($type=='quit') {
            return $this->quit($id);
        }else{
            return $this->join($id,$sncode,$money_type);
        }
    }
    
    /**
     * 圈子成员升级用户组
     * @param number $id
     * @param string $sncode
     * @param string $money_type
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function upgroup($id=0,$sncode='',$money_type=''){
        if(!$this->user){
            return $this->err_js('你还没有登录!');
        }
        $info = Content::getInfoByid($id);
        if(!$info){
            return $this->err_js('ID有误!');
        }
        if (empty($info['pay_join_type'])||$info['pay_join_type']==1) {
            $info['pay_join_type']=4;
        }
        $where = [
            'aid'=>$id,
            'uid'=>$this->user['uid'],
        ];
        $info_data = [];
        $rs = MemberModel::get($where);
        if (empty($rs)) {
            return $this->err_js('你还没加入,不能直接升级!');
        }elseif($rs['type']==2||$rs['type']==3){
            return $this->err_js('你是管理员,不用升级!');
        }elseif($rs['type']==$info['pay_join_type']){
            return $this->err_js('请不要重复升级!');
        }else{
            if ( empty($info['sncode']) && $info['money']<0.01 ) {
                return $this->err_js('本'.QUN.'管理员还没设置升级所需条件!');
            }elseif ( empty($sncode) && empty($money_type) ) {
                $datas = [
                    'money'=>$info['money'],
                    'money_time'=>$this->get_all_moneytime($info['money_time']),
                ];
                if ( $info['money']>0 && $info['sncode']!='' ) {
                    return $this->err_js('本'.QUN.'需要输入授权码或付费 '.$info['money'].' 元才可以升级!请选择一种升级方式',$datas,3);
                }elseif ( $info['money']>0 && $info['sncode']=='' ) {
                    return $this->err_js('本'.QUN.'需要付费 '.$info['money'].' 元才可以升级!',$datas,4);
                }else{
                    return $this->err_js('本'.QUN.'需要输入授权码才可以升级!',[],2);
                }
            }
            $result = $this->check_join($sncode,$money_type,$info);
            if ($result!==true) {
                return $result;
            }
        }
        
        if ($info['autoyz']==-1 && $info['pay_join_type']>0) {    //指定了加入某个会员组,只有选择付费或授权码方式加入的时候才有效
            $type = $info['pay_join_type'];
        }else {
            $type = 1;
        }
        
        $day = $this->get_moneytime($info,$money_type,'time');
        $end_time = $day ? time()+$day*3600*24 : 0;
        $data = [
            'id'=>$rs['id'],
            'type'=> $info['pay_join_type'],
            'end_time'=>$end_time,
        ];
        $result = MemberModel::update($data);
        if($result){
            $this->change_sys_group($type,$this->user['uid'],$info['mid']);
            $info_data['id'] = $info['id'];
            $info_data['list'] = time();
            $info_data['sncode'] = $info['sncode'];
            Content::editData($info['mid'],$info_data);
            
            $url = get_url(murl('member/index',['id'=>$info['id']]));
            $title = $this->user['username'].($money_type ? $this->paymoneymsg : ' 通过授权码 ').' 在你你创建的'.QUN.' '.$info['title'] .' 升级了会员等级';
            $content = ' <a href="'.$url.'" target="_blank">点击查看详情</a>';
            send_msg($info['uid'],$title,$title.$content);
            send_wx_msg($info['uid'], $title.$content);
            
            hook_listen( 'fans_upgroup' , $info  , $this->user);      //监听用户升级
            return $this->ok_js($data,'恭喜你,升级成功!');
        }else{
            return $this->err_js('数据更新失败!');
        }
    }
    
    
    /**
     * 加入圈子或升级用户组
     * @param number $id 圈子ID
     * @param string $sncode 授权码
     * @param number $money 付费加入
     * @param string $act 为up时是升级 为quit时是退出
     * @return void|\think\response\Json|\app\qun\index\wxapp\unknown|void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function join($id=0,$sncode='',$money_type=''){
//         if ($act=='up') {
//             return $this->upgroup($id,$sncode,$money_type);
//         }elseif ($act=='quit') {
//             return $this->quit($id);
//         }
        if(!$this->user){
            return $this->err_js('你还没有登录!');
        }
        $info = Content::getInfoByid($id);
        if(!$info){
            return $this->err_js('ID有误!');
        }
        $where = [
                'aid'=>$id,
                'uid'=>$this->user['uid'],
        ];
        $info_data = [];
        $rs = MemberModel::get($where);
        if($rs){
            if($rs['type']==0||$rs['type']==1){     //普通用户或未审核的用户,重复点击,则提示升级VIP
                return $this->upgroup($id,$sncode,$money_type);
            }else{
                return $this->err_js('你已经加入过了,请不要重复加入!');
            }            
        }elseif($info['autoyz']==-2){
            return $this->err_js('本'.QUN.'禁止任何人加入!');
        }elseif($info['autoyz']==-1){
            if ( empty($info['sncode']) && $info['money']<0.01 ) {
                return $this->err_js('本'.QUN.'设置了授权码或付费才能加入,但管理员还没设置!');
            }elseif ( empty($sncode) && empty($money_type) ) {
                $datas = [
                    'money'=>$info['money'],
                    'money_time'=>$this->get_all_moneytime($info['money_time']),
                ];
                if ( $info['money']>0 && $info['sncode']!='' ) {
                    return $this->err_js('本'.QUN.'需要输入授权码或付费 '.$info['money'].' 元才可以加入!请选择一种加入方式',$datas,3);
                }elseif ( $info['money']>0 && $info['sncode']=='' ) {
                    return $this->err_js('本'.QUN.'需要付费 '.$info['money'].' 元才可以加入!',$datas,4);
                }else{
                    return $this->err_js('本'.QUN.'需要输入授权码才可以加入!',[],2);
                }                
            }
            
            $result = $this->check_join($sncode,$money_type,$info);
            if ($result!==true) {
                return $result;
            }
        }
        
        if ($info['autoyz']==-1 && $info['pay_join_type']>0) {    //指定了加入某个会员组,只有选择付费或授权码方式加入的时候才有效
            $type = $info['pay_join_type'];
        }else {
            $type = 1;
        }
        
        $day = $this->get_moneytime($info,$money_type,'time');
        $end_time = $day ? time()+$day*3600*24 : 0;
        
        $data = [
            'aid'=>$id,
            'uid'=>$this->user['uid'],
            'create_time'=>time(),
            'type'=> $info['autoyz']==0 ? 0 : $type,
            'end_time'=>$end_time,
        ];
        $result = MemberModel::add($data);
        if($result){
            $this->change_sys_group($type,$this->user['uid'],$info['mid']);
            $data['id'] = $result->id;
            $info_data['id'] = $info['id'];
            $info_data['list'] = time();
            Content::editData($info['mid'],$info_data);
            $this->join_msg($info);
            hook_listen( 'fans_join' , $info  , $this->user);      //监听用户加入
            if($info['autoyz']){
                $msg = '恭喜你，加入成功';
            }else{
                $msg = '你的申请信息已提交,请等待圈主审核!';
            }
            if ($info['money']>0 && $type<2){
                $data['upgroup'] = 1;   //给JS提示升级使用
                $msg .= '<br><br>你是否需要马上升级为'.fun('qun@get_group',4).'？';
            }
            return $this->ok_js($data,$msg);
        }else{
            return $this->err_js('数据插入失败!');
        }
    }
    
    
    /**
     * 加入圈子的消息通知
     * @param array $info
     */
    private function join_msg($info=[]){
        $url = get_url(murl('member/index',['id'=>$info['id']]));
        if ($info['autoyz']) {
            $title = $this->user['username'].' 成功加入你创建的'.QUN.' '.$info['title'] . $this->paymoneymsg;
        }else{
            $title = $this->user['username'].' 请求加入你创建的'.QUN.' '.$info['title'].' 请尽快审核!';
        }
        $content = ' <a href="'.$url.'" target="_blank">点击查看详情</a>';
        send_msg($info['uid'],$title,$title.$content);
        send_wx_msg($info['uid'], $title.$content);
    }
    
    /**
     * 退出圈子
     * @param number $id 圈子ID
     */
    public function quit($id=0){
        $map = [
                'aid' => $id,
                'uid' => $this->user['uid']
        ];
        $info = MemberModel::get($map);
        if(!$info){
            return $this->err_js('你并没有加入该'.QUN);
        }elseif ($info['type']==3){
            return $this->err_js('你是创建人,不能退出'.QUN);
        }
        $result = MemberModel::destroy($info['id']);
        if($result){
            Content::addField($id,'usernum',false);
            return $this->ok_js([],'成功退出');
        }else{
            return $this->err_js('数据库执行失败!');
        }
    }
    
    /**
     * 管理员操作
     * @param number $id ID索引
     * @param string $type 操作类型
     * @return \think\response\Json
     */
    public function act($id=0,$type=''){
        $info = getArray(MemberModel::get($id));                                            //要删除的用户信息
        $base_info = Content::getInfoByid($info['aid']);                                    //圈子信息
        $rs = getArray(MemberModel::get(['uid'=>$this->user['uid'],'aid'=>$info['aid']]));  //核查是不是副管理员
        if($rs['type']!=2 && $base_info['uid']!=$this->user['uid']){
            return $this->err_js('你不是管理员,无权操作!');
        }
        if($type=='del'){           //踢除成员
            if($info['type']==3){
                return $this->err_js('不能删除管理员!');
            }
            $reulst = MemberModel::destroy($id);
        }elseif(in_array($type, ['yz','up','down'])){
            if($type=='yz'){             //审核成员
                $data['type'] = 1;
            }elseif($type=='up'){       //提升管理员
                $data['type'] = 2;
            }elseif($type=='down'){     //除为普通成员
                $data['type'] = 1;
            }            
            $reulst = MemberModel::where('id',$id)->update($data);
            if ($reulst) {
                $this->change_sys_group($type,$info['uid'],$base_info['mid']);
            }
        }elseif(is_numeric($type)){
            if (($type==2||$type==3)&&$base_info['uid']!=$this->user['uid']) {
                return $this->err_js('你不是创始人,无权操作!');
            }            
            $reulst = MemberModel::where('id',$id)->update(['type'=>$type]);
            if ($reulst) {
                $this->change_sys_group($type,$info['uid'],$base_info['mid']);
            }
        }
        if($reulst){
            if($type=='yz'){
                $this->yz_msg($base_info,$info['uid']);
            }
            return $this->ok_js([],'操作成功!');
        }else{
            return $this->err_js('数据库执行失败!');
        }        
    }
    
    /**
     * 圈子用户组关联了系统用户组
     * @param number $type 圈子用户组
     * @param number $uid 圈子成员
     * @param number $mid 可以指定圈子的模型ID或者是关键字,否则就是系统默认的用户组
     */
    private function change_sys_group($type=0,$uid=0,$mid=0){
        $groups = fun('qun@get_group',null,$mid);
        $qun_sys_gid = $groups[$type]['sysgid'];    //圈子用户组关联了系统用户组
        $group_array = [];    //找出圈子用户组所关联过的所有系统用户组
        foreach($groups AS $rs){
            if ($rs['sysgid']) {
                $group_array[] = $rs['sysgid'];
            }
        }
        $group_array[] = 8; //普通用户组也算在内
        if ($qun_sys_gid && $qun_sys_gid!=3) {
            $user = get_user($uid);
            if ($user['groupid']!=$qun_sys_gid && in_array($user['groupid'], $group_array)) {
                $array = [
                    'uid'=>$uid,
                    'groupid'=>$qun_sys_gid,
                ];
                edit_user($array);
            }
        }
    }
    
    /**
     * 通过审核的消息通知
     * @param array $info
     * @param number $uid
     */
    private function yz_msg($info=[],$uid=0){
        $url = get_url(urls('content/show',['id'=>$info['id']]));
        $title = '恭喜你，你申请加入 '.$info['title'].' '.QUN.'的请求,已通过审核。';
        $content = '<a href="'.$url.'" target="_blank">点击查看'.QUN.'详情</a>';
        send_msg($uid,$title,$title.$content);
        send_wx_msg($uid, $title.$content);
    }
    
    /**
     * 签到增加浏览量
     * @param number $id
     */
    public function addview($id=0){
        Content::addView($id);
        return $this->ok_js([],'签到成功');
    }
    

    /**
     * 调用圈子成员列表
     * @param number $id 圈子ID
     * @param number $rows 每次取几条
     * @param string $order 可使用的参数排序'id','type','view','update_time'
     * @param string $by 升序或降序
     * @param string $get_username 是否同时获取用户的详细信息
     * @return void|unknown|\think\response\Json
     */
    public function get_member($id=0,$rows=10,$order='',$by='',$get_username=true){
        $data_list = MemberModel::getList($id,$rows,$order,$by,$map=[],$get_username);
         return $this->ok_js($data_list,'调用成功');
    }
    
    /**
     * 某用户加入过的所有圈子
     * @param number $uid
     * @return unknown
     */
    public function my_group($uid=0){
        $listdb = MemberModel::my_group($uid);
        if ($listdb){
            return $this->ok_js($listdb);
        }else{
            return $this->err_js('你还没有加入任何'.QUN);
        }
    }
    
    /**
     * 根据用户UID获取对应圈子里边的用户信息
     * @param number $id
     * @param number $uid
     * @return void|unknown|\think\response\Json|void|\think\response\Json
     */
    public function get_byuid($id=0,$uid=0){
        if (empty($uid)) {
            $uid = $this->user['uid'];
        }
        $where = [
            'aid'=>$id,
            'uid'=>$uid,
        ];
        $rs = MemberModel::where($where)->find();
        if ($rs){
            return $this->ok_js($rs);
        }else{
            return $this->err_js('资料不存在');
        }
    }
    
    /**
     * 修改昵称
     * @param number $id
     * @param number $uid
     * @param string $nickname
     */
    public function edit_nickname($id=0,$uid=0,$nickname=''){
        if (empty($uid)) {
            $uid = $this->user['uid'];
        }
        $where = [
            'aid'=>$id,
            'uid'=>$uid,
        ];
        $info = Content::getInfoByid($id);
        $rs = MemberModel::where($where)->find();
        if (empty($rs)) {
            return $this->err_js('资料不存在');
        }elseif ($uid!=$this->user['uid'] && $info['uid']!=$this->user['uid']){
            return $this->err_js('你没权限修改他人资料');
        }elseif($info['uid']!=$this->user['uid'] && in_array($nickname, ['圈主','群主','管理员','超管','admin','店主'])){
            return $this->err_js('你的昵称不能取名为:'.$nickname);
        }
        if($nickname && MemberModel::where('uid','<>',$uid)->where(['nickname'=>$nickname,'aid'=>$id])->find()){
            return $this->err_js('当前昵称已被使用,请更换一个!');
        }
        $result = MemberModel::where($where)->update(['nickname'=>$nickname]);
        if ($result){
            return $this->ok_js();
        }else{
            return $this->err_js('修改无效');
        }
    }
    
}













