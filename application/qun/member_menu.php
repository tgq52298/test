<?php

$menu_array = array(
        'cms'=>array(
                'title'=>'cms',
                'sons'=>array(
                        array(
                                'title'=>QUN.'模块',
                                'sons'=>array(
//                                         array(
//                                                 'title'=>'我创建的'.QUN,
//                                                 'link'=>'content/index',
//                                                 'power'=>'can_post_group',
//                                         ),
//                                         array(
//                                                 'title'=>'创建'.QUN,
//                                                 'link'=>'content/postnew',
//                                                 'power'=>'can_post_group',
//                                         ),
//                                         array(
//                                                 'title'=>'广告位管理',
//                                                 'link'=>'adset/edit',
//                                                 'power'=>'can_post_group',
//                                         ),
//                                         array(
//                                                 'title'=>'广告用户管理',
//                                                 'link'=>'aduser/index',
//                                                 'power'=>'can_post_group',
//                                         ),
                                ),
                        ),
                ),
        ),
);

$quns = fun('qun@getByuid',login_user('uid'));
if (count($quns)>0) {
    $menu_array['cms']['sons'][0]['sons'] = array(
            array(
                    'title'=>'我创建的'.QUN,
                    'link'=>'content/index',
            ),
            array(
                'title'=>'查看(购买)课堂时长',
                'link'=>'log/index',
            ),
            array(
                    'title'=>'参数设置',
                    'link'=>'content/edit',
            ),
            array(
                    'title'=>'风格设置',
                    'link'=>'style/index',
            ),
            array(
                    'title'=>'会员管理',
                    'link'=>'member/index',
            ),
    );
    
    if (modules_config('shop')) {
        $menu_array['cms']['sons'][0]['sons'][] = ['title'=>'商品管理', 'link'=>'shop/index',];
    }
    $menu_array['cms']['sons'][0]['sons'][] = ['title'=>'查看二维码', 'link'=>'codeimg/index',];
    $menu_array['cms']['sons'][0]['sons'][] = ['title'=>'广告位管理', 'link'=>'adset/edit',];
    $menu_array['cms']['sons'][0]['sons'][] = ['title'=>'广告用户管理', 'link'=>'aduser/index',];
}else{
    $menu_array['cms']['sons'][0]['sons']=array(
            array(
                    'title'=>'创建'.QUN,
                    'link'=>'content/postnew',
                    'power'=>'can_post_group',
            ),
            array(
                'title'=>'查看(购买)课堂时长',
                'link'=>'log/index',
            ),
    );
}

return $menu_array;
