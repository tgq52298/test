<?php
namespace app\weibo\admin;

use app\common\controller\admin\C;
use app\cms\traits\Content AS TraitsContent;

class Content extends C
{
    use TraitsContent;
    protected function deleteOne($id=0,$mid=0){
        hook_listen('qun_delete_begin',$id);
        $result = parent::deleteOne($id,$mid);
        if($result){
            hook_listen('qun_delete_end',$id);
        }
        return $result;
    }
    
    public function listall(){
        $this->tab_ext['page_title'] = '微博管理';
        $this->tab_ext['top_button'] = [
                ['type'=>'delete'],
        ];
        $this->list_items =  [
                ['title', '微博名称', 'link',iurl('content/show',['id'=>'__id__']),'_blank'],
                ['fid', '所属分类', 'select',$this->s_model->getTitleList(),config('system_dirname')],                
                ['create_time', '登记日期', 'datetime'],
                ['view', '浏览量', 'text.edit'],
                ['list', '排序值', 'text.edit'],
                ['status', '审核', 'select',['未审','已审','已推荐']],
        ];
        return parent::listall();
    }
    
    
    public function index($fid=0,$mid=0,$type=''){
        if($type=='listall'){   //放在这里的话,就省去再单独的设置后台权限
            return $this->listall();
        }
        if(!$mid && !$fid){
            return $this->listall();
        }elseif($fid){
            $mid = $this->model->getMidByFid($fid);
        }        
        $this->mid = $mid;   //这个是必须的
        
        $this->tab_ext['nav'] = [ $this->nav() , $mid];
        $this->tab_ext['page_title'] = '微博管理';
        
        $this->tab_ext['top_button'] = [
                ['type'=>'delete'],
        ];
        $array =  [
                ['fid', '所属栏目', 'select',$this->s_model->getTitleList(),config('system_dirname')],
                ['create_time', '创建日期', 'datetime'],
                ['view', '浏览量', 'text.edit'],
                ['list', '排序值', 'text.edit'],
                ['status', '审核', 'select',['未审','已审','已推荐']],
        ];
        $this->list_items = array_merge(
                $this->getEasyIndexItems(),  //列表要显示的自定义字段
                $array
                );
        $data = self::getListData($fid ? ['fid'=>$fid] : ['mid'=>$mid]);
        return $this->getAdminTable($data);
    }
    
}
