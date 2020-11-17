<?php
namespace app\qun\member;

use app\common\controller\MemberBase;
use app\common\traits\AddEditList;
use plugins\alilive\model\Viewlog AS Model;
use app\qun\model\Order AS OrderModel;
use app\qun\model\Content AS ContentModel;

class Log extends MemberBase
{
    use AddEditList;
    protected $validate = '';
    protected $model;
    protected $form_items;
    protected $tab_ext;
    
    protected function _initialize()
    {
        parent::_initialize();
        $this->model = new Model();
    }
    
    public function choose($aid=0){
        if($this->request->isPost()){
            $info = ContentModel::getInfoByid($aid);
            if (empty($info)) {
                $this->error(QUN.'不存在');
            }
            $this->success('请选择时长',urls('add',['aid'=>$aid]));
        }
        $this->tab_ext['page_title'] = '请输入'.QUN.'ID';
        $this->form_items = [
            ['number', 'aid', QUN.'ID', ''],
        ];
        return $this->addContent();
    }
    
    /**
     * 购买课堂时长
     * @param number $aid 指定圈子ID
     * @return mixed|string
     */
    public function add($aid=0){
        if (empty($aid)) {
            $this->error('请先选择一个'.QUN,urls('choose'),[],0);
        }
        $info = ContentModel::getInfoByid($aid);
        if($info['minute_money']<0.0001){
            $this->error('系统还没有设置课堂时长单价!');
        }
        if($this->request->isPost()){
            $data = $this->request->post();
            if ($data['moneytime']<1) {
                $this->error('购买时长不能小于1分钟');
            }
            $data['money'] = $data['moneytime']*$info['minute_money'];
            if ($data['money']>$this->user['rmb']) {
                $this->error('你当前购买时长总共需要 '.$data['money'].' 元，不能大于你的可用余额 '.$this->user['rmb'].' 元');
            }
            $timelong = $data['moneytime']*60; //转为单位秒
            $array = [
                'uid'=>$this->user['uid'],
                'timelong'=>$timelong,
                'aid'=>$aid,
            ];
            $reslt = OrderModel::create($array);
            if ($reslt) {
                if ($data['money']<0.01) {
                    $data['money'] = 0.01;
                }
                add_rmb($this->user['uid'],-$data['money'],'','购买课堂时长');
                add_rmb($info['uid'],$data['money'],'',$this->user['username'].' 购买直播课堂时长');
                $this->success('购买成功',urls('buylog'));
            }else{
                $this->success('购买失败');
            }
        }
        
        $this->tab_ext['page_title'] = '购买课堂时长，单价是'.$this->webdb['live_time_money'].'元/每分钟时长';
        $this->form_items = [
            ['number', 'moneytime', '购买时长(分钟)', '单价是'.$info['minute_money'].'元/每分钟'],
        ];
        return $this->addContent();
    }
    
    /**
     * 我购买的时长
     * @return mixed|string
     */
    public function buylog(){
        $this->list_items = [
            ['create_time','购买时间','datetime'],
            ['timelong','时长(分钟)','callback',function($k){
                return floor($k/60).'分';
            }],
            ['usetime','已用时长','callback',function($k){
                return floor($k/60).'分'.($k%60).'秒';
            }],
            ['aid','所属'.QUN,'callback',function($k){
                return fun('qun@getByid',$k)['title'];
            }],
        ];
        $this->tab_ext['top_button'] = [
            [
                'type'=>'add',
                'title'=>'购买课堂时长',
            ],
            [
                'url'=>url('buylog'),
                'title'=>'已购买的课堂时长',
                'icon'=>'fa fa-tasks',
            ],
            [
                'url'=>url('index'),
                'title'=>'课堂时长使用日志',
                'icon'=>'glyphicon glyphicon-stats',
            ],
        ];
        $this->tab_ext['right_button'] = [];
        $data_list= OrderModel::where('uid',$this->user['uid'])->order("id desc")->paginate(15);
        $this->tab_ext['page_title'] = '我购买的课堂时长';
        return $this->getMemberTable($data_list);
    }
    
    /**
     * 我的观看日志
     * @return mixed|string
     */
    public function index(){
        $this->list_items = [
            ['create_time','离开时间','datetime'],
            ['aid','所属'.QUN,'callback',function($id){
                $info = ContentModel::getInfoByid($id);
                return $info['title'];
            }],
            ['view_time','观看时长(分钟)','callback',function($k){
                return floor($k/60).'分'.($k%60).'秒';
            }],
        ];
        $this->tab_ext['top_button'] = [
            [
                'type'=>'add',
                'title'=>'购买课堂时长',
            ],
            [
                'url'=>url('buylog'),
                'title'=>'已购买的课堂时长',
                'icon'=>'fa fa-tasks',
            ],
            [
                'url'=>url('index'),
                'title'=>'课堂时长使用日志',
                'icon'=>'glyphicon glyphicon-stats',
            ],
        ];
        $this->tab_ext['right_button'] = [];
        
        
        $data_list= $this->model->where('uid',$this->user['uid'])->order("id desc")->paginate(20);
        $this->tab_ext['page_title'] = '我的课堂时长观看日志';
        return $this->getMemberTable($data_list);
    }

}
