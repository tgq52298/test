<?php
namespace plugins\kuaidi\admin;
use app\common\controller\admin\Setting AS _Setting;
class Shezhi extends _Setting{
	public function index($group=null){
		$this->config=[
			[
				'c_key'    =>'kuaidi_type',
				'title'    =>'选择快递',
				'c_descrip'=>' 因为每家的查询指令不一致，选择后最好不要更改 快递鸟免费版仅支持申通、圆通、中通三家每天限制500次 收费版全支持。快递100免费版不需要申请 支持顺丰快递 快宝查询 免费1万次每天免费20次 除了快递100其他的查询顺丰需要传递手机号后四位',
				'c_value'  =>'1',
				'form_type'=>'radio',
				'options'  =>"1|快递鸟免费版|kuaidi_EBusinessID,kuaidi_AppKey\r\n2|快递鸟收费版|kuaidi_EBusinessID,kuaidi_AppKey\r\n3|快递100\r\n4|快宝|kuaidi_appid,kuaidi_APIkey",
				'ifsys'    =>0,
				'list'     =>9999,
			],
			[
				'c_key'    =>'kuaidi_appid',
				'title'    =>'快宝app_id',
				'c_descrip'=>'https://open.kuaidihelp.com/control/info 中用户ID输入到这里',
				'form_type'=>'text',
				'c_value'  =>'',
				'ifsys'    =>0,
				'list'     =>-1,
			],
			[
				'c_key'    =>'kuaidi_APIkey',
				'title'    =>'快宝 API key',
				'c_descrip'=>'https://open.kuaidihelp.com/control/info 中API key输入到这里',
				'form_type'=>'text',
				'c_value'  =>'',
				'ifsys'    =>0,
				'list'     =>-1,
			],
			[
				'c_key'    =>'kuaidi_huancun',
				'title'    =>'查询缓存时间',
				'c_descrip'=>'秒 因为快宝是查询一次减少一次 这里设置缓存可以有效减少费用 默认一天',
				'form_type'=>'text',
				'c_value'  =>'86400',
				'ifsys'    =>0,
				'list'     =>-1,
			],
		];
		$this->tab_ext = [ 'help_msg'=>'快递鸟免费版仅支持申通、圆通、中通每天限量500个单号查询。<br>快递鸟收费版1280元一年支持2万个单号 3990元一年支持7万单号可以自己看价格。<br>快递100 免费使用，稳定性不保证，测试了40个单号稳定查询 支持顺丰查询并且不需要手机号后四位<br>快宝免费一万次不是一万单号 查询一次算一次，所以加了缓存减少查询的次数，免费一万次用完了每天免费20次 5元1千次 45元1万次 自己去看价格<br><a href="http://www.kdniao.com/" target="_blank" style="color: #ed2822">点此注册快递鸟</a> 完成实名认证后开通 《物流查询》免费版服务即可  收费版开通《物流追踪》<br><a href="https://open.kuaidihelp.com/home" target="_blank" style="color: #ed2822">点此注册快宝</a> 实名认证后开通《物流查询》即可'];
		return parent::index($group);
	}

}

 