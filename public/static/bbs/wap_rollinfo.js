//显示今日发贴统计数据
$(function(){
	var today_post = 0;
	var yesterday_post = 0;
	var total_post = 0;
	var total_topic = 0;
	var day_top_post = 0;
	var total_member = 1;
	var new_member = '';
	$.get(infomsg_url,function(res){
		if(res.code==0){
			today_post = res.data.today_post;
			yesterday_post = res.data.yesterday_post;
			total_post = res.data.total_post;
			total_topic = res.data.total_topic;
			day_top_post = res.data.day_top_post;
		}
		$("#div_today_post").html(today_post);
		$("#div_yesterday_post").html(yesterday_post);
		$("#div_total_topic").html(total_topic);
		$("#div_total_post").html(total_post);
		$("#div_day_top_post").html(day_top_post);
		$("#div_total_post").html(total_post);
	});
});


//滚动显示今日发贴
function autoScroll(obj){  
	$(obj).find("ul").animate({  
		marginTop : "-35px"  
	},1000,function(){  
		$(this).css({marginTop : "0px"}).find("li:first").appendTo(this);  
	})  
}
$(function(){ 
	$.get(get_new_member,function(res){
		if(res.code==0){
			$("#div_total_member").html(res.paginate.total);
			$("#div_new_member").html(res.data[0].username);
		}		
	});     
	var scroll=setInterval('autoScroll(".auto-roll")',2500);
    $(".auto-roll").hover(function(){
		clearInterval(scroll);
	},function(){
		scroll=setInterval('autoScroll(".auto-roll")',2500);
	});
});
