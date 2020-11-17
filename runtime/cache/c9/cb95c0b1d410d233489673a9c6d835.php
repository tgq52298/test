<?php
//000000036000
 exit();?>
a:2:{s:21:"default_admin_count_d";a:2:{s:4:"demo";s:235:"
<script type="text/javascript">
$(".countD-<?php echo input('tags'); ?> .count_num").html("<?php echo implode('/',fun('Count@label','table_name=cms_content&time_field=list&showtime=day2,week,all&where=status=0')); ?>");
</script>
";s:3:"tpl";s:871:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>

<script type="text/javascript">
$(".countD-<?php echo input('tags'); ?> .count_num").html("<?php echo implode('/',fun('Count@label',$_cfg)); ?>");
$(".countD-<?php echo input('tags'); ?> .count_title").html("<?php echo $_cfg['title']; ?>");
$(".countD-<?php echo input('tags'); ?> .count_icon").html("<i class='<?php echo $_cfg['icon']; ?>'></i>");
$(".countD-<?php echo input('tags'); ?> .count_icon").css("background","<?php echo $_cfg['bgcolor']; ?>");
$(".countD-<?php echo input('tags'); ?> .count_url").attr("href","<?php echo $_cfg['url']; ?>");
</script>
  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:11:"_filemtime_";i:1605583580;}