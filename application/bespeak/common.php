<?php
use think\Db;
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
        return fun('shop@type_get_title_price',$type,$info,$key,$result_type);
    }    
}

if(!function_exists('get_ordernum')){
    /**
     * 获取当前商家预约单数量
     * @param number $id 商家信息ID
     * @return number 预约单数量
     */
    function get_ordernum($id=0){
        $table=config('system_dirname').'_order';
        $this_ordernum = Db::name($table)->where('shopid',$id)->count();
        return $this_ordernum;
    }    
}

if(!function_exists('get_one_contents')){
    /**
     * 获取当前商家信息ID对应的内容
     * @param number $id 商家信息ID
     * @return array 商家信息
     */
    function get_one_contents($id=0){
        $table = config('system_dirname').'_content'; //索引表
        $mid = Db::name($table)->where('id',$id)->value('mid'); //根据索引表获取模型ID
        $order_table=config('system_dirname').'_content'.$mid; //模型内容表
        $this_info = Db::name($order_table)->where('id',$id)->find();
        return $this_info;
    }    
}

if(!function_exists('this_model_config')){
    /**
     * 获取当模块后台设置的参数
     * @return array 设置的参数
     */
    function this_model_config(){
        $model_name=config('system_dirname');
        $config_name = 'M__'.$model_name;
        $this_config = config('webdb')["$config_name"];
        return $this_config;
    }    
}