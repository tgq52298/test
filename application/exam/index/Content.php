<?php
namespace app\exam\index;

use app\common\controller\index\C; 
use app\exam\model\Answer;

//试题库,不是试卷
class Content extends C
{
    public function index($fid=0,$mid=0){
        return parent::index($fid,$mid);
    }
    
    /**
     * 试题库的具体某一道题(并非试卷)
     * {@inheritDoc}
     * @see \app\common\controller\index\C::show()
     */
    public function show($id){
        return parent::show($id);
    }
    
    /**
     * 试题库的随机下一道题(并非试卷)
     * {@inheritDoc}
     * @see \app\common\controller\index\C::next()
     */
//     public function nextRand($id=0,$grade='',$kemu='',$step='')
//     {
//         $map = $this->get_where($grade,$kemu,$step);
//         $id = $this->model->getNextRandByid($id,'model',[],$map);
//         if (empty($id)) {
//             $this->error('已经到尽头了');
//         }
//         return $this->show($id);
//     }
    
    /**
     * 练习(非考试) 答案入库
     * @param number $id 试题ID
     * @param string $answer 考生选择的答案
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function add_answer($id=0,$answer=''){
        $info = $this->model->getInfoById($id);
        if (empty($info)) {
            return $this->err_js('试题不存在');
        }
        $data = [
                'uid'=>$this->user['uid'],
                'paperid'=>0,
                'aid'=>$id,                
        ];
        $answer_info = Answer::getInfo($data);
        $data['is_true'] = fun('exam@check_answer',$info,$answer);  //核对答案是否正确
        $data['answer'] = $answer;
        if (empty($answer_info)) {      //添加答案            
            Answer::create($data);
            if ($data['is_true']==1 && $this->webdb['each_title_dou']) {
                add_dou($this->user['uid'], $this->webdb['each_title_dou'],'答题正确');
            }
        }else{          //修改答案
            $data['id'] = $answer_info['id'];
            Answer::update($data);
            if($data['is_true']==1 && $answer_info['is_true']!=1){         //原来做错了,后来改对了,重新奖励
                add_dou($this->user['uid'], $this->webdb['each_title_dou'],'答题正确');
            }elseif($data['is_true']!=1 && $answer_info['is_true']==1){    //原来做对的奖励了金豆,后来又做错了,要扣除掉
                add_dou($this->user['uid'], -abs($this->webdb['each_title_dou']),'把答案改错');
            }   
        }
        return $this->ok_js([],$data['is_true']==1?'回答正确':'回答错误');
    }
    
    /**
     * 试题库的下一道题(并非试卷)
     * {@inheritDoc}
     * @see \app\common\controller\index\C::next()
     */
    public function next($id=0,$grade='',$kemu='',$step='',$mid=0,$myfid=0,$uid=0,$type='')
    {
        $map = $this->get_where($grade,$kemu,$step);
        $info = [];
        if (empty($id)) {
            if ($mid && model_config($mid)) {
                $info['mid'] = $mid;
            }else{
                $this->error('必须要指定一个模型!');
            }
        }
        
        
        if ($myfid) {
            $map['myfid'] = $myfid;
        }elseif ($uid) {
            $map['uid'] = $uid;
        }
        
        if($type=='rand'){  //随机显示
            $id = $this->model->getNextRandByid($id,'model',$info,$map);
        }else{
            $id = $this->model->getNextById($id,'model',$info,$map,true);
        }        
        
        if (empty($id)) {
            $this->error('已经到尽头了');
        }
        return $this->show($id);
    }
    
    /**
     * 试题库的上一道题(并非试卷)
     * {@inheritDoc}
     * @see \app\common\controller\index\C::next()
     */
    public function back($id=0,$grade='',$kemu='',$step='')
    {
        $map = $this->get_where($grade,$kemu,$step);
        $id = $this->model->getNextById($id,'model',[],$map,false);
        if (empty($id)) {
            $this->error('已经到尽头了');
        }
        return $this->show($id);
    }
    
    /**
     * 按年级 科目 章节 获取模糊查询条件
     * @param string $grade
     * @param string $kemu
     * @param string $step
     * @return string[][]
     */
    protected function get_where($grade='',$kemu='',$step=''){
        $map = [];
        if ($grade) {
            $map['grade'] = [
                    'LIKE',
                    is_numeric($grade)?"%,$grade,%":"%$grade%",
            ];
        }
        if ($kemu) {
            $map['kemu'] = [
                    'LIKE',
                    is_numeric($kemu)?"%,$kemu,%":"%$kemu%",
            ];
        }
        if ($step) {
            $map['step'] = [
                    'LIKE',
                    is_numeric($step)?"%,$step,%":"%$step%",
            ];
        }
        return $map;
    }
    
    
}
