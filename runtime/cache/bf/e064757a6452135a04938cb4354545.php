<?php
//000000036000
 exit();?>
a:2:{s:19:"layui_admin_count_c";a:2:{s:4:"demo";s:253:"
<script type="text/javascript">
$(".countC-<?php echo input('tags'); ?> .count_num").html("<?php echo implode('/',fun('Count@label','table_name=rmb_infull&time_field=posttime&showtime=month,month2&count_type=money&where=ifpay=1')); ?>");
</script>
";s:3:"tpl";s:871:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>

<script type="text/javascript">
$(".countC-<?php echo input('tags'); ?> .count_num").html("<?php echo implode('/',fun('Count@label',$_cfg)); ?>");
$(".countC-<?php echo input('tags'); ?> .count_title").html("<?php echo $_cfg['title']; ?>");
$(".countC-<?php echo input('tags'); ?> .count_icon").html("<i class='<?php echo $_cfg['icon']; ?>'></i>");
$(".countC-<?php echo input('tags'); ?> .count_icon").css("background","<?php echo $_cfg['bgcolor']; ?>");
$(".countC-<?php echo input('tags'); ?> .count_url").attr("href","<?php echo $_cfg['url']; ?>");
</script>
  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:11:"_filemtime_";i:1605583580;}