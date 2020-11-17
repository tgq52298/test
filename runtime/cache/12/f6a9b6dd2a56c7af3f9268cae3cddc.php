<?php
//000000036000
 exit();?>
a:2:{s:17:"pc_index_toptitle";a:2:{s:4:"demo";s:805:"
		<ul>
			<ol><i class="fa fa-globe"></i></ol>
			<li>
				<a href="/">国内游</a>
				<a href="/">周边游</a>
				<a href="/">出境游</a>
				<a href="/">主题游</a>
			</li>
		</ul>
		<ul>
			<ol><i class="fa fa-calendar"></i></ol>
			<li>
				<a href="/">2天一晚</a>
				<a href="/">一日游</a>
				<a href="/">二日游</a>
				<a href="/">3天以上</a>
			</li>
		</ul>
		<ul>
			<ol><i class="si si-directions"></i></ol>
			<li>
				<a href="/">特色玩法</a>
				<a href="/">五一去哪玩</a>
				<a href="/">周末玩啥</a>
			</li>
		</ul>
		<ul>
			<ol><i class="glyphicon glyphicon-fire"></i></ol>
			<li>
				<a href="/">热门目的地</a>
				<a href="/">北京</a>
				<a href="/">上海</a>
				<a href="/">厦门</a>
			</li>
		</ul>";s:3:"tpl";s:3672:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
		
		<ul>
			<ol><i style="<?php if($_cfg['color1']): ?>color:<?php echo $_cfg['color1']; ?>;<?php endif; ?>" class="<?php echo $_cfg['icon1']; ?>"></i></ol>
			<li>
<?php $_result=json_decode($_cfg['links1'],true);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
				<a title="<?php echo $rs['about']; ?>" href="<?php echo $rs['url']; ?>" style="<?php if($rs['font_color']): ?>color:<?php echo $rs['font_color']; ?>;<?php endif; if($rs['bgcolor']): ?>background:<?php echo $rs['bgcolor']; ?>;<?php endif; ?>"><i class="<?php echo $rs['icon']; ?>"></i><?php echo $rs['title']; ?></a>
<?php endforeach; endif; else: echo "" ;endif; ?>
			</li>
		</ul>
		<ul>
			<ol><i style="<?php if($_cfg['color2']): ?>color:<?php echo $_cfg['color2']; ?>;<?php endif; ?>" class="<?php echo $_cfg['icon2']; ?>"></i></ol>
			<li>
<?php $_result=json_decode($_cfg['links2'],true);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
				<a title="<?php echo $rs['about']; ?>" href="<?php echo $rs['url']; ?>" style="<?php if($rs['font_color']): ?>color:<?php echo $rs['font_color']; ?>;<?php endif; if($rs['bgcolor']): ?>background:<?php echo $rs['bgcolor']; ?>;<?php endif; ?>"><i class="<?php echo $rs['icon']; ?>"></i><?php echo $rs['title']; ?></a>
<?php endforeach; endif; else: echo "" ;endif; ?>
			</li>
		</ul>
		<ul>
			<ol><i style="<?php if($_cfg['color3']): ?>color:<?php echo $_cfg['color3']; ?>;<?php endif; ?>" class="<?php echo $_cfg['icon3']; ?>"></i></ol>
			<li>
<?php $_result=json_decode($_cfg['links3'],true);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
				<a title="<?php echo $rs['about']; ?>" href="<?php echo $rs['url']; ?>" style="<?php if($rs['font_color']): ?>color:<?php echo $rs['font_color']; ?>;<?php endif; if($rs['bgcolor']): ?>background:<?php echo $rs['bgcolor']; ?>;<?php endif; ?>"><i class="<?php echo $rs['icon']; ?>"></i><?php echo $rs['title']; ?></a>
<?php endforeach; endif; else: echo "" ;endif; ?>
			</li>
		</ul>
		<ul>
			<ol><i style="<?php if($_cfg['color4']): ?>color:<?php echo $_cfg['color4']; ?>;<?php endif; ?>" class="<?php echo $_cfg['icon4']; ?>"></i></ol>
			<li>
<?php $_result=json_decode($_cfg['links4'],true);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
				<a title="<?php echo $rs['about']; ?>" href="<?php echo $rs['url']; ?>" style="<?php if($rs['font_color']): ?>color:<?php echo $rs['font_color']; ?>;<?php endif; if($rs['bgcolor']): ?>background:<?php echo $rs['bgcolor']; ?>;<?php endif; ?>"><i class="<?php echo $rs['icon']; ?>"></i><?php echo $rs['title']; ?></a>
<?php endforeach; endif; else: echo "" ;endif; ?>
			</li>
		</ul>
	  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:11:"_filemtime_";i:1605497982;}