<?php
namespace app\qun\member;

use app\common\controller\MemberBase;
use app\qun\model\Content AS Model;

class Choose extends MemberBase
{
    /**
     * 主要是对于有多个圈子的话,要给用户做选择操作
     * @param string $url 想要执行的操作
     * @return mixed|string
     */
    public function index($url=''){
        if (empty($url)) {
            $this->error('url参数不存在');
        }
        $listdb = Model::getIndexByUid($this->user['uid']);
        if (count($listdb)==1) {
            $id = end($listdb)['id'];
            $this->redirect($url.$id,[],301);
        }elseif(empty($listdb)){
            $this->error('你还没有'.QUN.',点击下一步,立即创建一个',iurl('content/add'));
        }
        foreach($listdb AS $key=>$rs){
            $rs = Model::getInfoByid($rs['id']);
            $rs['url'] = $url.$rs['id'];
            $listdb[$key] = $rs;
        }
        $this->assign('listdb',$listdb);
        return $this->fetch();
    }
}