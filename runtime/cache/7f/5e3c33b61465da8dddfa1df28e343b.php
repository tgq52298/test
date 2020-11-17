<?php
//000000036000
 exit();?>
a:10:{s:12:"hy_index_001";a:2:{s:4:"demo";s:141:" 
<div class="qb_ui_AllscrollBanner" style="height:300px;">
	<a href="#1"><img src="/public/static/group/circle/banner.jpg"></a>
</div>
 ";s:3:"tpl";s:141:" 
<div class="qb_ui_AllscrollBanner" style="height:300px;">
	<a href="#1"><img src="/public/static/group/circle/banner.jpg"></a>
</div>
 ";}s:13:"pc_layout_001";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:30:" 
		<?php echo $datas; ?>
	 ";}s:16:"pc_hy_banner_001";a:2:{s:4:"demo";s:103:" 
				<a href="#"><img src="/public/static/group/circle/banner.png" width="790" height="385" /></a>
 ";s:3:"tpl";s:103:" 
				<a href="#"><img src="/public/static/group/circle/banner.png" width="790" height="385" /></a>
 ";}s:9:"pc_hy_002";a:2:{s:4:"demo";s:45:" <a href="#">共同建设美丽新农村</a> ";s:3:"tpl";s:45:" <a href="#">共同建设美丽新农村</a> ";}s:15:"hy_pc_index_001";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:508:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
							<li><span style="<?php if($i < '4'): ?>background:#1bb76d;<?php endif; ?>"><?php echo $i; ?></span><a href="<?php echo $rs['url']; ?>" target="_blank"><?php echo get_word($rs['title'],50); ?></a></li>
  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:18:"pc_index_showhy001";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:1257:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
						<li class="list">
							<div class="mylist">
								<dl>
									<dt>
										<a href="<?php echo $rs['url']; ?>" target="_blank"><img onerror="this.src='/public/static/images/nopic.png'" src="<?php echo $rs['picurl']; ?>" alt="tupian"></a>
									</dt>
									<dd>
										<h2><a href="<?php echo $rs['url']; ?>" target="_blank"><?php echo $rs['title']; ?></a></h2>
										<div>
											<span><i class="fa fa-fw fa-user-o"></i>电话: <em><?php echo $rs['telphone']; ?></em> </span>
											<span><i class="fa fa-fw fa-file-text-o"></i>地址: <?php echo $rs['address']; ?></span>
											 
										</div>
									</dd>
								</dl>
								<div class="mytopic">
									<h3>商家介绍</h3>
									<ul>
										<li style="height:40px;"><a href="<?php echo $rs['url']; ?>"><?php echo get_word($rs['content'],110); ?></a></li>
										 
									</ul>
								</div>
							</div>
						</li>
  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:15:"hy_pc_index_003";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:479:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
								<li class="list"><a href="<?php echo $rs['url']; ?>"><img onerror="this.src='/public/static/images/nopic.png'" src="<?php echo $rs['picurl']; ?>" height="104" /></a></li>
  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:20:"hy_pc_index_shop_003";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:760:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
					<div class="topics_list">  
						<div class="topics">          
							<div><a href="<?php echo $rs['url']; ?>"><img onerror="this.src='/public/static/images/nopic.png'" src="<?php echo $rs['picurl']; ?>" width="225" height="170" /></a></div>
							<div class="title"><span><?php echo $rs['title']; ?></span></div>
						</div>
						<div><span>价格: <em class="green">￥ <?php echo $rs['price']; ?> 元</em></span></div>
					</div>					
					  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:19:"hy_pc_index_qun_004";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:875:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
					<dl class="peolist" style="margin-bottom:10px;clear:both;">
						<dt style="margin-bottom:20px;float:left; "><a href="<?php echo $rs['url']; ?>"><img onerror="this.src='/public/static/images/nopic.png'" src="<?php echo $rs['picurl']; ?>" width="90" height="90" /></a></dt>
						<dd style="margin-left:10px;float:left;">
							<div style="padding-bottom:10px;"><a href="<?php echo $rs['url']; ?>" class="orange"><?php echo $rs['title']; ?></a></div>
							<div><span>介绍：</span><?php echo get_word($rs['content'],100); ?></div>
						</dd>
					</dl>
					  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:11:"_filemtime_";i:1605519652;}