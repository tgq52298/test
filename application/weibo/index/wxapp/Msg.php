<?php
namespace app\weibo\index\wxapp;

use app\weibo\model\Content;
use app\common\controller\IndexBase;
use think\Db;

class Msg extends IndexBase
{
    
    /**
     * 检查是否有新动态
     * @return void|\think\response\Json
     */
    public function checknew(){
        $num = query(Content::getTableByMid(1),[
                'where' => ['id'=>$this->user['uid']],
                'value' => 'msgnum',
        ]);
        if($num>0){
            return $this->ok_js(['num'=>$num]);
        }else{
            return $this->err_js('没有新消息');
        }
    }
    
    /**
     * 清空消息数目
     * @return void|unknown|\think\response\Json
     */
    public function delete()
    {
        if ( Db::name( Content::getTableByMid(1) )->where(['id'=>$this->user['uid']])->update(['msgnum'=>0]) ) {
            return $this->ok_js();
        }else{
            $this->err_js('删除失败');
        }
    }
}
