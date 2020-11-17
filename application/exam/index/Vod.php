<?php
namespace app\exam\index;


use app\common\controller\IndexBase;


class Vod extends IndexBase
{
    /**
     * 列出自己创建的试卷
     * @param number $aid 圈子ID
     * @return mixed|string
     */
    public function index($aid=0){
        $this->assign('aid',$aid);
        return $this->fetch();
    }
}
