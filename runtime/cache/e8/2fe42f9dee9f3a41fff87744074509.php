<?php
//000000036000
 exit();?>
a:2:{s:15:"admin_index_002";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:826:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
                              <tr>
                                <td><?php echo $i; ?>、<a href="<?php echo get_url('user',$rs['uid']); ?>" target="_blank"><?php echo $rs['username']; ?></a></td>
                                <td>
                                  来源IP:<?php echo $rs['regip']; ?>
                                </td>
                                <td class="col-md-5">注册时间：&nbsp;<?php echo $rs['regdate']; ?></td>
                              </tr>
                                <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:11:"_filemtime_";i:1605583582;}