<?php
//000000036000
 exit();?>
a:28:{s:13:"pc_layout_001";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:30:" 
		<?php echo $datas; ?>
	 ";}s:21:"pchr_index_banner_ad1";a:2:{s:4:"demo";s:203:" <div class="content_ad" style="width:1200px; overflow:hidden; margin:auto;"><a href='#' target=_blank><img src="/public/static/hr/default/demo/ad1.jpg"  width='980'  height='65' border='0' /></a></div> ";s:3:"tpl";s:213:" 
	 
	<div class="content_ad" style="width:1200px; overflow:hidden; margin:auto;"><a href=<?php echo $url; ?> target=_blank><img src="<?php echo $picurl; ?>"  width='980'  height='65' border='0' /></a></div>
	 ";}s:20:"pchr_index_hot_title";a:2:{s:4:"demo";s:14:" 热门职位 ";s:3:"tpl";s:14:" 热门职位 ";}s:24:"pchr_index_hot_listdata1";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:398:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
							<a href="<?php echo $rs['url']; ?>" target="_blank"><?php echo $rs['title']; ?></a>
							  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:21:"pchr_index_banner_ad2";a:2:{s:4:"demo";s:167:" <div class="side_ad"><a href="<?php echo $url; ?>" target=_blank><img src='/public/static/hr/default/demo/ad2.gif'  width='250'  height='100' border='0' /></a></div> ";s:3:"tpl";s:166:" 
			
			<div class="side_ad"><a href="<?php echo $url; ?>" target=_blank><img src='<?php echo $picurl; ?>'  width='250'  height='100' border='0' /></a></div>
			 ";}s:26:"pchr_index_experience_head";a:2:{s:4:"demo";s:14:" 求职经验 ";s:3:"tpl";s:14:" 求职经验 ";}s:26:"pchr_index_experience_data";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:436:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;if($rs['title']): ?>
					·<a href="<?php echo $rs['url']; ?>" target="_blank"><?php echo get_word($rs['title'],33); ?></a><br>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?> ";}s:25:"pchr_index_recommend_head";a:2:{s:4:"demo";s:194:" 
								  <div id="tj" class="tag1" onmouseover="chose_titletype('1')">推荐职位</div>
								  <div id="tp" class="tag2" onmouseover="chose_titletype('2')">推荐人才</div>
								 ";s:3:"tpl";s:194:" 
								  <div id="tj" class="tag1" onmouseover="chose_titletype('1')">推荐职位</div>
								  <div id="tp" class="tag2" onmouseover="chose_titletype('2')">推荐人才</div>
								 ";}s:24:"pchr_index_recommend_job";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:765:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
										<div class="lt"> 
											<span class="t1"><a href="<?php echo $rs['url']; ?>" target="_blank"><?php echo $rs['title']; ?></a></span>
											<span class="t2"><?php echo $rs['workplace']; ?></span> 
											<span class="t3"><a href="<?php echo get_hy_url($info['uid'],$info['ext_id'],$info['ext_sys']); ?>" target="_blank"><?php echo get_hy_name($rs['uid'],$rs['ext_id'],$rs['ext_sys']); ?></a></span>													
										</div>
										  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:30:"pchr_index_recommend_personnel";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:694:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
											<div class="lt"> 
												<span class="t1"><a href="<?php echo $rs['url']; ?>" target="_blank"><?php echo $rs['truename']; ?></a></span> 
												<span class="t5"><?php echo $rs['alma_mater']; ?></span>
												<span class="t2"><?php echo $rs['school_age']; ?></span> 
												<span class="t4"><?php echo $rs['speciality']; ?></span>
											</div>
										  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:22:"pchr_index_action_head";a:2:{s:4:"demo";s:214:" 
									<div id="BB1" class="tag1" onmouseover="chose_Type('1')">企业服务<?php echo $userdb['uid']; ?></div>
									<div id="BB2" class="tag2" onmouseover="chose_Type('2')">个人服务</div>
									 ";s:3:"tpl";s:214:" 
									<div id="BB1" class="tag1" onmouseover="chose_Type('1')">企业服务<?php echo $userdb['uid']; ?></div>
									<div id="BB2" class="tag2" onmouseover="chose_Type('2')">个人服务</div>
									 ";}s:32:"pchr_index_companyaction_content";a:2:{s:4:"demo";s:568:" 
											<div class="tbf1"><a href="<?php echo murl('content/postnew'); ?>" target="_blank" class='_pop' onclick="cklog();">发布职位</a></div>
											<div class="tbf2"><a href="<?php echo murl('content/index',['mid'=>1]); ?>" target="_blank" class='_pop'>职位管理</a></div>
											<div class="tbf3"><a href="<?php echo murl('content/jobvita',['mid'=>2]); ?>" target="_blank" class='_pop'>求职信</a></div>
											<div class="tbf4"><a href="<?php echo urls('content/index',['mid'=>2]); ?>" target="_blank">找人才</a></div>
											 ";s:3:"tpl";s:568:" 
											<div class="tbf1"><a href="<?php echo murl('content/postnew'); ?>" target="_blank" class='_pop' onclick="cklog();">发布职位</a></div>
											<div class="tbf2"><a href="<?php echo murl('content/index',['mid'=>1]); ?>" target="_blank" class='_pop'>职位管理</a></div>
											<div class="tbf3"><a href="<?php echo murl('content/jobvita',['mid'=>2]); ?>" target="_blank" class='_pop'>求职信</a></div>
											<div class="tbf4"><a href="<?php echo urls('content/index',['mid'=>2]); ?>" target="_blank">找人才</a></div>
											 ";}s:33:"pchr_index_personalaction_content";a:2:{s:4:"demo";s:445:" 
											<div class="tbf2"><a href="<?php echo murl('content/checkvita',['mid'=>2]); ?>" target="_blank" class='_pop'>更新简历</a></div>
											<div class="tbf1"><a href="<?php echo murl('content/checkvita',['mid'=>2,'type'=>2]); ?>" target="_blank">查看简历</a></div>
											<div class="tbf4"><a href="<?php echo murl('content/jobvita',['mid'=>1]); ?>" target="_blank" class='_pop'>申请的职位</a></div>
											 ";s:3:"tpl";s:445:" 
											<div class="tbf2"><a href="<?php echo murl('content/checkvita',['mid'=>2]); ?>" target="_blank" class='_pop'>更新简历</a></div>
											<div class="tbf1"><a href="<?php echo murl('content/checkvita',['mid'=>2,'type'=>2]); ?>" target="_blank">查看简历</a></div>
											<div class="tbf4"><a href="<?php echo murl('content/jobvita',['mid'=>1]); ?>" target="_blank" class='_pop'>申请的职位</a></div>
											 ";}s:26:"pchr_index_areabanner_head";a:2:{s:4:"demo";s:16:"  地区招聘  ";s:3:"tpl";s:16:"  地区招聘  ";}s:22:"pchr_index_banner_adb1";a:2:{s:4:"demo";s:100:" <a href="#" target='_blank'><img src="/public/static/hr/default/demo/adb1.jpg"   border='0' /></a> ";s:3:"tpl";s:101:" <a href="<?php echo $url; ?>" target='_blank'><img src="<?php echo $picurl; ?>"   border='0' /></a> ";}s:22:"pchr_index_banner_adb2";a:2:{s:4:"demo";s:100:" <a href="#" target='_blank'><img src="/public/static/hr/default/demo/adb2.gif"   border='0' /></a> ";s:3:"tpl";s:101:" <a href="<?php echo $url; ?>" target='_blank'><img src="<?php echo $picurl; ?>"   border='0' /></a> ";}s:22:"pchr_index_banner_adb3";a:2:{s:4:"demo";s:100:" <a href="#" target='_blank'><img src="/public/static/hr/default/demo/adb3.gif"   border='0' /></a> ";s:3:"tpl";s:101:" <a href="<?php echo $url; ?>" target='_blank'><img src="<?php echo $picurl; ?>"   border='0' /></a> ";}s:22:"pchr_index_banner_adb4";a:2:{s:4:"demo";s:100:" <a href="#" target='_blank'><img src="/public/static/hr/default/demo/adb4.gif"   border='0' /></a> ";s:3:"tpl";s:101:" <a href="<?php echo $url; ?>" target='_blank'><img src="<?php echo $picurl; ?>"   border='0' /></a> ";}s:22:"pchr_index_banner_adb5";a:2:{s:4:"demo";s:100:" <a href="#" target='_blank'><img src="/public/static/hr/default/demo/adb1.jpg"   border='0' /></a> ";s:3:"tpl";s:101:" <a href="<?php echo $url; ?>" target='_blank'><img src="<?php echo $picurl; ?>"   border='0' /></a> ";}s:21:"pchr_index_banner_ad6";a:2:{s:4:"demo";s:100:" <a href="#" target='_blank'><img src="/public/static/hr/default/demo/adb6.gif"   border='0' /></a> ";s:3:"tpl";s:101:" <a href="<?php echo $url; ?>" target='_blank'><img src="<?php echo $picurl; ?>"   border='0' /></a> ";}s:22:"pchr_index_newjob_head";a:2:{s:4:"demo";s:14:" 最新职位 ";s:3:"tpl";s:14:" 最新职位 ";}s:23:"pchr_index_newjob_title";a:2:{s:4:"demo";s:114:" 
						<td>职位名称</td>
						<td>企业名称</td>
						<td>地区</td>
						<td>月薪</td>
						 ";s:3:"tpl";s:114:" 
						<td>职位名称</td>
						<td>企业名称</td>
						<td>地区</td>
						<td>月薪</td>
						 ";}s:22:"pchr_index_newjob_data";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:766:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
					  <tr class="pos_w"> 
					    <td class="pos"><a href="<?php echo $rs['url']; ?>" target="_blank" ><b><?php echo $rs['title']; ?></b></a></td>
					    <td class="company"><a href="<?php echo get_hy_url($rs['uid'],$rs['ext_id'],$rs['ext_sys']); ?>" target="_blank"><?php echo get_hy_name($rs['uid'],$rs['ext_id'],$rs['ext_sys']); ?></a></td>
					    <td><?php echo $rs['workplace']; ?></td>
					    <td><?php echo $rs['wage']; ?></td>
					  </tr>
					  <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:21:"pchr_index_banner_ad3";a:2:{s:4:"demo";s:172:" <div class="mian_ad"><a href="<?php echo $rs['url']; ?>" target=_blank><img src="/public/static/hr/default/demo/ad3.jpg"  width='715'  height='88' border='0' /></a></div> ";s:3:"tpl";s:178:" 
			 
			<div class="mian_ad"><a href="<?php echo $rs['url']; ?>" target=_blank><img src="<?php echo $rs['picurl']; ?>"  width='715'  height='88' border='0' /></a></div>
			 ";}s:25:"pchr_index_newperson_head";a:2:{s:4:"demo";s:14:" 最新人才 ";s:3:"tpl";s:14:" 最新人才 ";}s:26:"pchr_index_newperson_title";a:2:{s:4:"demo";s:143:" 
						<td>姓名</td>
						<td>所学专业</td>
						<td>工作年限</td>
						<td>性别</td>
						<td>月薪要求</td>
						 ";s:3:"tpl";s:143:" 
						<td>姓名</td>
						<td>所学专业</td>
						<td>工作年限</td>
						<td>性别</td>
						<td>月薪要求</td>
						 ";}s:25:"pchr_index_newperson_data";a:2:{s:4:"demo";s:0:"";s:3:"tpl";s:632:" <?php if(is_array($__LIST__) || $__LIST__ instanceof \think\Collection || $__LIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rs): $mod = ($i % 2 );++$i;?>
					  <tr> 
						<td class="p_name"><a href="<?php echo $rs['url']; ?>" target="_blank"><?php echo $rs['truename']; ?></a></td>
						<td><?php echo $rs['speciality']; ?></td>
						<td><?php echo $rs['workyear']; ?></td>
						<td><?php echo $rs['sex']; ?></td>
						<td><?php echo $rs['wage']; ?></td>
					  </tr>
					   <?php endforeach; endif; else: echo "" ;endif; ?> ";}s:11:"_filemtime_";i:1605519652;}