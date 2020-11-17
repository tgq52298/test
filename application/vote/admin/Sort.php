<?php
namespace app\vote\admin;

use app\common\controller\admin\S;


class Sort extends S
{

    protected function set_config(){
        $this->list_items = [
                ['name', '项目名称', 'link',iurl('content/index',['fid'=>'__id__']),'_blank'],
                ['mid', '所属模型', 'select2',$this->m_model->getTitleList()],
                ['list', '排序值', 'text.edit'],
        ];
        
        $this->form_items = [                
                ['text', 'name', '项目名称'],
                ['select', 'pid', '归属上级分类','不选择，则为顶级分类',$this->model->getTreeTitle()],
                ['select', 'mid', '所属模型','创建后不能随意修改',$this->m_model->getTitleList(),1],
        ];
        
        $this->tab_ext = [
                'page_title'=>'项目管理',
                'top_button'=>[
                        [
                                'title' => '创建项目',
                                'icon'  => 'fa fa-fw fa-th-list',
                                'class' => 'btn btn-primary',
                                'href'  => auto_url('add')
                        ],
                ],
                'right_button'=>[
                        [
                                'title' => '管理选项',
                                'icon'  => 'fa fa-fw fa-file-text-o',
                                'href'  => auto_url('content/index', ['fid' => '__id__'])
                        ],
                        [
                                'title' => '增加选项',
                                'icon'  => 'glyphicon glyphicon-plus',
                                'href'  => auto_url('content/add', ['fid' => '__id__'])
                        ],                        
                        ['type'=>'delete'],
                        ['type'=>'edit'],
                ],
        ];
    }



    public function edit($id = null)
        {
            if($this->request->isPost()){
                $data = $this -> request -> post();            
                if (!empty($this -> validate)) {    // 验证
                    //$result = $this -> validate($data, $this -> validate);
                    //if (true !== $result) $this -> error($result);
                } 
                $data['joinbegintime'] = $data['joinbegintime'] ? strtotime($data['joinbegintime']) : '';
                $data['joinendtime'] = $data['joinendtime'] ? strtotime($data['joinendtime']) : '';
                $data['begintime'] = $data['begintime'] ? strtotime($data['begintime']) : '';
                $data['endtime'] = $data['endtime'] ? strtotime($data['endtime']) : '';
                
                $data['allowpost'] = implode(',', $data['allowpost']);  //允许发布内容的用户组
                 $data['allowpostyz'] = implode(',', $data['allowpostyz']);  //允许报名自动通过审核的用户组
                $data['allowview'] = implode(',', $data['allowview']);  //允许查看内容的用户组
                $data['template'] = $this->get_tpl($data);                  //项目自定义模板
                
                
                if ($this -> model -> update($data)) {
                    $this -> success('修改成功', 'index');
                } else {
                    $this -> error('修改失败');
                }
            }
            $this->form_items = [];
            
            $msg = '请把模板放在此目录下: '.TEMPLATE_PATH.'index_style/ 然后输入相对路径,比如 default/abc.htm';
            
            $this -> tab_ext['group'] = [
                    '基础设置'=>[
    		['text', 'name', '投票项目名称'],
    		['radio', 'type', '投票选项','',['单选','多选']],
    		['text', 'limittime', '是否做时间限制:不做限制请输入0,否则请输入限制每次投票的时间间隔','(单位：分钟)'],

    		['radio', 'limitip', '是否限制IP重复投票','',['不限制','限制']],
    		['radio', 'forbidguestvote', '是否禁止游客投票','',['不限制','限制']],
    		['radio', 'repeatjoinvote', '是否禁止重复报名','',['不限制','限制']],

    		['datetime', 'joinbegintime', '报名开始时间','留空不做限制'],
    		['datetime', 'joinendtime', '报名结束时间','留空不做限制'],

    		['datetime', 'begintime', '投票开始时间','留空不做限制'],
    		['datetime', 'endtime', '投票结束时间','留空不做限制'],
                        ['textarea', 'description', '投票内容描述'],

    		['checkbox', 'allowpost', '允许报名的用户组','全留空,则不作限制',getGroupByid()],
                    ['checkbox', 'allowpostyz', '报名自动通过审核的用户组','全留空,则默认通过审核',getGroupByid()],
    		['select', 'pid', '归属上级分类','不选择，则为顶级分类',$this->model->getTreeTitle($id)],
    		//['select', 'mid', '所属模型','创建后不能随意修改',$this->m_model->getTitleList()],
    		['icon', 'logo', '图标',],
                            
                    ],
                    'SEO优化设置'=>[
                            ['text', 'seo_title', 'SEO标题'],
                            ['text', 'seo_keywords', 'SEO关键字'],
                            ['text', 'seo_description', 'SEO描述'],
                    ],
            ];
            
            if(empty($id)) $this->error('缺少参数');
            
            $info = $this->getInfoData($id);
            
            if($info['template']){
                $array = unserialize($info['template']);
                
                if (is_array($array)){
                    $info = array_merge($info,['templates'=>$array]);
                }
            }
            
            return $this->editContent($info);
    }
}













