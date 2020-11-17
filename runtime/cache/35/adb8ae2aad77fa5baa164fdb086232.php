<?php
//000000036000
 exit();?>
a:2:{s:13:"pc_live_video";a:2:{s:4:"demo";s:757:" 
					<ul class="list">
						<li class="icon"><a href="" target="_blank"><img src="" onerror="this.src='/public/static/images/nobody.gif'"></a></li>
						<li class="info">
							<div class="title"><i class="fa fa-video-camera" style="font-size:16px;color:orange;"></i> <a target="_blank" href="/index.php/qun/show-.html"> 正在  进行视频直播</a>
							</div>
							<div class="more"><a href="" target="_blank"></a> <span><i class="fa fa-clock-o"></i>直播开始时间:  </span></div>
						</li>	
						<li>
							<div class="play_voice">
								<span class="line1"></span>
								<span class="line2"></span>
								<span class="line3"></span>
								<span class="line4"></span>
							</div>
						</li>
					</ul>
		   ";s:3:"tpl";s:1353:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
					<ul class="list">
						<li class="icon"><a href="<?php echo get_url('user',$rs['uid']); ?>" target="_blank"><img src="<?php echo get_user_icon($rs['uid']); ?>" onerror="this.src='/public/static/images/nobody.gif'"></a></li>
						<li class="info">
							<div class="title"><i class="fa fa-video-camera" style="font-size:16px;color:orange;"></i> <a target="_blank" href="/index.php/qun/show-<?php echo $rs['id']; ?>.html"><?php echo get_user_name($rs['uid']); ?> 正在 <?php echo $rs['title']; ?> 进行视频直播</a>
							</div>
							<div class="more"><a href="<?php echo get_url('user',$rs['uid']); ?>" target="_blank"><?php echo get_user_name($rs['uid']); ?></a> <span><i class="fa fa-clock-o"></i>直播开始时间:  <?php echo format_time($rs['start_time'],true); ?></span></div>
						</li>	
						<li>
							<div class="play_voice">
								<span class="line1"></span>
								<span class="line2"></span>
								<span class="line3"></span>
								<span class="line4"></span>
							</div>
						</li>
					</ul>
		  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:11:"_filemtime_";i:1605519652;}