<?php

if(!function_exists('search_style_tpl')){
    /**
     * 查找模板
     * @param string $tpl
     * @return void|string
     */
    function search_style_tpl($tpl=''){        
        $filename = TEMPLATE_PATH . 'qun_style/' . $tpl . '.' . ltrim(config('template.view_suffix'));
        
        $array = pathinfo($filename);
        $name = $array['basename'];
        $path = $array['dirname'].'/';
        if(IN_WAP===true){   //没有声明强制使用PC模板的时候,如果WAP端,就取WAP模板
            if(!preg_match('/^wap_/', $name)){
                if(is_file($path.'wap_'.$name)){
                    return $path.'wap_'.$name;
                }
            }
        }else{
            if(!preg_match('/^pc_/', $name)){
                if(is_file($path.'pc_'.$name)){
                    return $path.'pc_'.$name;
                }
//                 if(!is_file($path.'wap_'.$name)){
//                     return ;    //即使有xxx.htm 但是没有wap_xxx.htm 则代表没有PC模板, PC模板,最好是用pc_xxx.htm
//                 }
            }
        }
        
        if (is_file($filename)) {
            return $filename;
        }
    }
}
if(!function_exists('get_style_tpl')){
    
    /**
     * 获取圈子黄页商铺模板.
     * 注意事项: 即使有xxx.htm 但是没有wap_xxx.htm 则代表没有PC模板, PC模板,最好是用pc_xxx.htm
     * @param string $action
     * @param string $style
     * @return void|string
     */
    function get_style_tpl($action='',$style='',$mid=0){
        if (empty($style)) {
            return ;
        }
        $dispatch = request()->dispatch();
        if(!isset($dispatch['module'])){
            return ;
        }
        //$module = $dispatch['module'][0];
        $controller = $dispatch['module'][1];
        $action || $action = $dispatch['module'][2];
        
        $tpl ="$style/$controller/$action";
        if($mid){
            $template = search_style_tpl($tpl.'_'.$mid);
        }
        
        if (empty($template)) {
            $template = search_style_tpl($tpl);
        }
        return $template;
    }
}