<?php
namespace app\hr\admin;

use app\common\controller\admin\C;
use app\hr\traits\Content AS TraitsContent;


class Content extends C
{	
    use TraitsContent;


   
    /**
     * 列出所有内容，可以根据栏目ID或者模型ID，但不能为空，不然不知道调用什么字段
     * @param number $fid
     * @param number $mid
     * @param string $type 为listall值的话,显示所有,在这里调用的目的是为了省去再单独的设置后台权限
     * @return mixed|string
     */
    public function index($fid=0,$mid=0,$type='')
    {    

        if($type=='listall'){   //放在这里的话,就省去再单独的设置后台权限
        	// $this->redirect('Content/index', ['mid' => 1]); //所有内容重定向到职位管理
            return $this->listall();
        }elseif($type=='excel'){
            return $this->excel($mid,input()['ids']);
        }
        if(!$mid && !$fid){
        	  $this->redirect('Content/index', ['mid' => 1]); //内容管理重定向到职位管理
            // return $this->listall();
        }elseif($fid){ //根据栏目选择发表内容
            $mid = $this->model->getMidByFid($fid);
        }
        
        $this->mid = $mid;
     
        if(empty($this->list_items)){
        	if($mid==2){
            $array =  [
                    // ['fid', '所属栏目', 'select',$this->s_model->getTitleList(),config('system_dirname')],
                    //['mid', '所属模型', 'select2',$this->m_model->getTitleList()],
                    ['uid', '发布者', 'callback',function($value){
                        $array = get_user($value);
                        return $array['username'];
                    }],
                    ['create_time', '创建日期', 'datetime'],
                    ['view', '浏览量', 'text.edit'],
                    ['list', '排序值', 'text.edit'],
                    ['status', '审核', 'select',['未审','已审','已推荐']],
            ];
        	}else{
            $array =  [
                    ['fid', '所属栏目', 'select',$this->s_model->getTitleList(),config('system_dirname')],
                    //['mid', '所属模型', 'select2',$this->m_model->getTitleList()],
                    ['uid', '发布者', 'callback',function($value){
                        $array = get_user($value);
                        return $array['username'];
                    }],
                    ['create_time', '创建日期', 'datetime'],
                    ['view', '浏览量', 'text.edit'],
                    ['list', '排序值', 'text.edit'],
                    ['status', '审核', 'select',['未审','已审','已推荐']],
            ];        		
        	}

            
            //比如万能表单是不需要栏目的，就不要显示栏目
            if(empty(config('post_need_sort'))){
                unset( $array[0] );
            }
            
            //列表显示哪些字段
            $this->list_items = array_merge(
                    $this->getEasyIndexItems(),  //列表要显示的自定义字段
                    $array
                    );            
        }
        return parent::index($fid,$mid,$type);

    }
    
    /**
     * 模型分类导航
     * @return string[][]|NULL[][]|unknown[][]
     */
    protected function nav(){
        $mlist = $this->m_model->getTitleList();
        foreach ( $mlist AS $key => $value) {
            $tab_list[$key] = [
                    'title'=>$value,
                    'url'=>auto_url('index', ['mid' => $key]),
            ];
        }
        return $tab_list;
    }



}
