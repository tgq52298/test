<?php

return [
        //发布内容必须要选择栏目
        'post_need_sort'=>true,
        //发布信息选择模型页模板
        'post_choose_model'=>APP_PATH.'common/builder/sort/model_list.htm',
        //发布信息选择栏目页模板
        'post_choose_sort'=>APP_PATH.'common/builder/sort/layout.htm',
        
        //模块关键字，目录名，也是数据表区分符    
        'system_dirname'=>basename(__DIR__),
];