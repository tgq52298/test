<?php
//000000036000
 exit();?>
a:2:{s:17:"pc_index_slidepic";a:2:{s:4:"demo";s:479:"
	<div class="qb_ui_SlideStyle1" height='400'>
		<div class="slide">
			<ul>
				<li><a href="#1"><img src="/public/static/images/s0.jpg"></a><span>标题1</span></li>
				<li><a href="#2"><img src="/public/static/images/s1.jpg"></a><span>标题2</span></li>
				<li><a href="#3"><img src="/public/static/images/s2.jpg"></a><span>标题3</span></li>
				<li><a href="#4"><img src="/public/static/images/s3.jpg"></a><span>标题4</span></li>
			</ul>
		</div>
	</div>
	";s:3:"tpl";s:543:" 
	
	<div class="qb_ui_SlideStyle1" height='400'>
		<div class="slide">
			<ul>
		<?php if(is_array($listdb) || $listdb instanceof \think\Collection || $listdb instanceof \think\Paginator): $i = 0; $__LIST__ = $listdb;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
				<li><a href="<?php echo $rs['url']; ?>"><img src="<?php echo $rs['picurl']; ?>"></a><span><?php echo $rs['title']; ?></span></li>
		<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
 ";}s:11:"_filemtime_";i:1605583485;}