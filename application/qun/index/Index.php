<?php
namespace app\qun\index;

use app\common\controller\index\Index AS _Index;

//频道主页
class Index extends _Index
{
    public function index(){
        $dispatch = $this->request->dispatch();
        return parent::index();
    }
    
    /**
     * 我的圈子
     */
    public function my(){
        //我创建的圈子
        $array = fun('qun@getByuid',$this->user['uid']);
        if ($array){
            $id = array_shift($array)['id'];
            $this->redirect('content/show',['id'=>$id]);
        }
        
        //我加入的圈子
        $array = fun('qun@myjoin',$this->user['uid']);
        if ($array){
            $id = array_shift($array)['id'];
            $this->redirect('content/show',['id'=>$id]);
        }
        
        //我最近访问过的圈子
        $array = fun('qun@myvisit',$this->user['uid']);
        if ($array){
            $id = array_shift($array)['id'];
            $this->redirect('content/show',['id'=>$id]);
        }
        
        //扫码进来的
        $id = get_cookie('HYID');
        if ($id) {
            $this->redirect('content/show',['id'=>$id]);
        }
        
        $this->redirect('index');
    }
    
}