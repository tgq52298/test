<?php
namespace plugins\badwords\hook;
use app\common\controller\IndexBase;
use think\db;
class Index extends IndexBase
{

    protected $badwords;
    protected $sign;

    /**
     * 匹配非法敏感词
     * @param array $info 原始数据
     */
    public function cmsContentShow(&$info=[]){
        $module = $this->request->module();
        $open_mo = config('webdb.P__badwords')['open_mo'];
        if(strstr($open_mo,$module)){
            $this->badwordsType();
            if(!empty($this->badwords)){
                $this->sign = $this->sign . $this->sign . $this->sign;
                $bw = array_combine($this->badwords,array_fill(0,count($this->badwords),$this->sign));
                $info['content'] = strtr($info['content'], $bw);
            }
        }
    }


    public function  commentAddEnd($data=[],$id=0){
        $this->badwordsType();
        if(!empty($this->badwords)){
            $this->sign = $this->sign . $this->sign . $this->sign;
            $bw = array_combine($this->badwords,array_fill(0,count($this->badwords),$this->sign));
            $data['content'] = strtr($data['content'], $bw);
        }
        if(config('webdb.P__badwords')['commentsw']){
             Db::name('comment_content')->where('id',$id)->update(['content'=> $data['content']]);
        }
        if(plugins_config('commentplus') && config('webdb.P__badwords')['commentplus_sw']){
            Db::name('comment_plus')->where('id',$id)->update(['content'=> $data['content']]);
        }



    }

    /**
     * 论坛回复过滤
     * @param array $data
     * @param int $id
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function replyAddEnd($data=[],$id=0){
        if(config('webdb.P__badwords')['replysw']){
            $this->badwordsType();
            if(!empty($this->badwords)){
                $this->sign = $this->sign . $this->sign . $this->sign;
                $bw = array_combine($this->badwords,array_fill(0,count($this->badwords),$this->sign));
                $data['content'] = strtr($data['content'], $bw);
            }
        }
        return Db::name('bbs_reply')->where('id',$id)->update(['content'=> $data['content']]);
    }



    public function badwordsType(){
        $this->badwords = '';
        $word_type = config('webdb.P__badwords')['word_type'];
        $word_sign = config('webdb.P__badwords')['word_sign'];
        switch ($word_sign){
            case 0: $this->sign = "*";
                break;
            case 1: $this->sign = "#";
                break;
            case 2: $this->sign = "⊙";
                break;
            case 3: $this->sign = "★";
                break;
            case 4: $this->sign = "◆";
                break;
            default:$this->sign = "*";
                break;
        }
        if($word_type==0){
            $this->badwords = Badwords::$badword;
        }
        if($word_type==1){
            $rs = Db::name('badwords_kw')->where('id',1)->cache(true)->find();
            if($rs['kwords']){
                $rs['kwords'] = preg_replace('/(，)/',',',$rs['kwords']);
                $this->badwords = explode(',',$rs['kwords']);
            }
        }
        if($word_type==2){
            $array1 = Badwords::$badword;
            $rs = Db::name('badwords_kw')->where('id',1)->cache(true)->find();
            if($rs['kwords']){
                $rs['kwords'] = preg_replace('/(，)/',',',$rs['kwords']);
                $array2 = explode(',',$rs['kwords']);
            }
            $this->badwords = array_merge($array1,$array2);
        }

        return $this->badwords;
    }

}


