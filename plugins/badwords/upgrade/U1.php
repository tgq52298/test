<?php
namespace plugins\badwords\upgrade;
use think\Db;

class U1
{
    public static function up()
    {
        Db::name('config')->where('c_key','word_type')->update(['options' => "0|内置\r\n1|自定义\r\n2|内置+自定义"]);
        $id = Db::name('plugin')->where('keywords', 'badwords')->value('id');
        $sysid = -$id; //因为插件是负数
        $type = Db::name('config_group')->where('sys_id', $sysid)->value('id');
        $ishook = Db::name('hook')->where('name','comment_add_end')->find();
        if(!$ishook){
            into_sql("INSERT INTO `qb_hook`(`id`,`name`,`about`,`ifopen`,`list`) VALUES('','comment_add_end','评论回复接口', 1, 0)");
        }


        into_sql("INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES (0, {$type}, '是否过滤评论', 'commentsw', '0', 'radio', '0|关\\r\\n1|开', 0, '', '评论过滤开关（注意：评论属于永久过滤）', 0, {$sysid} )");


        into_sql("INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`) VALUES('', 'comment_add_end', 'badwords', 'plugins\\\badwords\\\hook\\\Index', '评论过滤', 1, 0, 'torylf', '')");



    }
}

