//var qun_api_url='';
var act_type = '';
function qun_api(id,type,callback){	
	var url = qun_api_url+'?id='+id+"&type="+type+"&"+Math.random();
	if(type=='quit'){
		return quitGroup(id,url,callback);
	}
	if(type=='up'){
		act_type = type;
	}

	$.get(url,function(res){
		if(res.code==0){	//新用户加入成功
			success_join(res,id,callback);
			//layer.msg(act_type=='up'?'升级成功':"加入成功！");
		}else if(res.code==2){	//只能授权码加入
			join_need_sn(url,callback);
		}else if(res.code==3){	//授权码或付费才可加入
			choose_join_type(url,res,callback);
		}else if(res.code==4){	//只能付费加入
			join_need_money(url,res,callback);
		}else{
			err_msg(res,callback);
			//layer.alert("提示:"+res.msg);
		}
		//if(typeof(callback)=='function')callback(res);
	});
}

function err_msg(res,callback){
	var msg = res.msg;
	if(msg.indexOf('充值')>-1||msg.indexOf('不足')>-1){
		layer.confirm(res.msg+'<br>你是否需要马上充值?',{title:'升级提示!',btn:['马上充值','以后再说']},function(){
			window.location.href = res.data.payurl;
		});
	}else{
		layer.alert("提示-:"+res.msg);
		if(typeof(callback)=='function')callback(res);
	}
}


function success_join(res,id,callback){
	if(act_type=='up'){
		layer.msg('升级成功');
		if(typeof(callback)=='function')callback(res);
		return ;
	}
	if(res.data.upgroup==1){
		layer.confirm(res.msg,{title:'升级提示!',btn:['马上升级','以后再说']},function(){
			qun_api(id,'up',callback);
		});
	}else{
		layer.msg(res.msg);
	}	
}


function choose_join_type(url,res,callback){
	var msg = res.msg;
	layer.closeAll();
	layer.confirm(msg,{
            btn: ["选择付费","选择授权码","取消"]
        },function(){
			join_need_money(url,res,callback);
	},function(){
		join_need_sn(url,callback);
	})
}

var buy_group_time = -1;
function choose_group_time(time){
	buy_group_time = time;
}

function join_need_money(url,res,callback){
	var msg = res.msg;
	var ar = res.data.money_time;
	layer.closeAll();
	if(ar.length>0){
		var str = '';
		$.each(ar,function(i,o){
			str += '<input onclick="choose_group_time('+o.time+')" type="radio" name="d">'+o.title+'：'+o.money+'元'+'<br>';
		});		
		layer.open({
				type: 1,
				title:'请选择一种有效时长',
				//area: ['390px', '330px'],
				content:'<div style="margin:15px;line-height:25px;"><input type="radio" name="d" checked onclick="choose_group_time(-1)"> 永久有效,需要 '+res.data.money+' 元<br>'+str+'</div>',
				btn: ['确认', '取消'], 
				yes:function(index){
					layer.close(index);
					$.get(url+"&money_type="+buy_group_time,function(res){
						if(res.code==0){
							layer.msg(act_type=='up'?'升级成功':"加入成功！");
						}else{
							err_msg(res);
							//layer.alert("提示:"+res.msg);
						}
						if(typeof(callback)=='function')callback(res);
					});
				}
		});
	}else{
		layer.confirm(msg,{
			title:'请选择',
            btn: ["我要付费","取消"],
			//area:['80%','300px'],
        },function(){
			$.get(url+"&money_type=-1",function(res){
				if(res.code==0){
					layer.msg(act_type=='up'?'升级成功':"加入成功！");
				}else{
					err_msg(res);
					//layer.alert("提示:"+res.msg);
				}
				if(typeof(callback)=='function')callback(res);
			});
		});
	}
}

function join_need_sn(url,callback){
	var index = layer.prompt({
		   title : '请输入正确的授权码',
		   formType:0,
	},function(val, index){
		$.post(url,{'sncode':val},function(res){
			if(res.code==0){
				layer.msg(act_type=='up'?'升级成功':"加入成功！");
				layer.close(index);
			}else{
				layer.msg('提示:'+res.msg,{time:1000});
			}
			if(typeof(callback)=='function')callback(res);
		});		
	});
}

function quitGroup(id,url,callback){
	layer.confirm('你确认要退出吗?', {icon: 3, title:'提示'}, function(index){
		layer.close(index);
		//"{:urls('wxapp.member/quit',['id'=>$id])}?"+Math.random()
		$.get( url ,function(res){
			if(res.code==0){
				layer.alert("你已退出！");
				//$(".JoinBut").hide();
			}else{
				layer.alert("退出失败:"+res.msg);
			}
			if(typeof(callback)=='function')callback(res);
		})		
	});
}