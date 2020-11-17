<?php
namespace app\exam\admin;

use app\common\controller\admin\Info AS _Info;

//辅栏目内容表
class Info extends _Info
{	
    protected function set_config(){
        $this->list_items = [
                ['title', '试卷题目', 'link', iurl('content/show',['id'=>'__aid__']),'_blank',''],
                //['cid', '所属试卷',  'select2',$this->category_model->getTitleList()],
                //['fid', '所属主栏目',  'select2',$this->s_model->getTitleList()],
                ['mid', '题目类型', 'select2',$this->m_model->getTitleList()],
                ['list', '排序值',  'text.edit'],
        ];
        
        $this->tab_ext = [
                'page_title'=>'管理试卷：'.$this->category_model->where('id',input('cid'))->value('name'),
                'top_button'=>[
                        ['type'=>'delete'],
                        [
                                'title'=>'挑选试题',
                                'url'=>url('content/index'),
                                'class'=>'_pop',
                        ]
                ],
        ];
    }
    
    
    public function index($cid=0)
    {
        $data = $this->getListData($cid?['cid'=>$cid]:[],'',100);
        return $this->getAdminTable($data);
    }

    
    /**
     * 挑选试题到试卷
     * {@inheritDoc}
     * @see \app\common\controller\admin\Info::add()
     */
    public function add()
    {        
        $data = get_post();
        $ids = $data['ids'];
        if(empty($ids)){
            $this->error('参数不存在');
        }        
        if(IS_POST){
            if(empty($data['fid'])){
                $this->error('请选择试卷');
            }
            if ($num = $this->model->save_data($ids,$data['fid']) ) {
                $this->success('成功添加'.$num.'条数据', auto_url('index'));
            } else {
                $this->error('请不要重复添加');
            }
        }        
        $this->tab_ext = [
                'page_title'=>'挑选试题进试卷',
        ];
        $this->form_items = [
                // ['hidden', 'ids',$ids],
                ['select', 'fid', '添加到哪个试卷','',$this->category_model->getTreeTitle()],
        ];        
        return $this->addContent();
    }
	
}













