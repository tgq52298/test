<?php 
use app\common\util\Shop AS ShopFun;
use app\gongdan\model\Content AS ContentModel;
if(!function_exists('get_shop_type')){
    /**
     * 取得商品属性 , $key 为 null 的话,商品内容页使用,全部列出给用户选择
     * @param string $type              属性类型,可以是 type1 type2 type3 分别可以为尺寸\颜色\长短
     * @param array $info               商品主表的内容信息
     * @param unknown $key          为null的话,商品详情页使用,所有各项参数展示出来,为数值的话,就是用户选中购买的具体类型
     * @param string $result_type   要取得属性的名称,还是价格,一般都是名称.
     * @return void|array|unknown[]|array[]
     */
    function get_shop_type($type='type1',$info=[],$key=null,$result_type='title'){
        return ShopFun::type_get_title_price($type,$info,$key,$result_type);
    }   
    
    /**
     * 获取当前工单的状态
     * @param number|array $id 工单模板ID或内容
     */
    function status_type($id=0,$type=null){
        if (is_numeric($id)) {
            $info = ContentModel::getInfoByid($id);
        }else{
            $info = $id;
        }
        $status_type = $info['status_type'];
        $data = $status_type ? json_decode($status_type,true) : [];
        $array = ['待处理'];
        foreach($data AS $value){
            if($value){
                list($title) = explode('|', $value);
                $array[] = $title;
            }
        }
        return $type!==null?$array[$type]:$array;
    }
    
    /**
     * 检查用户是否接收通知权限
     * @param number $id
     * @param array $user
     * @return boolean
     */
    function check_notice($id=0,$user=[]){
        if (empty($user)) {
            $user = login_user();
        }
        if (is_numeric($id)) {
            $info = ContentModel::getInfoByid($id);
        }else{
            $info = $id;
        }
        $qun_id = $info['ext_id'];
        if (!$qun_id) {
            $qun_id = end(fun('qun@getByuid',$info['uid']))['id']; //圈子ID
        }
        if ( $info['notice_group']!='' && in_array($user['qun_group'][$qun_id]['type'], explode(',', trim($info['notice_group'],','))) ) {
            return true;
        }
    }
    
    /**
     * 获取指定用户具有哪些菜单权限
     * @param number number|array $id 工单模板ID或内容
     * @param array $user 用户的登录信息
     * @param string $check_notice_power 是否同时检查有查看通知权限,但不一定有设置状态的权限
     * @return string[]|array[]
     */
    function status_power($id=0,$user=[],$check_notice_power=false){
        if (empty($user)) {
            $user = login_user();
        }
        if (is_numeric($id)) {
            $info = ContentModel::getInfoByid($id);
        }else{
            $info = $id;
        }
        $qun_id = $info['ext_id'];
        if (!$qun_id) {
            $qun_id = end(fun('qun@getByuid',$info['uid']))['id']; //圈子ID
        }
        $status_type = $info['status_type'];
        $data = $status_type ? json_decode($status_type,true) : [];
        $array = [];
        $i = 0;
        foreach($data AS $value){            
            if($value){
                $i++;
                list($title,$gids) = explode('|', $value);
                $gid_array = explode(',',trim($gids,','));
                if ( ($gid_array&&$qun_id&&in_array($user['qun_group'][$qun_id]['type'], $gid_array)) || $info['uid']==$user['uid'] ) {
                    $array[$i] = $title;
                }                
            }
        }
        if (empty($array) && $check_notice_power && $info['notice_group']!='' && in_array($user['qun_group'][$qun_id]['type'], explode(',', trim($info['notice_group'],','))) ) {
            return true;
        }
        return $array;
    }
    
    /**
     * 设置某种状态后需要需要通知的用户组
     * @param number number|array $id 工单模板ID或内容
     * @param number $type 当前状态
     * @return array
     */
    function status_notice($id=0,$type=0){
        if (is_numeric($id)) {
            $info = ContentModel::getInfoByid($id);
        }else{
            $info = $id;
        }
        $status_type = $info['status_type'];
        $data = $status_type ? json_decode($status_type,true) : [];
        $i = 0;
        foreach($data AS $value){
            if($value){
                $i++;
                if ($type==$i) {
                    list(,,$gids) = explode('|', $value);
                    return explode(',',trim($gids,','));
                }          
            }
        }
        return [];
    }
}