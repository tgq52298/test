<?php
namespace app\qun\member;

use app\common\controller\MemberBase;
use app\qun\model\Content;
use app\common\traits\AddEditList;
use app\qun\model\Claim AS ClaimModel;
use app\qun\traits\C AS Ctraits;

//认领圈子
class Claim extends MemberBase
{
    use AddEditList,Ctraits;
    
    protected function _initialize()
    {
        parent::_initialize();
        $this->model = new ClaimModel();
    }
    
    public function delete()
    {
        die('禁止访问!');
    }
    public function edit()
    {
        die('禁止访问!');
    }
    
    public function index()
    {
        die('禁止访问!');
    }
    
    /**
     * 处理申领情况
     * @param number $id
     * @param number $type 1 接受转让申请, -1回绝
     */
    public function act($id=0,$type=0){
        $info = getArray( $this->getInfoData($id) );
        if ( empty($info) ) {
            $this->error('信息不存在');
        }
        $qun = fun('qun@getByid',$info['aid']);
        if ( empty($qun) ) {
            $this->error(QUN.'不存在');
        }
        if ( $this->user['uid']!=$qun['uid'] ) {
            $this->error('你无权操作');
        }
        $data = [
                'id'=>$id,
                'status'=>$type,
                'update_time'=>time(),
        ];
        
        if ($type==1) {
            $result = $this->transfer_update($qun['id'],$info['uid']);
            if($result){
                $data['owner_uid'] = $qun['uid'];
                ClaimModel::update($data);
                
                $title =  ' 恭喜你,你申领的 ' . $qun['title'] . ' ' .QUN.' 被同意转让给你了!';
                $content = $title . ', <a target="_blank" href="'.get_url( iurl('content/show',['id'=>$qun['id']]) ).'">点击查看详情</a> ';
                send_msg($info['uid'],$title,$content);
                send_wx_msg($info['uid'], $content);
                
                $this->success('转让成功',iurl('content/show',['id'=>$qun['id']]));
            }else{
                $this->error('转让失败');
            }
        }elseif ($type==-1){
            ClaimModel::update($data);
            
            $title =  ' 很抱歉,你申领的 ' . $qun['title'] . ' ' .QUN.' 被回绝了!';
            $content = $title; // . ', <a href="'.get_url( iurl('show',['id'=>$id]) ).'">点击查看详情</a> ';
            send_msg($info['uid'],$title,$content);
            send_wx_msg($info['uid'], $content);
            
            $this->success('你已拒绝',iurl('content/show',['id'=>$qun['id']]));
        }else{
            $this->error('操作类型有误!');
        }        
    }
    
    /**
     * 显示申领信息
     * @param number $id 信息记录ID
     * @return \app\common\traits\unknown
     */
    public function show($id=0){
        
        $info = getArray( $this->getInfoData($id) );
        $qun = fun('qun@getByid',$info['aid']);
        
        if (!in_array($this->user['uid'], [ $info['owner_uid'],$qun['uid'] ])) {
            $this->error('你无权查看');
        }
        
        $this->tab_ext['page_title'] = '申请详情';

        $this->form_items = [
                ['callback', 'aid','申领'.QUN,'',function($value){
                    return fun('qun@getByid',$value)['title'];
                }],
                ['callback', 'uid', '申请人帐号','',function($value){
                    return get_user_name($value);
                }],
                ['text', 'linkman', '联系人'],
                ['text', 'telphone', '联系电话'],
                ['text', 'email', '联系邮箱'],
                ['textarea', 'why', '认领原因'],
                ['image', 'picurl', '证件扫描件'],
                ['callback', 'status', '处理状态','',function($value,$rs){
                    if($value==1){
                        return '已接受申领';
                    }elseif($value==-1){
                        return '已拒绝申领';
                    }else{
                        return "<a href='".urls('act',['id'=>$rs['id'],'type'=>1])."' class='layui-btn layui-btn-normal layui-btn-sm'>接受</a><a href='".urls('act',['id'=>$rs['id'],'type'=>-1])."' class='layui-btn layui-btn-danger layui-btn-sm'>拒绝</a>";
                    }
                    return get_user_name($value);
                }],
                ['callback', 'picurl', '证件复印件','',function($value){
                    if($value){
                        $value = tempdir($value);
                        return "<a href='$value' target='_blank'><img src='$value' style='max-width:80%;'></a>";
                    }                    
                }],
        ];
        $info = fun('field@format',$info,'','show','',$this->form_items);  //数据转义
 
        return $this->getAdminShow($info) ;
    }
    
    /**
     * 用户申请圈子
     * @param number $aid 圈子ID
     * @return unknown
     */
    public function add($aid=0){
        $info = Content::getInfoByid($aid,true);
        if(!$info){
            $this->error('ID有误,或者 ' . QUN . ' 不存在');
        }
        if (ClaimModel::get(['aid'=>$aid,'uid'=>$this->user['uid'],'status'=>0])) {
            $this->error('请不要反复认领');
        }
        if ($this -> request -> isPost()) {
            $aid = input('aid');
            if ($result = $this -> saveAddContent()) {
                $id = $result->id;
                $title = $this->user['username'] . ' 向你申领 ' . $info['title'] . ' ' .QUN;
                $content = $title . ', <a href="'.get_url( urls('show',['id'=>$id]) ).'">点击查看详情</a> ';
                send_msg($info['uid'],$title,$content);
                send_wx_msg($info['uid'], $content);
                $url = iurl("content/show",['id'=>$aid]);
                $this -> success('申请信息已提交,请耐心等待审核', $url);
            } else {
                $this -> error('信息提交失败');
            }
        }
        $this->tab_ext['page_title']='认领 ' . $info['title'] . ' ' .QUN;
        $this->form_items = [
                ['text', 'linkman', '联系人','',$this->user['truename']?:$this->user['username']],
                ['text', 'telphone', '联系电话','',$this->user['mobphone']],
                ['text', 'email', '联系邮箱','',$this->user['email']],
                ['textarea', 'why', '认领原因'],
                ['image', 'picurl', '证件扫描件'],
                ['hidden', 'aid', $aid],
        ];
        
        return $this->addContent();
	}

}
