var Mpage = 1;
var byorder = 'list';
var showmorebbs = '<button type="button" onclick="ShowMoreBBs()">查看更多</button>';
function ShowMoreBBs(){
	Mpage++;
	$('.ShowMoreBBs').html('内容加载中……');
	$.get(page_url + Mpage + '&order=' + byorder,function(res){
		if(res.code==0){
			if(res.data==''){
				layer.msg("已经显示完了！",{time:500});
				$('.ShowMoreBBs').html('');
			}else{				
				$('.ShowLists').append("<span class='Mpage"+Mpage+"'></span>");
				$('.Mpage'+Mpage).hide();
				$('.Mpage'+Mpage).html(res.data);
				$('.Mpage'+Mpage).fadeIn();
				$('.ShowMoreBBs').html(showmorebbs);
				scroll_get = true;
			}
		}else{
			layer.msg(res.msg,{time:2500});
		}
	});
}


function listbbs(num,order){
	Mpage=1;
	byorder=order;
	$('.ListBox .head span').removeClass('ck');
	$('.ListBox .head span').eq(num).addClass('ck');
	$.get(page_url + Mpage + '&order=' + byorder,function(res){
		if(res.code==0){
			if(res.data==''){
				layer.msg("没有相应的帖子！",{time:500});
				$('.ShowLists').html('');
				$('.ShowMoreBBs').html('');
			}else{
				$('.ShowLists').html("<span class='Mpage"+Mpage+"'></span>");
				$('.Mpage'+Mpage).hide();
				$('.Mpage'+Mpage).html(res.data);
				$('.Mpage'+Mpage).fadeIn();
				$('.ShowMoreBBs').html(showmorebbs);
			}
		}else{
			layer.msg(res.msg,{time:2500});
		}
	});
}



var scroll_get = true;	//滚动显示更多 做个标志,不要反反复复的加载

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
			layer.msg('内容加截中,请稍候',{time:1000});
			ShowMoreBBs();
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

