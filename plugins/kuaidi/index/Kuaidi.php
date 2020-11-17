<?php
namespace plugins\kuaidi\index;
use think\Db;
use app\common\controller\IndexBase;
class Kuaidi extends IndexBase{
	public function ajax(){
		if($this->request->isGet()){
			$data=$this->request->param();
			if(strstr($data['id'],"-")){
				list($bianhao,$danhao)=explode("-",$data['id']);
				$kdinfo=Db::name('kuaidi')->where('bianhao',$bianhao)->whereOr('yibai',$bianhao)->whereOr('kuaibao',$bianhao)->find();
			}else{
				$data[0]['content']="商家没有写单号，请联系商家";
				if(in_wap()){
					$template=ROOT_PATH.'plugins/kuaidi/index/wap_kuaidi.htm';
				}else{
					$template=ROOT_PATH.'plugins/kuaidi/index/kuaidi.htm';
				}
				echo $this->fetch($template,['nub'=>0,'data'=>$data]);
			}
			if($bianhao){
				$data2=[];
				$data2[0]['subtitle']="快递公司：".$kdinfo['name'];
				$data2[0]['content']="快递单号：$danhao";
				$data=cache('kuaidi'.$danhao);
				if(empty($data)){
					if(config('webdb.kuaidi_type')==1){
						$data=$this->kuaidi_cha($bianhao,$danhao);
					}elseif(config('webdb.kuaidi_type')==2){
						$data=$this->kuaidi_cha($bianhao,$danhao,1008);
					}elseif(config('webdb.kuaidi_type')==3){
						$data=$this->kdyibai($danhao,$kdinfo['yibai']);
					}else{
						$data=$this->kuaibao($danhao,$kdinfo['kuaibao']);
					}
					cache('kuaidi'.$danhao,$data,config('webdb.kuaidi_huancun'));
				}
				if(empty($data)){
					$data[0]['content']="单号错误或者等待快递公司更新 建议第二天重新查看";
				}
				$data3=array_merge($data2,$data);
			}else{
				$data[0]['content']="商家没有写单号，请联系商家";
			}
			$nub=count($data3)-1;
			if(in_wap()){
				$template=ROOT_PATH.'plugins/kuaidi/index/wap_kuaidi.htm';
			}else{
				$template=ROOT_PATH.'plugins/kuaidi/index/kuaidi.htm';
			}
			$jsona=json_encode($data3);
			echo $this->fetch($template,['nub'=>$nub,'data'=>$data3,'datajson'=>$jsona]);
		}
	}
	/**
	 * 快递鸟查询
	 * @param $bianma 快递号
	 * @param $danhao 查询码
	 * @param string $type 1002 是免费版 1008是收费版
	 * @return url响应返回的html
	 */
	function kuaidi_cha($bianma,$danhao,$type='1002'){
		$requestData="{'OrderCode':'','ShipperCode':'$bianma','LogisticCode':'$danhao'}";
		$datas=[
			'EBusinessID'=>config('webdb.kuaidi_EBusinessID'),
			'RequestType'=>$type,
			'RequestData'=>urlencode($requestData),
			'DataType'   =>'2',
		];
		$datas['DataSign']=$this->kuaidi_encrypt($requestData,config('webdb.kuaidi_AppKey'));
		$result=$this->kuaidi_post('http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx',$datas);
		$map3=json_decode($result,true);
		$data=[];
		foreach($map3['Traces'] as $k=>$rs){
			$data[$k]['subtitle']=$rs['AcceptTime'];
			$data[$k]['content']=$rs['AcceptStation'];
		}
		return $data;
	}
	/**
	 * 快递100的查询
	 * @param $danhao
	 * @param $code
	 * @return array|mixed
	 */
	function kdyibai($danhao,$code){
		$params=[
			'postid'  =>$danhao,
			'id'      =>1,
			'valicode'=>'',
			'temp'    =>$this->random(),
			'type'    =>$code,
			'phone'   =>'',
			'token'   =>'',
			'platform'=>'MWWW',
			'coname'  =>'indexall',
		];
		$header=[
			'User-Agent: application/json, text/javascript, */*; q=0.01',
			'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
		];
		$ref_url='https://m.kuaidi100.com/app/query/?coname=indexall&nu='.$danhao.'&com='.$code;
		$opt=[CURLOPT_REFERER=>$ref_url];
		$data=$this->curlget('https://m.kuaidi100.com/query',$params,'POST',$header,false,false,$opt);
		$result=json_decode($data,true);
		$data=[];
		if($result['status']=='200'){
			foreach($result['data'] as $k=>$rs){
				$data[$k]['subtitle']=$rs['time'];
				$data[$k]['content']=$rs['context'];
			}
		}
		return $data;
	}
	/**
	 * 快宝查询
	 * @param $danhao
	 * @param $code
	 * @return array
	 */
	function kuaibao($danhao,$code){
		$host="https://kop.kuaidihelp.com/api";
		$headers=[];
		array_push($headers,"Content-Type".":"."application/x-www-form-urlencoded; charset=UTF-8");
		$appId=config('webdb.kuaidi_appid');
		$method='express.info.get';
		$ts=time();
		$appKey=config('webdb.kuaidi_APIkey');
		$cashu=[
			'waybill_no'      =>$danhao,
			'exp_company_code'=>$code,
			'result_sort'     =>'1',
			'phone'           =>'0936'
		];
		$bodys=[
			"app_id"=>$appId,
			"method"=>$method,
			"sign"  =>md5($appId.$method.$ts.$appKey),
			"ts"    =>$ts,
			"data"  =>json_encode($cashu)
		];
		$bodys=http_build_query($bodys);
		$url=$host;
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
		curl_setopt($curl,CURLOPT_FAILONERROR,false);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_HEADER,false);
		if(1==strpos("$".$host,"https://")){
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
		}
		curl_setopt($curl,CURLOPT_POSTFIELDS,$bodys);
		$result=json_decode(curl_exec($curl),true);
		curl_close($curl);
		$data=[];
		if($result['code']==0){
			foreach($result['data'][0]['data'] as $k=>$rs){
				$data[$k]['subtitle']=$rs['time'];
				$data[$k]['content']=$rs['context'];
			}
		}
		return $data;
	}
	/**
	 *  post提交数据
	 * @param string $url 请求Url
	 * @param array $datas 提交的数据
	 * @return url响应返回的html
	 */
	function kuaidi_post($url,$datas){
		$temps=[];
		foreach($datas as $key=>$value){
			$temps[]=sprintf('%s=%s',$key,$value);
		}
		$post_data=implode('&',$temps);
		$url_info=parse_url($url);
		if(empty($url_info['port'])){
			$url_info['port']=80;
		}
		$httpheader="POST ".$url_info['path']." HTTP/1.0\r\n";
		$httpheader.="Host:".$url_info['host']."\r\n";
		$httpheader.="Content-Type:application/x-www-form-urlencoded\r\n";
		$httpheader.="Content-Length:".strlen($post_data)."\r\n";
		$httpheader.="Connection:close\r\n\r\n";
		$httpheader.=$post_data;
		$fd=fsockopen($url_info['host'],$url_info['port']);
		fwrite($fd,$httpheader);
		$gets="";
		$headerFlag=true;
		while(!feof($fd)){
			if(($header=@fgets($fd))&&($header=="\r\n"||$header=="\n")){
				break;
			}
		}
		while(!feof($fd)){
			$gets.=fread($fd,128);
		}
		fclose($fd);
		return $gets;
	}
	/**
	 * 电商Sign签名生成
	 * @param data 内容
	 * @param appkey Appkey
	 * @return DataSign签名
	 */
	function kuaidi_encrypt($data,$appkey){
		return urlencode(base64_encode(md5($data.$appkey)));
	}
	private function random($min=0,$max=1){
		return $min+mt_rand()/mt_getrandmax()*($max-$min);
	}
	/**
	 * CURL发送HTTP请求
	 * @param string $url 请求URL
	 * @param array $params 请求参数
	 * @param string $method 请求方法GET/POST
	 * @param  $header 头信息
	 * @param  $multi  是否支付附件
	 * @param  $debug  是否输出错误
	 * @param  $optsother 附件项
	 * @return array  $data   响应数据
	 */
	function curlget($url,$params='',$method='GET',$header=[],$multi=false,$debug=false,$optsother=''){
		$opts=[
			CURLOPT_TIMEOUT       =>10,
			CURLOPT_RETURNTRANSFER=>1,
			CURLOPT_SSL_VERIFYPEER=>false,
			CURLOPT_SSL_VERIFYHOST=>false,
			CURLOPT_HTTPHEADER    =>$header
		];
		switch(strtoupper($method)){
			case 'GET':
				$opts[CURLOPT_URL]=$params?$url.'?'.http_build_query($params):$url;
				break;
			case 'POST':
				$params=$multi?$params:http_build_query($params);
				$opts[CURLOPT_URL]=$url;
				$opts[CURLOPT_POST]=1;
				$opts[CURLOPT_POSTFIELDS]=$params;
				break;
			default:
				if($debug){
					E('不支持的请求方式！');
				}
				break;
		}
		$ch=curl_init();
		if($optsother&&is_array($optsother)){
			$opts=$opts+$optsother;
		}
		curl_setopt_array($ch,$opts);
		$data=curl_exec($ch);
		$error=curl_error($ch);
		curl_close($ch);
		if($error&&$debug){
			E('请求发生错误:'.$error);
		}
		return $data;
	}
}