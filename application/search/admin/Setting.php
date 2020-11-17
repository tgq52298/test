<?php
namespace app\search\admin;
use app\common\controller\admin\Setting AS _Setting;
class Setting extends _Setting{
	/**
	 * 参数设置
	 * {@inheritDoc}
	 * @see \app\common\controller\admin\Setting::index()
	 */
	public function index($group=null){
		$this->config = [
			[
				'c_key'     => 'search_model',
				'title'     => '开启的模块',
				'c_descrip' => '开启那些模块入库 因为圈子如果有私密内容也会入库 这时可以设置圈子模块不进搜索库 就不会被搜索到 多个用,隔开',
				'form_type' => 'text',
				'c_value'   => 'cms,shop',
				'ifsys'     => 0,
				'list'      => - 1,
			],
			 	[
				'c_key'     => 'search_help',
				'title'     => '帮助文档填写无效',
				'c_descrip' => '新安装的搜索需要导入原来的数据 导入参考：https://x1.php168.com/bbs/show-652.html',
				'form_type' => 'text',
				'c_value'   => '填写此项无效，为了显示帮助文档',
				'ifsys'     => 0,
				'list'      => - 1,
			],
		];
		return parent::index($group);
	}
}

