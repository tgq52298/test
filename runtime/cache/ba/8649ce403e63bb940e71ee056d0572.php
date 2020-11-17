<?php
//000000036000
 exit();?>
a:2:{s:12:"pc_indexpage";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:383:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
						<li><a href="<?php echo $rs['url']; ?>"><?php echo $rs['title']; ?></a></li>
  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:11:"_filemtime_";i:1605519652;}