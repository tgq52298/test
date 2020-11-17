<?php
namespace plugins\qiniu\admin;
use app\common\controller\admin\Setting AS _Setting;
class Qiniu extends _Setting{
public function index($group=null){
        return parent::index($group);
    }
}

 