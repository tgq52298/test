<?php
namespace app\weibo\hook;

/**
 * 站内消息提醒
 * @author Administrator
 *
 */
class MsgRemind{
    
	protected $remind = 19;     //超过多少条动态,就弹窗提示
	
	
	//钩子行为
    public function run(&$user){
        $forbig_pop = 0;
		if(empty($user)){	//游客
			return ;
		}elseif(isset($user['sendmsg']['weibo_pop']) && empty($user['sendmsg']['weibo_pop'])){ //设置过,并且禁止显示.
			$forbig_pop = 1;
		}
        if(config('webdb.weibo_remind_num')>0){
            $this->remind = config('webdb.weibo_remind_num');
        }
        $num = $this->remind;
        
        $msgurl = url('weibo/wxapp.msg/checknew');
        $readmsg = url('weibo/api/weibo');
        if(IN_WAP===true){
    print<<<EOT
<script type="text/javascript">
if("{$user['uid']}"!=''){
	$.get("{$msgurl}",function(res){
		if(res.code==0){
            if($forbig_pop!=1 && $.cookie('weibo_msg_remind')!='no' && res.data.num>$num ){
    			layer.confirm('<div style="padding:10px;line-height:150%;text-align:center;"><li style="font-size:30px;color:red;" class="fa fa-fw fa-weibo"></li><br>你有 '+res.data.num+' 条新动态,是否现在查看？</div>', {
    				btn : [ '查看', '晚点', '别提醒' ],
                    btn3:function(index) {set_remind_msg('weibo_pop',0);},
    			},function(index) {
    				location.href="{$readmsg}";
    			},function(index) {
    				$.cookie('weibo_msg_remind', 'no', { expires: 60, path: '/' });   //60分钟提醒一次
    			});
            }
            if(res.data.num>0){
                $(".weibo_msg_num").html(res.data.num);	
                $(".weibo_msg_num").show();
            }
		}
	})
}
</script>
EOT;
        }else{
            print<<<EOT
<script type="text/javascript">
if("{$user['uid']}"!=''){
	$.get("{$msgurl}",function(res){
		if(res.code==0){
            if($forbig_pop!=1 && $.cookie('weibo_msg_remind')!='no' && res.data.num>$num){
                pc_weibo_remind_msg(res.data);
            }
            if(res.data.num>0){
                $(".weibo_msg_num").html(res.data.num);	
                $(".weibo_msg_num").show();
            }            
		}
	})
}

function pc_weibo_remind_msg(data){
	layer.open({
	  type: 1,
	  title: '你有新的动态消息',
	  closeBtn: 1, //不显示关闭按钮
	  shade: [0.3,'#333'], //透明度背景
	  area: ['250px', '200px'],
	  //offset: 'rb', //右下角弹出
	  //time: 3000, //4秒后自动关闭
        //shift: 4,
	  anim: 2,
	  content: '<div style="padding:10px;line-height:250%;text-align:center;"><li style="font-size:30px;color:red;" class="fa fa-fw fa-weibo"></li><br>你有 '+data.num+' 条微博动态消息,是否现在查看?<br><button style="padding:5px;" onclick="layer.closeAll();set_remind_msg(\'weibo_pop\',0);">关闭提醒</button> <button style="padding:5px;" onclick="layer.closeAll();waite_weibo_view();">晚点再看</button> <button style="padding:5px;" onclick="layer.closeAll();view_weibo_msg();">立即查看</button> </div>', //iframe的url，no代表不显示滚动条
	  end: function(){ //关闭事件
            //waite_weibo_view();		
	  }
	});
}

function view_weibo_msg(){
	layer.open({
		  type: 2,
		  title: '查阅消息',
		  shadeClose: true,
		  shade: false,
		  maxmin: true, //开启最大化最小化按钮
		  area: ['1000px', '600px'],
		  content: '{$readmsg}'
		});
}

function waite_weibo_view(){
	$.cookie('weibo_msg_remind', 'no', { expires: 60, path: '/' });   //60分钟提醒一次
}

</script>
EOT;
        }
		$url = murl('member/remind/api');
		print<<<EOT
<script type="text/javascript">
function set_remind_msg(name,value) {
	layer.confirm('你确认要关闭弹窗提醒功能吗?以后也可以在会员中心重新开启',{btn:['确定','取消']},function(){
		$.get("{$url}?name="+name+"&value="+value,function(res){
			layer.closeAll();
			if(res.code==0){				
				layer.msg('成功关闭提醒');
			}else{
				layer.alert('关闭失败');
			}
		});
	});
}
</script>
EOT;

    }
    
}