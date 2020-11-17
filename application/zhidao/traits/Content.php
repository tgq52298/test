<?php
namespace app\zhidao\traits;
use app\common\controller\member\C;
use app\zhidao\model\Content AS _Content;

trait Content
{
    /**
     * 同时适用于前台与后台 新增加后做个性拓展
     * @param number $id 内容ID
     * @param number $data 内容数据
     */
    protected function end_add($id=0,$data=[]){
        if($data['money']>0){
            if(login_user()['money']>=$data['money']){
                add_jifen(login_user()['uid'],-$data['money']," 发布《{$data[title]}》问题,悬赏{$webdb[MoneyName]}");
            }else{
                add_jifen(login_user()['uid'],-login_user()['money']," 发布《{$data[title]}》问题,悬赏{$webdb[MoneyName]}");
            $editdb=array('id'=>$id,'money'=>login_user()['money']);
           _Content::editData(0,$editdb);
            }
           
        }
    }

    /**
     * 同时适用于前台与后台 修改前做处理
     * @param number $id 内容ID
     * @param array $data 内容数据
     */
    protected function check_edit($id=0,$data=[]){
        $info = $this->getInfoData($id);
        if($data){//有提交内容则进行检测
            $disparity_money=$data['money']-$info['money'];//奖励差额，大于0增加
            if($disparity_money>0){
                if($disparity_money>login_user()['money']){
                    return "你的{$this->webdb['MoneyName']}不足以支付填写悬赏的数值，请重新操作!";
                }else{
                     add_jifen(login_user()['uid'],-$disparity_money," 修改《{$info[title]}》问题,增加悬赏{$webdb[MoneyName]}");
                }
          }
        }
        // return true;
    }


    /**
     * 同时适用于前台与后台 修改后做个性拓展
     * @param number $id 内容ID
     * @param array $data 内容数据
     */
    protected function end_edit($id=0,$data=[]){

    }
    
    /**
     * 同时适用于前台与后台 删除后做个性拓展
     * @param number $id 内容ID
     * @param array $info 内容数据
     */
//     protected function end_delete($id=0,$info=[]){
//     }
}