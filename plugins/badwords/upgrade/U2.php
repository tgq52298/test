<?php
namespace plugins\badwords\upgrade;
use think\Db;

class U2
{
    public static function up()
    {

        $id = Db::name('plugin')->where('keywords', 'badwords')->value('id');
        $sysid = -$id; //因为插件是负数
        $type = Db::name('config_group')->where('sys_id', $sysid)->value('id');
        $ishook = Db::name('hook')->where('name','reply_add_end')->find();
        if(!$ishook){
            into_sql("INSERT INTO `qb_hook`(`id`,`name`,`about`,`ifopen`,`list`) VALUES('','reply_add_end','论坛回复接口', 1, 0)");
        }

        into_sql("INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES (0, {$type}, '是否过滤论坛回复', 'replysw', '0', 'radio', '0|关\\r\\n1|开', 0, '', '论坛回复过滤开关（注意：属于永久过滤）', 0, {$sysid} )");

        into_sql("INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`) VALUES('', 'reply_add_end', 'badwords', 'plugins\\\badwords\\\hook\\\Index', '论坛回复过滤', 1, 0, 'torylf', '')");



    }
}

