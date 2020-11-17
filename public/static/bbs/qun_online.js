
//圈子在线人数
var vues = new Vue({
	el: '.list_qun_num',
	data: {
		listdb: [],
	},
	watch:{
      listdb: function() {
        this.$nextTick(function(){	//数据渲染完毕才执行
        })
      }
    },
	methods: {
		add_data:function(array,ar){
			array.forEach((rs)=>{
				ar.forEach((qs)=>{
					if(qs.id==rs.id){
						rs.time = qs.time;
						rs.num = qs.num;
					}
				})
				this.listdb.push(rs);
			});			
		}
	}		  
});


var w_s = new WebSocket(ws_url);
w_s.onmessage = function(e){
	var obj = {};
	try {
		obj = JSON.parse(e.data);
	}catch(err){
		console.log(err);
	}
	if(obj.type=='connect'){
		w_s.send('{"type":"get_qun_num","url":"'+window.location.href+'"}');
	}else if(obj.type=='qun-num'){
		var ar = [];
		obj.qun.forEach((rs)=>{
			if(rs.unum<show_qun_member && rs.num<show_qun_totaluser){	//人数条件都不符合
				return ;
			}
			if(hide_qun_ids.indexOf(','+rs.id+',')>-1){
				return ;	//黑名单
			}else if(rs.num==1 && rs.total_time>1800){ //如果圈子在线人数只有一人,并且时间超过了半小时,就不显示了,避免显示太多的圈子,影响界面
				return ;
			}
			ar.push(rs.id);
		});
		$.post(qun_list_url,{'ids':ar.join(',')},function(res){
			if(res.code==0){
				vues.add_data(res.data,obj.qun);
			}
		});		
	}
}