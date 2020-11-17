<?php
namespace plugins\guestbook\index;

use app\common\controller\index\C; 


class Content extends C
{    
    public function show($id=0){
        return parent::show($id);
    }
    
    public function add(){        
    }
    public function edit(){        
    }
    
    public function index($fid='',$mid=0){
        $s_info = [];
        if ($fid) {
            $s_info = get_sort($fid,'','config');
            $mid = $s_info['mid'];
        }
        
        if (empty($mid)) {
            $mid = 1;
        }
        
        $this->mid = $mid;
        $m_info = model_config($this->mid);
        
        //如果某个模型有个性模板的话，就不调用母模板
        $template = $this->get_tpl('list',$mid,$s_info);
        
        $GLOBALS['fid'] = $fid;     //标签有时会用到

        //模板里可能会用到的变量值
        $vars = [
                'fid'=>$fid,
                'mid'=>$mid,
                's_info'=>$s_info,
                'info'=>$s_info,
                'm_info'=>$m_info,
        ];
        
        return $this->fetch($template,$vars);
    }
}
