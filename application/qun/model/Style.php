<?php

namespace app\qun\model;

use think\Model;
use think\Db;

//圈子风格
class Style extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table;// = '__FORM_MODULE__';
    
    //以下三项必须在这里先赋值，不然下面的重新定义table会不生效
    protected $autoWriteTimestamp = false;   // 自动写入时间戳
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $resultSetType = 'array';
    
    protected static $base_table;
    protected static $model_key;
    protected static $table_pre;
    
    //为了调用initialize初始化,生成数据表前缀$model_key
    protected static function scopeInitKey(){}
    protected function initialize()
    {
        parent::initialize();
        preg_match_all('/([_a-z]+)/',get_called_class(),$array);
        self::$model_key = $array[0][1];
        self::$base_table = $array[0][1].'_content';
        self::$table_pre = config('database.prefix');
        //字段表，带数据表前缀如qb_form_field
        $this->table = self::$table_pre.self::$model_key.'_buystyle';
    }
    
    public static function test(){
    	return self::where('uid',1)->find();
    }
    
    /**
     * 查询用户购买风格记录
     * @param array $map
     * @return bool
     */
    public static function checkBuyStyle($map=[]){
  
    	$check=0;
    	$checkbuy = self::where($map)->find();
    	
    	if($checkbuy['endtime']>time()){
    		$check=1;
    	}

    	return $check;
    }
    
    /**
     * 购买风格
     * @param array $map
     * @return bool
     */
    function buySTyle($map=[]){
    	$checkbuy = self::checkBuyStyle($map);//查询用户购买风格记录
    	$timestamp = time();
    	if($checkbuy){
    		$endtime=$checkbuy['endtime']>$timestamp?$checkbuy['endtime']+31536000:$timestamp+31536000;
    		$data = ['endtime'=>$endtime];
    		$result = self::where($map)->update($data);
    	}else{
    		$data['uid'] = $map['uid'];
    		$data['pageid'] = $map['pageid'];
    		$data['stylename'] = $map['stylename'];
    		$data['create_time'] = time();
    		$data['endtime'] = $timestamp+31536000;
    		
    		$result = self::insert($data);
    	}
    	return $result;
    }
    
    /**
     * 更新内容表风格
     * @param array $map
     * @return bool
     */
    public static function updateContent($id=0,$stylename=''){
    	
    	$contents = Db::name('qun_content')->where('id',$id)->find();
    	if(!$contents){
    		return false;
    	}
    	$table = 'qun_content'.$contents['mid'];
    	$map = ['id'=>$contents['id'],'uid'=>$contents['uid']];
    	$contentdb = Db::name($table)->where($map)->find();
    	if(!$contentdb){
    		return false;
    	}
    	$result = Db::name($table)->where($map)->setField('style',$stylename);
    	return $result;
    }
    
    
    
    
}
