<?php
namespace app\qun\index;

//use think\Request;

class Error extends Base{
    
    /**
     * 重写这个方法,为的是 针对小程序二维码的特别处理 对应的函数是 fun('wxapp@qun_code')
     * {@inheritDoc}
     * @see \app\common\controller\IndexBase::_initialize()
     */
    protected function _initialize(){
        $controller = request()->controller();
        if (preg_match('/^Show-bbs@add_([\d]+)_([\d]+)$/', $controller)) {
            preg_match('/^bbs@add_([\d]+)_([\d]+)$/i', input('my_qid'),$array);
            $url = urls("bbs/content/add",['fid'=>$array[1],'ext_id'=>$array[2]]).'?sec_up=1';
            $this->redirect($url,301);
        }elseif (preg_match('/^Show-([\d]+)p([\d]*)$/', $controller)) {
            list($id,$p_uid) = explode('p',input('my_qid'));
            $url = urls('content/show',['id'=>$id,'p_uid'=>$p_uid]);
            $this->redirect($url,301);
        }elseif (preg_match('/^Show-([\w@]+)_([\d]+)$/', $controller)) {  //这里主要是针对小程序二维码的特别处理 对应的函数是 fun('wxapp@qun_code')
            preg_match('/^([\w@]+)_([\d]+)$/i', input('my_qid'),$array);
            list($sysname,$pagetype) = explode('@',$array[1]);
            $pagetype || $pagetype='show';
            $id = $array[2];
            if (modules_config($sysname)) {
                $url = urls("$sysname/content/$pagetype",['id'=>$id]);
            }else{
                $url = purl("$sysname/content/$pagetype",['id'=>$id]);
            }
            $this->redirect($url,301);
        }
        parent::_initialize();
    }
    
//     public function index(Request $request)
//     {
//         $cityName = $request->controller();
//         return $this->model($cityName);
//     }
    
//     //注意是 protected 方法
//     protected function model($name)
//     {
//          return '当前请求的控制器是' . $name;
//     }
	
}