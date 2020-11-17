<?php
//000000036000
 exit();?>
a:7:{s:13:"pc_layout_001";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:30:" 
		<?php echo $datas; ?>
	 ";}s:23:"pc_weibo_indexpage_feed";a:2:{s:4:"demo";s:1026:" 
					<div class="grid-demo">
					  <div class="panel-body layadmin-homepage-shadow" style="padding-bottom:0px;">
						<a href="" class="media-left">
						  <img onerror="this.src='/public/static/images/nobody.gif'" src="" height="46px" width="46px">
						</a>
						<div class="media-body">
						  
						  		<div class="pad-btm">
								<p class="fontColor">
									<span></span>
																	
									访问了  的空间
								
									申请成为  的粉丝
								
									$rs.about
								
								</p>
								<p class="min-font"></p>
								</div>
						  
							  <div class="pad-btm">
								<p class="fontColor"><a href="" target="_blank"></a>  在<span></span> 了 主题: <a href="" target="_blank"></a></p>
								<p class="min-font"></p>        
							  </div>
						  
							<div class="morepic">
						  	<a href=""><img style="height:100px;margin:5px 5px 15px 5px;" src=""></a>
							</div> 
						</div>						
					  </div>
					</div>	
					   ";s:3:"tpl";s:2462:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
					<div class="grid-demo">
					  <div class="panel-body layadmin-homepage-shadow" style="padding-bottom:0px;">
						<a href="<?php echo urls('weibo/content/show','id='.$rs['uid']); ?>" class="media-left">
						  <img onerror="this.src='/public/static/images/nobody.gif'" src="<?php echo $rs['user_icon']; ?>" height="46px" width="46px">
						</a>
						<div class="media-body">
						  <?php if(empty($rs['aid'])): ?>
						  		<div class="pad-btm">
								<p class="fontColor">
									<span><?php echo $rs['username']; ?></span>
																	<?php if($rs['type']=='visit'): ?>
									访问了 <?php echo get_user_name($rs['bloguid']); ?> 的空间
								<?php elseif($rs['type']=='addfans'): ?>
									申请成为 <?php echo get_user_name($rs['bloguid']); ?> 的粉丝
								<?php else: ?>
									$rs.about
								<?php endif; ?>
								</p>
								<p class="min-font"><?php echo $rs['time']; ?></p>
								</div>
						  <?php else: ?>
							  <div class="pad-btm">
								<p class="fontColor"><a href="<?php echo $rs['user_url']; ?>" target="_blank"><?php echo $rs['username']; ?></a> <?php echo $rs['time']; ?> 在<span><?php echo $rs['topic']['sys_name']; ?></span> <?php echo fun('sns@type',$rs['type']); ?>了 主题: <a href="<?php echo $rs['url']; ?>" target="_blank"><?php echo get_word($rs['title'],40); ?></a></p>
								<?php if($rs['content']): ?><p class="min-font"><?php echo get_word(del_html($rs['content']),100); ?></p><?php endif; ?>        
							  </div>
						  <?php endif; ?>
							<div class="morepic">
						  	<?php if(is_array($rs['topic']['picurls']) || $rs['topic']['picurls'] instanceof \think\Collection || $rs['topic']['picurls'] instanceof \think\Paginator): $i = 0; $__LIST__ = $rs['topic']['picurls'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;if($i<4): ?><a href="<?php echo $rs['url']; ?>"><img style="height:100px;margin:5px 5px 15px 5px;" src="<?php echo $vs['picurl']; ?>"></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
							</div> 
						</div>						
					  </div>
					</div>	
					  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:18:"pc_indexbbs_toppic";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:788:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
					<div class="grid-demo">
					  <div class="panel-body layadmin-homepage-shadow" style="padding-bottom:0px;">						 
						<div class="media-body">
							  <div class="pad-btm">
								<p class="fontColor"> <span>主题:</span> <a href="<?php echo $rs['url']; ?>" target="_blank"><?php echo get_word($rs['title'],100); ?></a></p>
								<p class="min-font">发表时间: <?php echo $rs['time']; ?></p>         
							  </div>
						</div>
					  </div>
					</div>	
					  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:17:"pc_indexbbs_reply";a:2:{s:4:"demo";s:410:" 
					<div class="grid-demo">
					  <div class="panel-body layadmin-homepage-shadow" style="padding-bottom:0px;">						 
						<div class="media-body">
							  <div class="pad-btm">
								<p class="fontColor"> <span></span> 回复主题: <a href="" target="_blank"></a></p>
								<p class="min-font">回复内容: </p>         
							  </div>
						</div>
					  </div>
					</div>	
					   ";s:3:"tpl";s:946:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
					<div class="grid-demo">
					  <div class="panel-body layadmin-homepage-shadow" style="padding-bottom:0px;">						 
						<div class="media-body">
							  <div class="pad-btm">
								<p class="fontColor"> <span><?php echo format_time($rs['create_time'],true); ?></span> 回复主题: <a href="<?php echo urls('bbs/content/show','id='.$rs['aid']); ?>" target="_blank"><?php echo query('bbs_content1',['where'=>['id'=>$rs['aid']],'value'=>'title']); ?></a></p>
								<p class="min-font">回复内容: <?php echo get_word(del_html($rs['content']),200); ?></p>         
							  </div>
						</div>
					  </div>
					</div>	
					  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:24:"weibo_indexmember_pcshow";a:2:{s:4:"demo";s:275:" 
                    <div class="layui-col-md4">
                      <a href="" target="_blank"><img style="border-radius:100%;width:40px;height:40px;" onerror="this.src='/public/static/images/nobody.gif'" src=""></a>
                    </div>
                       ";s:3:"tpl";s:652:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
                    <div class="layui-col-md4">
                      <a href="<?php echo urls('weibo/content/show','id='.$rs['uid']); ?>" target="_blank"><img style="border-radius:100%;width:40px;height:40px;" onerror="this.src='/public/static/images/nobody.gif'" src="<?php echo $rs['icon']; ?>"></a>
                    </div>
                      <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:23:"weibo_indexvisit_pcshow";a:2:{s:4:"demo";s:464:" 
                    <a href="" target="_blank" class="layadmin-privateletterlist-item">
                      <div class="meida-left">
                        <img onerror="this.src='/public/static/images/nobody.gif'" src="">
                      </div>
                      <div class="meida-right">
                        <p></p>
                        <mdall></mdall>
                      </div>
                    </a>
                       ";s:3:"tpl";s:920:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
                    <a href="<?php echo urls('weibo/content/show','id='.$rs['uid']); ?>" target="_blank" class="layadmin-privateletterlist-item">
                      <div class="meida-left">
                        <img onerror="this.src='/public/static/images/nobody.gif'" src="<?php echo $rs['icon']; ?>">
                      </div>
                      <div class="meida-right">
                        <p><?php echo $rs['username']; ?></p>
                        <mdall><?php echo format_time($rs['visittime'],true); ?></mdall>
                      </div>
                    </a>
                      <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:11:"_filemtime_";i:1605519652;}