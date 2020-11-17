<?php
//000000036000
 exit();?>
a:2:{s:14:"pcshop_list001";s:759:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
			<div class="qb_ui_listShop_type4">
	<ul>
		<ol><a href="<?php echo $rs['url']; ?>"><img src="<?php echo $rs['picurl']; ?>" onerror="this.src='/public/static/images/nopic.png'"/></a></ol>
		<li>
			<div><a href="<?php echo $rs['url']; ?>"><?php echo get_word($rs['title'],100); ?></a></div>
			<p><span>时间:<?php echo format_time($rs['begin_time'],"y-m-d"); ?></span><a href="<?php echo $rs['url']; ?>">报名</a></p>
		</li>
	</ul>				
</div>
		  <?php endforeach; endif; else: echo "" ;endif; ?> ";s:11:"_filemtime_";i:1605519656;}