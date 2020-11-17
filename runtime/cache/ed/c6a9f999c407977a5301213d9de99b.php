<?php
//000000036000
 exit();?>
a:2:{s:16:"bbs_list_page_pc";s:1586:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
					<ul class="list">
						<li class="icon"><a href="<?php echo get_url('user',['uid'=>$rs['uid']]); ?>" target="_blank"><img src="<?php echo get_user_icon($rs['uid']); ?>" onerror="this.src='/public/static/images/nobody.gif'" ></a></li>
						<li class="info">
							<div class="title"><a target="_blank" href="<?php echo urls('content/show',['id'=>$rs['id']]); ?>"><?php echo $rs['title']; ?></a>
							<?php if($rs['list']>time()): ?><span class="top">顶</span><?php endif; if($rs['status'] == '2'): ?><span class="com">精</span><?php endif; if($rs['view'] > '200'): ?><span class="hot">热</span><?php endif; if((time()-$rs['create_time']<3600*24)): ?><span class="hot">新</span> <?php endif; ?></div>
							<div class="more"><a href="<?php echo get_url('user',['uid'=>$rs['uid']]); ?>" target="_blank"><?php echo $rs['username']; ?></a> <span><i class="fa fa-clock-o"></i><?php echo format_time($rs['create_time'],true); ?> <i class="fa fa-fw fa-user-o"></i>回复: <?php echo $rs['replyuser']; ?> <?php echo format_time($rs['update_time'],true); ?></span></div>
						</li>
						<li class="hits"><i class="si si-eye"></i><?php echo $rs['view']; ?></li>
						<li class="reply"><i class="fa fa-commenting-o"></i><?php echo $rs['replynum']; ?></li>
					</ul>
				  <?php endforeach; endif; else: echo "" ;endif; ?> ";s:11:"_filemtime_";i:1605519652;}