<?php
//000000036000
 exit();?>
a:2:{s:25:"news_list_page_listdata01";s:676:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
			<ul class="qb_ui_ListArticleTimeTitleCnt">
				<ol>
					<dl><dt><?php echo date("d",$rs['create_time']); ?></dt><dd><?php echo date("Y-m",$rs['create_time']); ?></dd></dl>
				</ol>
				<li>
					<h3><a href="<?php echo $rs['url']; ?>"><?php echo get_word($rs['title'],100); ?></a></h3>
					<p><?php echo get_word($rs['content'],200); ?></p>
				</li>
			</ul>
		  <?php endforeach; endif; else: echo "" ;endif; ?> ";s:11:"_filemtime_";i:1605517824;}