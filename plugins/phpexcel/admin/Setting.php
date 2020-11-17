<?php
namespace plugins\phpexcel\admin;
use app\common\controller\admin\Setting AS _Setting;
 
class Setting extends _Setting{
	public function index( $group = null ) {
		 $this->config = [];
		return parent::index( $group );
	}
}

