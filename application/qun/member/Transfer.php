<?php
namespace app\qun\member;

use app\common\controller\MemberBase;
use app\qun\traits\C AS Ctraits;
use app\qun\model\Content;


class Transfer extends MemberBase
{
	use Ctraits;
	
	/**
	 * 圈子转让
	 * @param number $id 圈子ID
	 */
	public function index($id=0){
		$info = $this->check_info($id);
		$timestamp = time();
		$userdb = $this->user;
		$uid = $userdb['uid'];
		if($info['uid'] != $uid){
			$this->error('这不是你的'.QUN.',你没权转让');
		}
		$username = $userdb['username'];
		$strcode = mymd5("$username\t$uid\t$timestamp\t$id");

		$cod_url = get_url(murl('receive',['id'=>$id,'strcode'=>$strcode]));
		$info['picurl'] = tempdir($info['picurl']);

		$this->assign('cod_url',$cod_url);
		$this->assign('info',$info);
		return $this->fetch();
	}
	
	/**
	 * 领取圈子
	 * @param number $id 圈子ID
	 * @param string $mid 领取参数
	 */
	public function receive($id=0,$strcode=''){
		$info = $this->check_info($id);
		if(empty($strcode)){
			$this->error('参数有误');
		}
		if($info['uid']==$this->user['uid']){
			$this->error('不能自己领取自己的 '.QUN.'！');
		}
		list($username,$uid,$ctime,$qid) = explode( "\t" , mymd5($strcode,'DE') );
		if($id != $qid){
			$this->error('ID不一致');
		}
		if($info['uid'] != $uid){
			$this->error('你来晚啦，该 '.QUN.' 已被别人领取了');
		}
		if((time()-$ctime)>1800){
			$this->error("该链接已失效,请联系 {$username} 重新给你发送转让链接");
		}
		$data = [
				'id'=>$id,
				'uid'=>$uid
		];
		//更新对应表的UID
		$result = $this->transfer_update($id,$this->user['uid']);
		if($result){
			$this->success('领取成功',iurl('content/show',['id'=>$id]));
		}
		$this->error('领取失败');
	}
	
	/**
	 * 圈子信息查询
	 * @param number $id 圈子ID
	 * @return  array
	 */
	protected function check_info($id=0){
		if(empty($id)){
			$this->error('参数有误');
		}
		$info = Content::getInfoByid($id);
		if(empty($info)){
			$this->error(QUN."数据不存在!");
		}
		return $info;
	}
	
	
}
