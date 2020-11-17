<?php
namespace plugins\guestbook\admin;

use app\common\controller\admin\C;
use plugins\guestbook\traits\Content AS TraitsContent;

class Content extends C
{
    use TraitsContent;
    protected $validate;
    
    public function add($fid=0,$mid=0){
        return parent::add($fid,$mid);
    }
    public function edit($id){
        return parent::edit($id);
    }
    
    public  function postnew($mid = 0){
        if (config('post_need_sort')==true) {
            return self::chooseSort($mid);
        }else{
            return self::chooseModule();
        }
    }
    
    
    /**
     * 显示所有模型的内容
     * {@inheritDoc}
     * @see \app\common\controller\admin\C::listall()
     */
    public function listall(){
        //列表选项
        $this->list_items =  [
                //['title', '主题', 'link',iurl('content/show',['id'=>'__id__']),'_blank'],
                ['fid','所属分类','select2',get_sort(0,'name','all')],
                ['uid', '提交者', 'username'],
                ['create_time', '提交日期', 'datetime'],
        ];
        
        $this->tab_ext['page_title'] = '所有内容管理';
        $this->tab_ext['nav'] = [ $this->nav() , 0];    //导航菜单
        
        //右边菜单
        $this->tab_ext['right_button'] = [
                ['type'=>'delete'],
                ['type'=>'edit'],
                [
                        'title'=>'查看',
                        'icon'=>'fa fa-wpforms',
                        'url'=>iurl('content/show',['id'=>'__id__']),
                        'target'=>'_blank',
                ],
        ];
        
        //顶部菜单
        $this->tab_ext['top_button'] = [
                [
                        'title' => '查看前台',
                        'icon'  => 'fa fa-plus',
                        'target' => '_blank',
                        'href'  => iurl('content/index')
                ],
                [
                        'type'       => 'delete',
                ],
        ];
        
        $data = $this->model->getAll();
        return $this->getAdminTable($data);
    }
    
    /**
     * 按模型显示内容列表
     * {@inheritDoc}
     * @see \app\common\controller\admin\C::index()
     */
    public function index($fid=0,$mid=0,$type=''){
        
        if($type=='listall'){   //放在这里的话,就省去再单独的设置后台权限
            return $this->listall();
        }elseif($type=='excel'){
            return $this->excel($mid,input()['ids']);
        }
        
        if($type!='listall' && !$mid && !$fid && count(model_config())==1){
            $mid = reset(model_config())['id'];
        }
        
        if(!$mid && !$fid){
            return $this->listall();
        }elseif($fid){
            $mid = $this->model->getMidByFid($fid);
        }
        
        $this->mid =$mid;   //指定模型内容
        
        $this->tab_ext['page_title'] = model_config($mid)['title'] . ' 内容管理';
        
        $this->tab_ext['nav'] = [ $this->nav() , $mid];     //导航菜单
        
        //列表显示哪些字段
        $this->list_items = array_merge(
                [
                    ['fid','所属分类','select2',get_sort(0,'name','all')], 
                    ['status','审核与否','switch',],
                    ['content','内容','callback',function($k,$rs){
                        return " <textarea style='width:auto; height:auto;'>{$k}</textarea>";
                    }],
                ],
                $this->getEasyIndexItems(),  //列表要显示的自定义字段
                [
                        ['uid', '提交者', 'callback',function($value){
                            $array = get_user($value);
                            return $array['username'];
                        }],
                        ['create_time', '提交日期', 'datetime'],
                ]
        );
        
        //顶部菜单
        $this->tab_ext['top_button'] = [
//                 [
//                         'title' => '登记内容',
//                         'icon'  => 'fa fa-plus',
//                         'class' => 'btn btn-primary',
//                         'href'  => auto_url('add',$fid?['fid'=>$fid]:['mid'=>$mid])
//                 ],
                [
                        'title' => '查看前台',
                        'icon'  => 'fa fa-plus',
                        'target' => '_blank',
                        'href'  => iurl('content/index')
                ],
                [
                        'type'       => 'delete',
                ],
//                 [
//                         'title'       => '导出Excel表格',
//                         'icon'        => 'fa fa-indent',
//                         'class'       => 'btn btn-primary ajax-post confirm',
//                         'target-form' => 'ids',
//                         'href'        => auto_url('index',['mid'=>$mid,'type'=>'excel'])
//                 ],                
        ];
        
        //右边菜单
        $this->tab_ext['right_button'] = [
                ['type'=>'delete'],
                ['type'=>'edit'],
                [
                        'title'=>'查看',
                        'icon'=>'fa fa-wpforms',
                        'url'=>iurl('content/show',['id'=>'__id__']),
                        'target'=>'_blank',
                ],
        ];
        
        $data = self::getListData($fid ? ['fid'=>$fid] : ['mid'=>$mid]);
        return $this->getAdminTable($data);
    }

}
