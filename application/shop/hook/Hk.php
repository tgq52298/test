<?php
namespace app\shop\hook;

use think\Db;

class Hk{
    
    public function UserLeave($data=[]){
        $uid = $data['uid'];

        Db::name('memberdata')->where('uid',$uid)->update([
            'lastvist'=>time(),
        ]);
        cache('user_'.$uid,null);
        $info = Db::name('shop_content1')->where('uid',$uid)->order('id desc')->limit(1)->find();
        if ($info['list']<time()) {
            Db::name('shop_content')->where('id',$info['id'])->update([
                'list'=>time(),
            ]);
            Db::name('shop_content1')->where('id',$info['id'])->update([
                'list'=>time(),
            ]);
        }
    }
    
}