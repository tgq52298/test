<?php

namespace plugins\wnsms;

class Api{
    /**
     * 发送短信
     * @param unknown $mob 手机号
     * @param unknown $content 短信内容
     */
    public function send($mob,$content){
        $webdb = config('webdb.P__wnsms');
        if (empty($webdb['wnsms_url']) || $webdb['wnsms_okcode']==='') {
            return '请先配置好短信接口参数';
        }
        $url = str_replace(['$mob','$content'],[$mob,$content],$webdb['wnsms_url']);
        
        $code = file_get_contents($url);
        if ($code=='') {
            $code = http_curl($url);
        }
        
        if(strstr($code,trim($webdb['wnsms_okcode'])) || trim($code)===trim($webdb['wnsms_okcode'])){
            return true;
        }else{
            return $code;
        }
    }
}