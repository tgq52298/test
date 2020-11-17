<?php
//000000036000
 exit();?>
a:2:{s:21:"default_admin_count_a";a:2:{s:4:"demo";s:445:"
<script type="text/javascript">
var str = "<?php echo fun('Count@label','table_name=memberdata&where=wx_attention=1')[0]; ?>/<?php echo fun('Count@label','table_name=memberdata&where=weixin_api!=NULL')[0]; ?>/<?php echo fun('Count@label','table_name=memberdata&where=qq_api=NULL')[0]; ?>/<?php echo fun('Count@label','table_name=memberdata&where=mob_yz=1')[0]; ?>"
$(".countA-<?php echo input('tags'); ?> .count_num").html(str);
</script>
";s:3:"tpl";s:871:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>

<script type="text/javascript">
$(".countA-<?php echo input('tags'); ?> .count_num").html("<?php echo implode('/',fun('Count@label',$_cfg)); ?>");
$(".countA-<?php echo input('tags'); ?> .count_title").html("<?php echo $_cfg['title']; ?>");
$(".countA-<?php echo input('tags'); ?> .count_icon").html("<i class='<?php echo $_cfg['icon']; ?>'></i>");
$(".countA-<?php echo input('tags'); ?> .count_icon").css("background","<?php echo $_cfg['bgcolor']; ?>");
$(".countA-<?php echo input('tags'); ?> .count_url").attr("href","<?php echo $_cfg['url']; ?>");
</script>
  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:11:"_filemtime_";i:1605583579;}