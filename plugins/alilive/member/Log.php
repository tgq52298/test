<?php
namespace plugins\alilive\member;

use app\common\controller\MemberBase;
use app\common\traits\AddEditList;
use plugins\alilive\model\Viewlog AS Model;
use plugins\alilive\model\Order AS OrderModel;

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
    
    /**
     * 购买直播流量
     * @param number $aid 指定圈子ID
     * @return mixed|string
     */
    public function add($aid=0){
        if ($this->webdb['live_free_group'] && in_array($this->user['groupid'], $this->webdb['live_free_group'])) {
            $this->error('你所在用户组不需要购买,可以免费使用!');
        }elseif($this->webdb['live_time_money']<1){
            $this->error('系统还没有设置流量单价!');
        }
        if($this->request->isPost()){
            $data = $this->request->post();
            if ($data['money']<1) {
                $this->error('金额不能小于1元');
            }elseif (empty($data['aid'])) {
                $this->error('你必须指定一个'.QUN);
            }elseif ($data['money']>$this->user['rmb']) {
                $this->error('你要充值的金额为 '.$data['money'].' 元，但你的帐户可用余额为 '.$this->user['rmb'].' 元',null,[
                    'havemoney'=>$this->user['rmb'],
                ]);
            }
            $timelong = $data['money']*$this->webdb['live_time_money']*60;
            $array = [
                'uid'=>$this->user['uid'],
                'timelong'=>$timelong,
                'aid'=>$data['aid'],
            ];
            $reslt = OrderModel::create($array);
            if ($reslt) {
                add_rmb($this->user['uid'],-$data['money'],'','购买直播流量');
                $this->success('购买成功',purl('buylog'),[
                    'time'=>$timelong,
                ]);
            }else{
                $this->success('购买失败');
            }
        }
        
        $array = fun('qun@getByuid',$this->user['uid']);
        if (empty($array)) {
            $this->error('你还没创建'.QUN);
        }
        $qun_array = [];
        foreach($array AS $rs){
            $qun_array[$rs['id']] = $rs['title'];
        }
        $this->tab_ext['page_title'] = '购买直播流量，单价是'.$this->webdb['live_time_money'].'分钟时长/每元';
        $this->form_items = [
            ['number', 'money', '支付金额(元)', '单价是'.$this->webdb['live_time_money'].'分钟/每元'],
            ['select','aid','指定'.QUN.'使用','若有多个'.QUN.'不能共享',$qun_array,$aid],
        ];
        return $this->addContent();
    }
    
    /**
     * 我购买的流量
     * @return mixed|string
     */
    public function buylog(){
        $this->list_items = [
            ['create_time','购买时间','datetime'],
            ['timelong','流量时长(分钟)','callback',function($k){
                return floor($k/60).'分';
            }],
            ['usetime','已用时长','callback',function($k){
                return floor($k/60).'分'.($k%60).'秒';
            }],
            ['aid','所属圈子','callback',function($k){
                return fun('qun@getByid',$k)['title'];
            }],
        ];
        $this->tab_ext['top_button'] = [
            [
                'type'=>'add',
                'title'=>'购买直播流量',
            ],
            [
                'url'=>purl('buylog'),
                'title'=>'已购买的流量',
                'icon'=>'fa fa-tasks',
            ],
            [
                'url'=>purl('index'),
                'title'=>'流量使用日志',
                'icon'=>'glyphicon glyphicon-stats',
            ],
        ];
        $this->tab_ext['right_button'] = [];
        $data_list= OrderModel::where('uid',$this->user['uid'])->order("id desc")->paginate(15);
        $this->tab_ext['page_title'] = '我购买的流量';
        return $this->getMemberTable($data_list);
    }
    
    /**
     * 流量使用日志
     * @return mixed|string
     */
    public function index(){
        $this->list_items = [
            ['create_time','离开时间','datetime'],
            ['uid','用户','username'],
            ['ip','ip来源','text'],
            ['view_time','收看时长(分钟)','callback',function($k){
                return floor($k/60).'分'.($k%60).'秒';
            }],
        ];
        $this->tab_ext['top_button'] = [
            [
                'type'=>'add',
                'title'=>'购买直播流量',
            ],
            [
                'url'=>purl('buylog'),
                'title'=>'已购买的流量',
                'icon'=>'fa fa-tasks',
            ],
            [
                'url'=>purl('index'),
                'title'=>'流量使用日志',
                'icon'=>'glyphicon glyphicon-stats',
            ],
        ];
        $this->tab_ext['right_button'] = [];
        
        $array = fun('qun@getByuid',$this->user['uid']);
        if (empty($array)) {
            $this->error('你还没创建'.QUN);
        }
        $qun_array = [];
        foreach($array AS $rs){
            $qun_array[] = $rs['id'];
        }
        
        $data_list= $this->model->where('aid','in',$qun_array)->order("id desc")->paginate(15);
        $this->tab_ext['page_title'] = '流量使用日志';
        return $this->getMemberTable($data_list);
    }
    

}
