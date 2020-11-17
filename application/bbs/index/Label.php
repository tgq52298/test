<?php
namespace app\bbs\index;

use app\common\controller\index\Label AS _Label;

//标签设置
class Label extends _Label
{
    
    /**
     * 通用标签设置
     * {@inheritDoc}
     * @see \app\common\controller\index\Label::tag_set()
     */
    public function tag_set(){
        return parent::tag_set();
    }
    
    /**
     * 内容页设置标签模板
     * {@inheritDoc}
     * @see \app\common\controller\index\Label::showpage_set()
     */
    public function showpage_set(){
        return parent::showpage_set();
    }
    
    /**
     *  列表页标签设置
     * {@inheritDoc}
     * @see \app\common\controller\index\Label::listpage_set()
     */
    public function listpage_set(){
        return parent::listpage_set();
    }
    
    /**
     * 回复设置,类似插件中的评论
     * @return mixed|string
     */
    public function reply_set(){
        if($this->request->isPost()){
            $this->setTag_value("@");
            $_array = $this->get_post_data();
            $this->save($_array);
        }
        $info = $this->getTagInfo();
        
        if(empty($info) || empty($info['view_tpl'])){
            //$info['view_tpl'] = $this->get_cache_tpl();
        }
        $cfg = unserialize($info['cfg']);
        $cfg['rows'] || $cfg['rows']=10;
        $cfg['order'] || $cfg['order']='id';
        $cfg['by'] || $cfg['by']='desc';
        $cfg['status'] = intval($cfg['status']);
        $this->form_items = [
                ['hidden','type','showpage_set_'.config('system_dirname')],
                ['text','rows','每页显示几条评论','',$cfg['rows']],
                ['radio','order','按什么排序','',['id'=>'发布日期','list'=>'可控排序','reply'=>'回复数','agree'=>'点赞数'],$cfg['order']],
                ['radio','by','排序方式','',['desc'=>'降序','asc'=>'升序'],$cfg['by']],
                ['radio','status','范围限制','',['不限','已审核的'],$cfg['status']],
                ['textarea','view_tpl','模板代码','',$info['view_tpl']],
                ['button', 'choose_style', [
                        'title' => '点击选择模板',
                        'icon' => 'fa fa-plus-circle',
                        'href'=>url('index/label/choose_style',['type'=>'comment','tpl_cache'=>'tags_comment_tpl_'.input('pagename'),'name'=>input('name')]),
                        //'data-url'=>url('choose_style',['type'=>'images']),
                        'class'=>'form-btn pop',
                ],
                        'a'
                ],
        ];
        $this->tab_ext['page_title']='评论设置';
        return $this->editContent(unserialize($info['cfg']));
    }

    
}













