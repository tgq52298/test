<?php
//000000036000
 exit();?>
a:2:{s:22:"pc_bbs_index_qunonline";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:622:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
<script type="text/javascript">
show_qun_member = "<?php echo $_cfg['member_num']; ?>";
show_qun_totaluser = "<?php echo $_cfg['total_num']; ?>";
hide_qun_ids = ",<?php echo $_cfg['hide_qun']; ?>,";
show_chat_type = "<?php echo $_cfg['show_type']; ?>";
show_chat_id = "<?php echo $_cfg['show_qunid']; ?>";
</script>
  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:11:"_filemtime_";i:1605519652;}