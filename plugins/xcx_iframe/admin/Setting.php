<?php
namespace plugins\xcx_iframe\admin;

use app\common\controller\admin\Setting AS _Setting;
use app\common\traits\AddEditList;
use app\common\util\Zip;

class Setting extends _Setting
{    
    use AddEditList;
    
    protected $tab_ext;
    protected $xcx_path;
    protected $php_zip;
    
    public function _initialize(){
        parent::_initialize();
        $this->path = PLUGINS_PATH.'xcx_iframe/xiaochengxu_app/';
    }
    
    /**
     * 参数设置
     * {@inheritDoc}
     * @see \app\common\controller\admin\Setting::index()
     */
    public function index($group=null){
        return parent::index($group);
    }
    
    public function down(){        
        if ($this->request->isPost()) {
            return $this->start_down();
        }
        return $this->fetch();
    }
    
    private function start_down(){
        $this->php_zip = new Zip;
        $tempzip = RUNTIME_PATH."xiaochengxu.zip";      //临时文件
        
        if($this->php_zip->run($tempzip,PLUGINS_PATH.'xcx_iframe/','xiaochengxu_app')){
            //ob_end_clean();
            header('Last-Modified: '.gmdate('D, d M Y H:i:s',time()).' GMT');
            header('Pragma: no-cache');
            header('Content-Encoding: none');
            header('Content-Disposition: attachment; filename='.basename($tempzip));
            header('Content-type: .zip');
            header('Content-Length: '.filesize($tempzip));
            readfile($tempzip);
            unlink($tempzip);
            exit;
        }else{
            $this->error('打包失败') ;
        }
    }
    
    public function xcxset(){
        $this->tab_ext['page_title'] = QUN.'商家小程序配置';

        if (!is_dir($this->path)) {
            $this->error('小程序目录不存在'.$this->path);
        }
        $app_json = $this->get_json('app.json');
        $project_json = $this->get_json('project.config.json');
        $config_url = $this->get_url();
        
        if ($this->request->isPost()) {
            
            $data = $this->request->post();
            $app_json['window']['navigationBarTitleText'] = $data['title'];
            $str = str_replace('\\/', '/', json_encode($app_json,JSON_UNESCAPED_UNICODE));
            write_file($this->path.'app.json', $str);
            
            $project_json['appid'] = $data['appid'];
            $project_json['projectname'] = urlencode($data['title']);
            $str = json_encode($project_json,JSON_UNESCAPED_UNICODE);
            write_file($this->path.'project.config.json', $str);
            
            if (strstr($data['url'],'/qun/')) {
                preg_match('/[\d]+/', $data['url'],$array);
                $data['url'] .= strstr($data['url'],'?') ? '&' : '?';
                $data['url'] .= 'my_qid='.$array[0];    //方便做COOKIE设置全站统一用商家的底部菜单
            }
            
            $str = "export default {basePath: '/', domain: '".$data['url']."', }";
            write_file($this->path.'config.js', $str);
            
            if(preg_match('/^uploads/', $data['picurl'])){
                copy(PUBLIC_PATH.$data['picurl'],PLUGINS_PATH.'xcx_iframe/xiaochengxu_app/assets/images/start.png');
                unlink(PUBLIC_PATH.$data['picurl']);
            }
            
            $this->success('数据更新成功','down');
        }

        $domain = $this->request->domain();
        if (!strstr($config_url,$domain)) {
            $config_url = $domain;
        }
        
        $picurl = get_url('/plugins/xcx_iframe/xiaochengxu_app/assets/images/start.png');
        $this->form_items = [
                ['text', 'title','小程序名称','',$app_json['window']['navigationBarTitleText']],
                ['text', 'appid' ,'小程序AppId','',$project_json['appid']],
                ['text', 'url', QUN.'商家网址','',$config_url],
                ['image', 'picurl', '封面广告图','用户刚刚进入时的欢迎界面图',$picurl],
        ];
        
        return $this->editContent([]);
    }
    
    private function get_json($type=''){
        return  json_decode(read_file($this->path.$type),true);
    }
    
    private function get_url(){
        $str = read_file($this->path.'config.js');
        preg_match("/domain:([ ]*)'([^']+)'/", $str,$array);
        return $array[2];
    }
}

