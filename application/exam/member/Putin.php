<?php
namespace app\exam\member;

use app\common\controller\MemberBase;
use app\exam\model\Category as CategoryModel;
use app\exam\model\Putin as MePutin;

//我的试卷

class Putin extends MemberBase
{    
    public function  index()
    {
        $listdb=MePutin::where(['uid'=>$this->user['uid']])->paginate(3);
         
        $pages = $listdb->render();
        $listdb=getArray($listdb)['data'];
        
        foreach($listdb AS $key=>$rs){
            $rs['name']=CategoryModel::where(['id'=>$rs['paperid']])->value('name');
            $listdb1[]=$rs;
        }
        
        $this->assign('listdb',$listdb1);
        $this->assign('pages',$pages);
        
        return $this->fetch();
    }
    
}