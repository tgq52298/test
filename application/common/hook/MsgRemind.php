<?php
namespace app\common\hook;

class MsgRemind{
    

    public $info = [
            //归属接口,必填
            'hook_key'=>'layout_body_foot',
            //归属插件,可为空
            'plugin_key'=>'',
            //开发者
            'author'=>'齐博',
            //开发者网站
            'author_url'=>'http://www.php168.com',
            //功能描述
            'about'=>'有新的站内消息,就弹层提醒',
    ];
	
	//钩子行为
    public function run(&$user){
        $forbig_pop = 0;
        if(empty($user)){	//游客
            return ;
        }elseif(isset($user['sendmsg']['msg_pop']) && empty($user['sendmsg']['msg_pop'])){ //设置过,并且禁止显示.
            $forbig_pop = 1;
        }
        $msgurl = murl('member/wxapp.msg/checknew');
        $readmsg = murl('member/msg/index');
        if(IN_WAP===true){
    print<<<EOT
<script type="text/javascript">
if("{$user['uid']}"!=''){
	$.get("{$msgurl}",function(res){
		if(res.code==0){
            if( $forbig_pop!=1 && $.cookie('msg_remind')!='no' ){
    			layer.confirm('你有 '+res.data.num+' 条新的消息,是否现在查看？', {
    				btn : [ '查看', '晚点', '别提醒' ],
                    btn3:function(index) {set_remind_msg('msg_pop',0);},
    			},function(index) {
    				location.href="{$readmsg}";
    			},function(index) {
    				$.cookie('msg_remind', 'no', { expires: 60, path: '/' });   //60分钟提醒一次
    			});
            }
			if(res.data.num>0){
                $(".msg-num").html(res.data.num);	
                $(".msg-num").show();
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
            if( $forbig_pop!=1 && $.cookie('msg_remind')!='no' ){
                pc_remind_msg(res.data);
            }
			if(res.data.num>0){
                $(".msg-num").html(res.data.num);	
                $(".msg-num").show();
            }
		}
	})
}

function pc_remind_msg(data){
	layer.open({
	  type: 1,
	  title: '你有新的消息',
	  closeBtn: 1, //不显示关闭按钮
	  shade: [0.3,'#333'], //透明度背景
	  area: ['250px', '200px'],
	  //offset: 'rb', //右下角弹出
	  //time: 5000, //2秒后自动关闭
        //shift: 4,
	  anim: 1,
	  content: '<div style="padding:10px;line-height:350%;text-align:center;">你有 '+data.num+' 条新消息,是否现在查看?<br><button style="padding:5px;" onclick="layer.closeAll();set_remind_msg(\'msg_pop\',0);">关闭提醒</button> <button style="padding:5px;" onclick="layer.closeAll();waite_view();">晚点再看</button> <button style="padding:5px;" onclick="layer.closeAll();view_msg();">立即查看</button> </div>', //iframe的url，no代表不显示滚动条
	  end: function(){ //关闭事件
            //waite_view();		
	  }
	});
}

function view_msg(){
	layer.open({
		  type: 2,
		  title: '查阅消息',
		  shadeClose: true,
		  shade: false,
		  maxmin: true, //开启最大化最小化按钮
		  area: ['900px', '600px'],
		  content: '{$readmsg}'
		});
}

function waite_view(){
	$.cookie('msg_remind', 'no', { expires: 60, path: '/' });   //60分钟提醒一次
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
	
	
	//卸载时运行 
	public function uninstall($id=0){		
	}
	
	//安装时运行
	public function install($id=0){		
	}
    
}