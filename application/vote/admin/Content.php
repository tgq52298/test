<?php
namespace app\vote\admin;

use app\common\controller\admin\C;
use app\vote\traits\Content AS TraitsContent;


class Content extends C
{
    use TraitsContent;


    /**
     * 列出所有内容，可以根据项目ID或者模型ID，但不能为空，不然不知道调用什么字段
     * @param number $fid
     * @param number $mid
     * @param string $type 为listall值的话,显示所有,在这里调用的目的是为了省去再单独的设置后台权限
     * @return mixed|string
     */
    public function index($fid=0,$mid=0,$type='')
    {     
        if($type=='listall'){   //放在这里的话,就省去再单独的设置后台权限
            return $this->listall();
        }elseif($type=='excel'){
            return $this->excel($mid,input()['ids']);
        }
        if(!$mid && !$fid){
            // $this->error('参数有误！');
            //$mid = $this->m_model->getID();
            return $this->listall();
        }elseif($fid){ //根据项目选择发表内容
            $mid = $this->model->getMidByFid($fid);
        }
        
        $this->mid = $mid;
        $this->tab_ext['nav'] = [ $this->nav() , $mid];
        isset($this->tab_ext['page_title']) || $this->tab_ext['page_title'] = '选项管理';

        if(!isset($this->tab_ext['top_button'])){
            $this->tab_ext['top_button'] = [
                    [
                            'title' => '增加选项',
                            'icon'  => 'fa fa-plus',
                            'class' => 'btn btn-primary',
                            'href'  => auto_url('add',$fid?['fid'=>$fid]:['mid'=>$mid])
                    ],
                    [
                            'type'       => 'delete',
                    ],
 
                    [
                            'title' => '返回项目列表',
                            'icon'  => 'fa fa-reply',
                            'class' => 'btn btn-primary',
                            'href'  => auto_url('sort/index')
                    ],
            ];
            
            //比如万能表单是不需要项目的，就不要显示项目
            if(empty(config('post_need_sort'))){
                unset($this->tab_ext['top_button'][3] );
            }
            if(empty(config('use_category'))){
                unset($this->tab_ext['top_button'][2]);
            }
            
        }
        
        $this -> tab_ext['search'] = ['title'=>'标题','uid'=>'用户uid'];
        $this -> tab_ext['order'] = 'view,list';        
        $this->tab_ext['filter_search'] = [
                'fid'=>get_sort(0,'all'),
                'status'=>['未审核','已审核']
        ];
        $filte_field = $this->getEasySearchItems(); //搜索字段
        if($filte_field){
            $this->tab_ext['filter_search'] = array_map( $filte_field,$this->tab_ext['filter_search']);
        }
        
        if(empty($this->list_items)){
            $array =  [
                    ['fid', '所属项目', 'select',$this->s_model->getTitleList(),config('system_dirname')],
                    //['mid', '所属模型', 'select2',$this->m_model->getTitleList()],
                    ['uid', '发布者', 'callback',function($value){
                        $array = get_user($value);
                        return $array['username'];
                    }],
                    ['create_time', '创建日期', 'datetime'],
                    ['view', '浏览量', 'text.edit'],
                    ['agree', '票数'],
                    ['list', '排序值', 'text.edit'],
                    ['status', '审核', 'select',['未审','已审']],
            ];
            
            //比如万能表单是不需要项目的，就不要显示项目
            if(empty(config('post_need_sort'))){
                unset( $array[0] );
            }
            
            //列表显示哪些字段
            $this->list_items = array_merge(
                    $this->getEasyIndexItems(),  //列表要显示的自定义字段
                    $array
                    );            
        }
        
        $data = self::getListData($fid ? ['fid'=>$fid] : ['mid'=>$mid]);
        return $this->getAdminTable($data);
    }

    /**
     * 一次性列出所有模型的内容，效率会比较低
     * @return mixed|string
     */
    public function listall()
    {
        isset($this->tab_ext['nav'])              || $this->tab_ext['nav'] = [ $this->nav() , 0];
        isset($this->tab_ext['page_title'])     || $this->tab_ext['page_title'] = '选项管理';
        isset($this->tab_ext['top_button'])   || $this->tab_ext['top_button'] = [
                [
                        'title' => '增加选项',
                        'icon'  => 'fa fa-plus',
                        'class' => 'btn btn-primary',
                        'href'  => auto_url('postnew')
                ],
                [
                        'type'       => 'delete',
                ],
                [
                        'title' => '返回项目列表',
                        'icon'  => 'fa fa-reply',
                        'class' => 'btn btn-primary',
                        'href'  => auto_url('sort/index')
                ],
        ];
        
        //比如万能表单是不需要项目的，就不要显示项目
        if(empty(config('post_need_sort'))){
            unset($this->tab_ext['top_button'][3]);
        }
        if(empty(config('use_category'))){
            unset($this->tab_ext['top_button'][2]);
        }
        
        if(empty($this->list_items)){
            //列表显示哪些字段
            $this->list_items =  [
                    ['title', '选项名称', 'link',iurl('content/show',['id'=>'__id__']),'_blank'],
                    ['fid', '所属项目', 'select',$this->s_model->getTitleList(),config('system_dirname')],
                    ['mid', '所属模型', 'select2',$this->m_model->getTitleList()],
                    ['uid', '发布者', 'callback',function($value){
                        $array = get_user($value);
                        return $array['username'];
                    }],
                    ['create_time', '发布日期', 'datetime'],
                    ['view', '浏览量', 'text.edit'],
                    ['agree', '票数'],
                    ['list', '排序值', 'text.edit'],
                    ['status', '审核', 'select',['未审','已审']],
            ];
            //比如万能表单是不需要项目的，就不要显示项目
            if(empty(config('post_need_sort'))){
                unset($this->list_items[1]);
            }
        }
        $data = $this->model->getAll( $this->getMap() );
        return $this->getAdminTable($data);
    }

 /**
     * 发布页，可以根据项目ID或者模型ID，但不能为空，不然不知道调用什么字段
     * @param number $fid
     * @param number $mid
     * @return unknown
     */
    public function add($fid=0,$mid=0)
    {
        $data = $this->request->post();
        isset($data['fid']) && $fid = $data['fid'];
        
        if($fid && !$mid){
            $mid = $this->model->getMidByFid($fid);
        }elseif( !$fid && !$mid ){  //项目与模型都为空
            return self::postnew($mid);
        }elseif( config('post_need_sort') && !$fid ){  //指定必须要选择项目的频道
            return self::postnew($mid);
        }
        $this->mid = $mid;
        //接口
        hook_listen('cms_add_begin',$data);
        if (($result=$this->add_check($mid,$fid,$data))!==true) {
            $this->error($result);
        }
        // 保存数据
        if ($this -> request -> isPost()) {
            $this->saveAdd($mid,$fid,$data);
        }
        //发表时可选择的项目
        $sort_array = $this->s_model->getTreeTitle(0,$mid);
        //发布页要填写的字段
        $this->form_items = $this->getEasyFormItems();     //发布表单里的自定义字段
        //如果项目存在才显示项目选择项
        if( config('post_need_sort') ){
            $this->form_items = array_merge(
                        [
                                [ 'select','fid','所属项目','',$sort_array,$fid],
                        ],
                        $this->getEasyFormItems()
                    );
        }
        //联动字段
        $this->tab_ext['trigger'] = $this->getEasyFieldTrigger();
        //分组显示
        $this->tab_ext['group'] = $this->get_group_form($this->form_items);
        if( $this->tab_ext['group'] ){
            unset($this->form_items);
        }
        $this->tab_ext['page_title'] = '发布 '.$this->m_model->getNameById($this->mid);
        return $this->addContent('index',['fid'=>$fid]);
    }

    /**
     * 修改内容
     * @param unknown $id
     * @return mixed|string
     */
    public function edit($id)
    {
        $this->mid = $this->model->getMidById($id);
        
        // 保存数据
        if ($this -> request -> isPost()) {
			//表单数据
			$data = $this->request->post();
			
			if(isset($data['map'])){
			    list($data['map_x'],$data['map_y']) = explode(',', $data['map']);
			}

            $this->saveEdit($this->mid,$data);
        }
        
        //发表时可选择的项目
        $sort_array = $this->s_model->getTreeTitle(0,$this->mid);
        //发布页要填写的字段
        $this->form_items = $this->getEasyFormItems();     //发布表单里的自定义字段
        //如果项目存在才显示项目选择项
        if(config('post_need_sort')){
            $this->form_items = array_merge(
                    [
                            [ 'select','fid','所属项目','',$sort_array],
                    ],
                    $this->getEasyFormItems()
                    );
        }
        
        //联动字段
        $this->tab_ext['trigger'] = $this->getEasyFieldTrigger();
        
        $this->tab_ext['group'] = $this->get_group_form($this->form_items);
        if( $this->tab_ext['group'] ){
            unset($this->form_items);
        }
        
        $this->tab_ext['page_title'] = $this->m_model->getNameById($this->mid);
        
        if(empty($id)) $this->error('缺少参数');
        
        $info = $this->getInfoData($id);
        
        //修改内容后，最好返回到模型列表页，因为有可能修改了项目
        return $this->editContent($info);
    }

}
