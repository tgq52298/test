<?php
//000000036000
 exit();?>
a:2:{s:16:"pc_bbsindex_link";a:2:{s:4:"demo";s:500:"<li><a href="https://www.qibo168.com" target="_blank">齐博开发网</a></li>
						<li><a href="http://www.qibomb.com" target="_blank">齐博模板网</a></li>
						<li><a href="http://www.qibomoban.com" target="_blank">齐博模板堂</a></li>
						<li><a href="http://www.admin5.net/" target="_blank">A5站长网</a></li>
						<li><a href="http://www.im286.com/" target="_blank">落伍者</a></li>						
						<li><a href="http://www.chinaccnet.com/" target="_blank">中电云集</a></li>";s:3:"tpl";s:693:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
						
						<li><a href="<?php echo $rs['url']; ?>" target="_blank" style="<?php if($rs['font_color']): ?>color:<?php echo $rs['font_color']; ?>;<?php endif; if($rs['bgcolor']): ?>background:<?php echo $rs['bgcolor']; endif; ?>" title="<?php echo $rs['about']; ?>"><?php if($rs['icon']): ?><i class="<?php echo $rs['icon']; ?>"></i><?php endif; ?> <?php echo $rs['title']; ?></a></li>
						  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:11:"_filemtime_";i:1605519652;}