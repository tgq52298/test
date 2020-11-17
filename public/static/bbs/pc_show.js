
//点击图片查看大图
jQuery(document).ready(function() {
	$(".content_html img").each(function(){
		$(this).click(function(){
			window.open($(this).attr('src'));
		});
	});
	$(".ShowComment .replycontent img").each(function(){
		$(this).click(function(){
			window.open($(this).attr('src'));
		});
		$(this).css({"max-width":'700px',});
	});
	bbslou();
});


//收藏夹
function add_fav(id){
	var url = fav_add_url+"&id="+id;
	$.get(url,function(res){
		if(res.code==0){
			layer.msg('收藏成功');
		}else{
			layer.alert(res.msg);
		}
	})
}

//回复插入表情
function choose_face(obj,face){
	$(obj).find('img').css('border','1px solid red');
	$(".replayBox textarea").last().insert({"text":face});
}


//楼层
function bbslou(){
	var lou = 0;
	$(".ShowComment .lou").each(function(){
		lou++;
		$(this).html(lou+'楼')
	});
}


//给用户发短消息
var haveSendMsg = false;
function sendmsg(name,ifsend){
	if(check_jump_login()!=true) return ;
	if(ifsend==true){
		var contents = $(".sendmsgBox textarea").val();
		contents = contents.replace(new RegExp('<',"g"),'&lt;');
		contents = contents.replace(new RegExp('>',"g"),'&gt;');
		contents = contents.replace(new RegExp('\n',"g"),'<br>');
		contents = contents.replace(new RegExp(' ',"g"),'&nbsp;');	
		layer.closeAll();
		if(contents==''){
			layer.alert('内容不能为空!');
			return ;
		}
		if(haveSendMsg==true){
			layer.msg('请不要重复提交');
			return ;
		}
		haveSendMsg = true;
		layer.msg('正在发送消息,请稍候...');
        $.post(post_msg_url, {content:contents,touser:name}).success(function (res) {
			haveSendMsg = false;
            if(res.code==0){
				layer.closeAll(); //关闭所有层
				layer.msg('消息发送成功！');
				$(".sendmsgBox textarea").val('');
			}else{
				layer.alert(res.msg);
			}
		}).fail(function () {
			layer.open({title: '提示',content: '服务器发生错误'});
		});
	}else{
		layer.open({
		  type: 1,
		  title:'给 '+name+' 发私信',
		  area: ['600px','450px'], //宽高，高参数忽略
		  content: '<ul class="sendmsgBox" style="text-align:center;"><ol><textarea style="width:560px;height:300px;margin:10px;" placeholder="请输入要对他的私信留言"></textarea></ol><li><button onclick="layer.closeAll();" style="padding:10px;">取消</button>  <button style="margin-left:50px;padding:10px;" onclick="sendmsg(\''+name+'\','+true+');">确认发送</button></li></ul>',
		});
	}
}


//修改信息
function editinfo(aid,id){
	var url;
	if(id>0){
		url = edit_reply_url + id;
	}else{
		url = edit_topic_url + aid;
	}
	location.href = url;
}


//删除信息
function delinfo(aid,id){
	var url;
	if(id>0){
		url = delete_reply_url + id;
	}else{
		url = delete_topic_url + aid;
	}
	$.get(url,function(res){
		if(res.code==0){
			layer.alert("删除成功！");			
			if(id==0){
				location.href = bbs_url;
			}else{
				location.reload();
			}
		}else{
			layer.msg("删除失败:"+res.msg,{time:1500});
		}	
	});
}


//主题点赞
function TopicAgree(){	
	$.get(topic_agree_url,function(res){
		if(res.code==0){
			var num =  $('#topic_agree').html();
			num++;
			$('#topic_agree').html(num);
			layer.msg("点赞成功！",{time:1500});
		}else{
			layer.msg("点赞失败:"+res.msg,{time:1500});
		}	
	});
}


//回复点赞
function reply_agree(id){
	$.get(reply_agree_url + id ,function(res){
		if(res.code==0){
			var num =  $('.replyAgree'+id).html();
			num++;
			$('.replyAgree'+id).html(num);
			layer.msg("点赞成功！",{time:1500});

		}else{
			layer.msg("点赞失败:"+res.msg,{time:1500});
		}	
	});
}


//显示分页
var page=1;
var check_showMore=1;
var pid = 0;
scroll_get = true;
function ShowMoreComment(){
	page++;
	check_showMore=0;
	$('.ShowMoreComment').fadeIn();
	$.get(pageurl + "?page="+page+"&"+Math.random(),function(res){
		$('.ShowMoreArtic').fadeOut();
		if(res.code==0){
			if(res.data==''){
				layer.msg("没有更多内容了！",{time:500});
				$('.ShowMoreComment').hide();
			}else{
				$('.ListComment').append(res.data);
				check_showMore=1;
				bbslou();	//楼层显示
				give_jifen();	//重置打赏积分事件
				set_jifen_list();
				scroll_get = true;
			}
		}else{
			layer.msg(res.msg,{time:2500});
		}
	});
}

//弹出层进行评论
function pop_post(){
	var contents = $(".replayBox textarea").last().val();	//会出现两个元素,只能用最后一个	
	contents = format_content(contents);
	if(contents.replace(/\[(face\d+)\]/g,"")==""){
		layer.alert('不允许只发表情!');
		return false;			
	}
	//layer.closeAll();
	if(contents==''){
		layer.alert('评论内容不能为空!');
		return false;
	}
	
	postcontent({'content':contents},true);
	//$(".replayBox textarea").val('')
}

//回复
function replyuser(id,touser){
	pid = id;
	//ueditor.focus()
	if(check_jump_login()!=true) return ;
	layer.open({
	  type: 1,
	  title:'给TA回复',
	  area: ['600px','550px'], //宽高，高参数忽略
	  content: $(".div-replayBox").html(),
	});
	paseImg( $(".replayBox textarea").last() );	//截图
	if(typeof touser!='undefined'){
		$(".replayBox textarea").last().val(touser);
	}
}

function keySend(event) {
	if (event.ctrlKey && event.keyCode == 13) {
		pop_post();
	}
}


function check_jump_login(){
	if(my_uid==""){
		layer.confirm('你还没登录,确认要登录吗？', {
            btn : [ '确定', '取消' ]
        }, function(index) {
            location.href = login_url;
        });		
	}else{
		return true;
	}
}






//ctrl+enter 事件
function postform(){
	layer.confirm('你确认要提交吗?',{
            btn:['确定','取消']
        },function(index){
			var form_data = $('.ajax-post').serialize();
			postcontent(form_data);
        }
	);
}

//检查用户登录状态
function check_login(){
	if(my_uid!=''){
		return true;
	}
	layer.open({
	  type: 2,
	  title: '用户登录',
	  shadeClose: true,
	  shade: false,
	  maxmin: true, //开启最大化最小化按钮
	  area: ["750px", "780px"],
	  content: login_url+"?&type=iframe",
	  end: function(){
		  	//window.location.reload();
			$.get(login_check_url + "?" + Math.random(),function(res){
				layer.closeAll();
				if(res.code==0){
					my_uid = res.data.uid;
					layer.msg("登录成功,你现在可以发表信息了",{time:1500});
				}else{
					layer.msg("登录失败");
				}	
			});
		}
	});
}



var havepost = false;
function postcontent(form_data,islayer){
	if(check_login()!==true){	//检查用户登录状态
		return false;
	}
			var that  = ueditor;
			var url = posturl;
			if(pid>0){
				url += '?pid='+pid;
			}
			if(islayer!==true && ((is_ueditor && UE.getEditor('content').hasContents()==false)||(!is_ueditor && $('#content').val()==""))){
				layer.alert('内容不能为空')
				return false;
			}
			if(havepost==true){
				layer.msg('请不要重复提交');
				return ;
			}
			layer.msg('内容提交中,请稍候');
			havepost = true;
            $.post(url, form_data).success(function (res) {
				havepost = false;
                if(res.code==0){
					if(pid>0){
						$('.repalyinfs'+pid).html(res.data);
					}else{
						$('.ListComment').html(res.data);
						//$('.ShowMoreComment').fadeIn();
					}
					give_jifen();	//重置打赏积分事件
					layer.closeAll(); //关闭所有层
					if(res.msg!=''){
						layer.msg(res.msg,{icon: 6,//shade : [0.5 , '#000' , true]
						});
					}else{
						layer.msg('发表成功！');
					}
					//that.hide();
					if(is_ueditor){
						UE.getEditor('content').setContent('');
					}else{
						$('#content').val('')
					}
					
					$(".replayBox textarea").val('');
					//HiddenShowMoreComment();
					//隐藏的内容需要刷新才可见
					if(($(".content_html").html()).indexOf('需要刷新网页才可见')>0){
						window.location.reload();
					}
				}else{
					layer.alert(res.msg);
				}
            }).fail(function () {
				layer.open({title: '提示',content: '服务器发生错误'});
            });            
}





function format_content(contents){
	contents = contents.replace(new RegExp('"',"g"),'&quot;');
	contents = contents.replace(new RegExp("'","g"),'&#39;');
	contents = contents.replace(new RegExp('<',"g"),'&lt;');
	contents = contents.replace(new RegExp('>',"g"),'&gt;');
	contents = contents.replace(new RegExp('\n',"g"),'<br>');
	contents = contents.replace(new RegExp('  ',"g"),'&nbsp;&nbsp;');
	contents = contents.replace(new RegExp('\\[img\\]([^\\s\[\]+)\\[\/img\\]',"g"),'<img src="$1"/>');
	return contents;
}



function give_jifen(){
	$(".give-money").each(function(){
		var that = $(this);
		var id = that.data('id');
		var rid = typeof(that.data('rid'))=='undefined' ? 0 : that.data('rid');
		var cid = typeof(that.data('cid'))=='undefined' ? 0 : that.data('cid');
		
		//下一个元素显示数值
		/*
		that.next().each(function(){
			var obj = $(this);
			$.get(count_money_url,{'sysname':sys_dirname,'id':id,'rid':rid,'cid':cid},function(res){
				if(res.code==0){
					if(obj.html()!='')obj.html(''+res.data+'积分');
					obj.mouseenter(function(){
						obj.unbind("mouseenter");
						layer.tips('点击图标可打赏，点击数值可以查看详情', obj, {tips:[3,'#888'],time:1000});
					});
					obj.click(function(){						
						getlist();
					});
				}else{
					obj.click(function(){
						putnum();
					});
				}
			});
		});*/
		
		//显示打赏用户
		var getlist = function(){
			layer.closeAll();
			layer.load(1);
			$.post(getlist_money_url,{'sysname':sys_dirname,'id':id,'rid':rid,'cid':cid},function(res){
				layer.closeAll();
				if(res.code==0){
					var str = '';
					res.data.forEach(function(rs){
						str += '<div style="padding:5px;"><span style="color:blue;">' + rs.username + '</span> 打赏积分: ' + rs.money + ' 个 　　<span style="color:#666;">['+rs.create_time+']</span></div>';
					});
					layer.open({
					  title:'打赏用户列表',
					  type: 1,
					  area: '400px',
					  content: '<div style="padding:15px;">' + str + '</div>',
					});
				}else{
					layer.alert(res.msg);
				}
			}).fail(function(){layer.closeAll();layer.alert('页面出错了!')});
		}

		//打赏输入积分个数
		var putnum = function(){
			layer.prompt({
				  formType: 0,
				  value: '3',
				  title: '请输入要打赏的积分个数',
				  //area: ['100px', '20px'] //formType:2 自定义文本域宽高
				}, function(value, index, elem){
					layer.close(index);
					postdata(value);
				}
			);
		};
		
		//打赏点击事件
		that.click(function(){
			putnum();
		});
		that.next().click(function(){
			putnum();
		});
		
		//打赏提交数据
		var postdata = function(num){			
			layer.load(1);
			$.post(give_money_url,{'sysname':sys_dirname,'money':num,'id':id,'rid':rid,'cid':cid,'about':''},function(res){
				layer.closeAll();
				if(res.code==0){
					get_jifen_list();
					layer.msg('打赏成功,谢谢你!');
				}else{
					layer.alert(res.msg);
				}
			}).fail(function(){layer.closeAll();layer.alert('页面出错了!')});
		}		
	});
}
$(document).ready(function () {
	give_jifen();
});


$(document).ready(function () {
	var obj; //浮动显示的元素
	//var rightBoxH = $('.RightSide').height();	//右边页面的高度	
	var floatHeight = 0;	//浮动显示的元素距离网页顶部的距离
	var side_bottom_height = 0;
	var check_show = false;
	
	var window_height = $(window).height();
	var all_load = false;	//是否全部加载完毕
	setTimeout(function(){
		all_load = true;
	},4000);

	$(window).scroll(function () {		
		var scroll_Height = $(window).scrollTop(); //页面滚动的高度距离
		
		//滚动显示更多
		if (scroll_get==true && (400+scroll_Height+window_height)>$(document).height()) {
			scroll_get = false;
			//layer.msg('内容加截中,请稍候',{time:1000});
			//ShowMoreComment();
		}

		if(all_load && scroll_Height>window_height && side_bottom_height==0){
			side_bottom_height = $('.RightSide').offset().top+$('.RightSide').height();
		}

		if(all_load && scroll_Height>window_height && scroll_Height>side_bottom_height){
			if(check_show == false){
				check_show = true;
				if(floatHeight==0){
					obj = $('.chat_warp');
					if(obj.length<1){
						obj = $(".RightSide .c_diypage").first();
					}
					floatHeight = obj.height();	//元素距离网页顶部的距离					
				}
				obj.addClass('RightBase1'); //让右边漂浮起来
			}			
			obj.css({'top':(scroll_Height-floatHeight+200)+'px'});
		}else if(check_show==true){
			check_show = false;
			obj.removeClass('RightBase1');
		}

		if (scroll_Height>100) {
			$(".topUpCont").show();
		} else {
			$(".topUpCont").hide();
		}
	});

	$(".topUpCont").click(function () {
		$("html,body").animate({scrollTop:0},500);
	});


});



//百度自动推送
(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https'){
   bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
  }
  else{
  bp.src = 'http://push.zhanzhang.baidu.com/push.js';
  }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();



//输入密码查看内容
function view_content_password(str){
	layer.prompt({
            title: '请输入访问密码',
            formType: 0
       }, function(value){
		   $.get(view_check_password+"?pwd="+value+"&md5str="+str,function(res){
			   if(res.code==0){
				   window.location.reload();
			   }else{
					layer.alert('密码不对');
			   }
		   });
    });
}

//消费积分才能查看
function view_content_paymoney(str){
	layer.confirm('你确认支付吗?',{title:'提醒!',btn:['确认支付','取消']},function(){
		$.get(view_check_pay_url + "?md5str=" + str,function(res){
			if(res.code==0){
				 window.location.reload();
			}else{
				layer.alert(res.msg);
			}
		});
	});
}

var jifen_list_array={};
function get_jifen_list(){
	$.get(give_money_list_url,function(res){
		if(res.code==0){
			jifen_list_array = res.data;
			set_jifen_list();	//积分打赏列表						
		}
	});
}
$(function(){
	get_jifen_list();
});

//积分打赏列表
function set_jifen_list(){
	for(var k in jifen_list_array){
		var str = '';
		jifen_list_array[k].forEach((rs)=>{
			str += `<a href="/member.php/home/${rs.uid}.html" target="_blank" title="${rs.username} ${rs.create_time} 打赏"><span><img src="${rs.user_icon}" onerror="this.src='/public/static/images/nobody.gif'"></span>赏 <em>${rs.money}</em><label> 积分</label></a>`;
		});
		$("#jifen_list_warp_"+k).html(str);
	}
}



//截图
function paseImg(that){		
	var imgReader = function(item) {	
		var blob = item.getAsFile(),	
			reader = new FileReader();	
		reader.onloadend = function(e) {	
			$.ajax({
				url: cut_pic_save_url,	
				type: 'POST',	
				data: {	
					imgBase64: e.target.result	
				},	
				success: function(res) {	
					layer.msg(res.info);	
					if (res.code == 1) {	
						var url = res.path;	
						if (url.indexOf('://') == -1 && url.indexOf('/public/') == -1) {	
							url = (typeof(web_url) != 'undefined' ? web_url : '') + '/public/' + url;	
						}	
						var old = that.val();	
						that.val(old + "\r\n[img]" + url + "[/img]\r\n");	
					}	
				}	
			})	
		};	
		reader.readAsDataURL(blob);	
	};
	that.get(0).addEventListener("paste", function(e) {	
		var clipboardData = e.clipboardData,	
			i = 0,	
			items,	
			item,	
			types;	
		if (clipboardData) {	
			items = clipboardData.items;	
			if (!items) {	
				return;	
			}	
			item = items[0];	
			types = clipboardData.types || [];	
			for (; i < types.length; i++) {	
				if (types[i] === 'Files') {	
					item = items[i];	
					break;	
				}	
			}	
			if (item && item.kind === 'file' && item.type.match(/^image\//i)) {	
				imgReader(item);	
			}	
		}	
	});
}