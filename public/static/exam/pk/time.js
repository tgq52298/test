var ii,jj,count,MM,SS,MS,total_time,dd,start_time,t1,t2;



function begin_time(){
	stop_time();
	ii = 0;
	jj = 0;
	count = 0;
	MM = 0;
	SS = 59;
	MS = 9;
	total_time = (MM+1)*600;
	dd = 180*(MM+1);
	MM = "0" + MM;
	start_time = setInterval("showTime()",100);
	t1 = setInterval("start1()",100);
}

function stop_time(){
	clearInterval(start_time);
	clearInterval(t1);
	clearInterval(t2);
	dd=0;//恢复
	$(".pie2").css("-o-transform","rotate(" + dd + "deg)");
	$(".pie2").css("-moz-transform","rotate(" + dd + "deg)");
	$(".pie2").css("-webkit-transform","rotate(" + dd + "deg)");
}

function showTime(){
	total_time = total_time - 1;
	if(total_time==0){
		stop_time();
		post_ans(true); //强制核对,并且进入下一题
	}else{
		if(total_time>0 && MS>0){
			MS = MS - 1;
			if(MS < 10){MS = "0" + MS};
		};
		if(MS==0 && SS>0){
			MS = 10;
			SS = SS - 1;
			if(SS < 10){SS = "0" + SS};
		};
		if(SS==0 && MM>0){
			SS = 60;
			MM = MM - 1;
			if(MM < 10){MM = "0" + MM};
		};
	};
	//$(".time span").html(MM + ":" + SS + ":" + MS);
	$(".time span").html( SS );
};
function start1(){
	ii = ii + 0.6;
	count = count + 1;
	if(count==300){
		count = 0;
		clearInterval(t1);
		t2 = setInterval("start2()",100);
	};
	$(".pie1").css("-o-transform","rotate(" + ii + "deg)");
	$(".pie1").css("-moz-transform","rotate(" + ii + "deg)");
	$(".pie1").css("-webkit-transform","rotate(" + ii + "deg)");
};
function start2(){
	jj = jj + 0.6;
	count = count + 1;
	if(count==300){
		count = 0;
		clearInterval(t2);
		t1 = setInterval("start1()",100);
	};
	$(".pie2").css("-o-transform","rotate(" + jj + "deg)");
	$(".pie2").css("-moz-transform","rotate(" + jj + "deg)");
	$(".pie2").css("-webkit-transform","rotate(" + jj + "deg)");
};
