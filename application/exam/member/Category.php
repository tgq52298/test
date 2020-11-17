<?php
namespace app\exam\member;

use app\common\controller\MemberBase;
use app\exam\model\Category as CategoryModel;
use app\exam\model\Info as InfoModel;

//试卷

class Category extends MemberBase
{    
    public function  index()
    {
        $listdb=CategoryModel::where([])->paginate(10);
         
        $pages = $listdb->render();
        $listdb=getArray($listdb)['data'];
        
        foreach($listdb AS $key=>$rs){
            $rs['number']=InfoModel::where(['cid'=>$rs['id']])->count();
            $rs['fenone']=round(100/ $rs['number'],2);
            $listdb1[]=$rs;
        }
        
        
        $this->assign('listdb',$listdb1);
        $this->assign('pages',$pages);
        
        return $this->fetch();
    }
    
}