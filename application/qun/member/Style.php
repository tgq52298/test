<?php
namespace app\qun\member;

use app\common\controller\MemberBase;
use app\qun\traits\C AS Ctraits;
use app\qun\model\Style AS Model;

class Style extends MemberBase
{	
    use Ctraits;
    

    public function index($id=0,$types='')
    {
	    if (empty($id)) {
	        $quns = fun('qun@getByuid',$this->user['uid']);
	        if (count($quns)>1) {
	            $url = url('choose/index').'?url='.urlencode( url('index').'?id=' );
	            $this->redirect($url);
	        }else{
	            $id = $quns[0]['id'];
	        }
	    }
	
		$template_path = TEMPLATE_PATH."qun_style/";     //风格存放路径
		//$file_url = get_url('/template/qun_style/');                        //风格url路径
		$style_url = get_url('/public/static/qun_style/');                //风格样式url路径
	
		$dir=opendir($template_path);
		$listStyle='';
		$i=0;
		$jsword='';
		while( $file=readdir($dir)){
		    if($file!='.' && $file!='..' && $file!='.svn' && is_file($template_path.$file.'/info.php')){
			
				unset($defulatstyle['money'],$defulatstyle['vipstyle']);
				$defulatstyle = include($template_path.$file."/info.php");//风格配置
				if(!$defulatstyle){
					continue;
				}
				
				$defulatstyle['sort'] && $sort_arr[] = $defulatstyle['sort'];//风格分类
				
				if($types){
					if($types!=$defulatstyle['sort']){
						continue;
					}
				}

				$map = [
				        'pageid'=>$id,
				        'uid'=>$this->user['uid'],
				        'stylename'=>$file,				        
				];

				$checkbuy = Model::checkBuyStyle($map);     //检测是否购买了该风格
			
				$thismoney = $defulatstyle['money']?:0;     //风格年费
				$template_config[$i]['styleimg'] = $style_url.$file."/demo_min.jpg";    //风格缩略图
				$template_config[$i]['styleBimg'] = $style_url.$file."/demo.jpg";   //风格展示图
				$template_config[$i]['checkbuy'] = $checkbuy;
				$template_config[$i]['file'] = $file;
				$template_config[$i]['thismoney'] = $thismoney;			
				$i++; 
			}
			
		}

		$sort_arr = array_unique($sort_arr);  //过滤重复分类
		$this->assign('sortdb',$sort_arr);
		$this->assign('template_config',$template_config);    //圈子风格
		$this->assign('id',$id);  //圈子ID
		$this->assign('types',$types);    //圈子风格类型

	    return $this->fetch();
	}
	
	
	//选择、购买风格
	public function buystyle(){
		if(!$this->user){
			return $this->err_js('登陆后才可以进行相关操作');
		}
		$data = input();
		if(!$data['stylename'] || !$data['id']){
			return $this->err_js('参数有误');
		}
		
		//需金额购买
		if($data['money']>0){
			if($this->user['rmb']<$data['money']){
				return $this->err_js('余额不足，需充值后才可购买','',2);;
			}else{
				add_rmb($this->user['uid'],-abs($data['money']),0,$about="购买".QUN."【{$data['stylename']}】风格，消耗金额");
				$map = [
				        'uid'=>$this->user['uid'],
				        'pageid'=>$data['id'],
				        'stylename'=>$data['stylename'],				        
				];
				$buy_result = Model::buySTyle($map);//购买风格记录入库
				if(!$buy_result){
					add_rmb($this->user['uid'],abs($data['money']),0,$about="购买".QUN."【{$data['stylename']}】风格失败，返还金额");
					return $this->err_js('操作失败，可尝试刷新页面后再次进行操作');;
				}
			}
		}

		//选择风格，更新内容表风格字段
		$update_content_result = Model::updateContent($data['id'],$data['stylename']);

		return $this->ok_js();
	}
	

	
	
	
	
	
	
	
	

	
}
