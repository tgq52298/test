<?php
namespace plugins\qiniu\index;
use app\admin\model\Attachment as AttachmentModel;
require ROOT_PATH.'plugins/qiniu/SDK/autoload.php';
use think\Db;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
class Qiniu{
	public function uploadDriver($file='',$params=[]){
		$upload_driver=Db::name('config')->where(['c_key'=>'upload_driver'])->value('c_value');
		if($upload_driver=='qiniu'){
			$error_msg='';
			if(config('webdb.P__qiniu')['ak']==''){
				return $this->errFile($params['from'],'未填写参数');
			}
			 
			$config['domain']=rtrim(config('webdb.P__qiniu')['ak'],'/').'/';
			if(!empty($params['type'])){
			 $file_info=$file;
			}else{
			$file_info=$file->getInfo();
			}
			$file_name=explode('.',$file_info['name']);
			$ext=end($file_name);
			$key=hash_file('md5',$file_info['tmp_name']).'.'.$ext;
			// 需要填写你的 Access Key 和 Secret Key
			$accessKey=config('webdb.P__qiniu')['ak'];
			$secretKey=config('webdb.P__qiniu')['sk'];
			// 构建鉴权对象
			$auth=new Auth($accessKey,$secretKey);
			// 要上传的空间
			$bucket=config('webdb.P__qiniu')['bucket'];
			// 生成上传 Token
			$token=$auth->uploadToken($bucket,$key);
			// 初始化 UploadManager 对象并进行文件的上传
			$uploadMgr=new UploadManager();
			// 调用 UploadManager 的 putFile 方法进行文件的上传
			list($ret,$err)=$uploadMgr->putFile($token,$key,$file_info['tmp_name']);
			if($err!==null){
				return $this->errFile($params['from'],'上传失败');
			}else{
				$file_info=[
					'uid'=>intval(login_user('uid')),
					'name'=>$file_info['name'],
					'mime'=>$file_info['type'],
					'path'=>config('webdb.P__qiniu')['domain'].$key,
					'url'=>config('webdb.P__qiniu')['domain'].$key,
					'ext'=>$ext,
					'size'=>$file_info['size'],
					'md5'=>hash_file('md5',$file_info['tmp_name']),
					'sha1'=>hash_file('sha1',$file_info['tmp_name']),
					'driver'=>'qiniu',
					'module'=>$params['module']
				];
				if(($file_add=AttachmentModel::create($file_info))!=false){
					 return $this->succeFile($params['from'],$file_info['path'],$file_info);
				}else{
					return $this->errFile($params['from'],'上传失败');
				}
			}
		}
	}
protected function ck_js($callback = '', $file_path = '', $error_msg = ''){
        return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callback, '$file_path' , '$error_msg');</script>";
    }
    
    protected function errFile($from='',$error_msg=''){        
        switch ($from) {
            case 'wangeditor':
                return "error|{$error_msg}";
                break;
            case 'ueditor':
                return json(['state' => $error_msg]);
                break;
            case 'editormd':
                return json(["success" => 0, "message" => $error_msg]);
                break;
            case 'ckeditor':
                $callback = $this->request->get('CKEditorFuncNum');
                return $this->ck_js($callback, '', $error_msg);
                break;
            default:
                return json([
                'code'   => 0,
                'class'  => 'danger',
                'info'   => $error_msg
                ]);
        }
    }
    
    protected function succeFile($from,$file_path,$file_info){
        switch ($from) {
            case 'wangeditor':
                return $file_path;
                break;
            case 'ueditor':
                return json([
                "state" => "SUCCESS",          // 上传状态，上传成功时必须返回"SUCCESS"
                "url"   => $file_path, // 返回的地址
                "title" => $file_info['name'], // 附件名
                ]);
                break;
            case 'editormd':
                return json([
                "success" => 1,
                "message" => '上传成功',
                "url"     => $file_path,
                ]);
                break;
            case 'ckeditor':
                $callback = $this->request->get('CKEditorFuncNum');
                return $this->ck_js($callback, $file_path);
                break;
            default:
                return json([
                'code'   => 1,
                'info'   => '上传成功',
                'class'  => 'success',
                'id'     => $file_info['path'],
                'url'     => $file_info['url'],
                'path'   => $file_path
                ]);
        }
    }
}