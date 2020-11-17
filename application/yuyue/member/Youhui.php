<?php
namespace app\yuyue\member;

use app\common\controller\MemberBase;
use app\common\traits\AddEditList;
use app\yuyue\model\Youhui AS YouhuiModel;
use app\yuyue\model\Yhlog AS YhlogModel;
use app\yuyue\model\Content AS ContentModel;
use app\yuyue\model\Fx AS FxModel;


/**
 * 用户创建的优惠券
 *
 */
class Youhui extends MemberBase
{
    use AddEditList;
    protected $validate = '';
    protected $model;
    protected $form_items;
    protected $list_items;
    protected $tab_ext;
    
    protected function _initialize()
    {
        parent::_initialize();
        $this->model = new YouhuiModel();
    }
    
    /**
     * 分销者自由创建优惠券
     * @param number $aid
     * @return mixed|string
     */
    public function add($aid=0){
        $this->tab_ext['page_title'] = "创建优惠券";
        $topic_info = ContentModel::getInfoByid($aid);
        $total = $topic_info['price']>0 ? $topic_info['price'] : get_total_money($topic_info);
        if($total<0.01){
            $this->error('内容售价为0，不能创建优惠券');
        }elseif($topic_info['fx1']<0.01){
            $this->error('没有设置分销比例');
        }
        $money = $topic_info['fx1'];//number_format($topic_info['fx1'] * $total,2);
        
        if ($this->request->isPost()) {            
            $data = $this->request->post();
            
            $end_time = $data['end_time']?strtotime($data['end_time']):0;
            $this->request->post(['end_time'=>$end_time]);
            
            if($data['money']>$money){
                $this->error('面值不能大于你的分销金额');
            }elseif($data['money']<0.01){
                $this->error('面值不能小于0.01元');
            }elseif($data['max_num']<1){
                $this->error('数量不能小于1');
            }elseif($end_time<time()){
                $this->error('效截止日期必须大于当前日期');
            }
        }
        
        $this->form_items = [
            ['hidden', 'aid',$aid],
            ['money', 'money', '面值（元）','面值不能大于你的分销金额：'.$money.'元'],
            ['number', 'max_num', '数量（份）'],
            ['datetime', 'end_time', '有效截止日期'],
        ];
        return $this->addContent();
    }
    
    /**
     * 修改优惠券
     * @param number $id
     * @return mixed|string
     */
    public function edit($id=0){
        $map = [
            'id'=>$id,
            'uid'=>$this->user['uid'],
        ];
        $info = getArray($this->model->where($map)->find());
        
        $topic_info = ContentModel::getInfoByid($info['aid']);
        $total = $topic_info['price']>0 ? $topic_info['price'] : get_total_money($topic_info);
        if($total<0.01){
            $this->error('内容售价为0，不能创建优惠券');
        }elseif($topic_info['fx1']<0.01){
            $this->error('没有设置分销比例');
        }
        $money = $topic_info['fx1'];//number_format($topic_info['fx1'] * $total,2);
        
        if ($this->request->isPost()) {
            $data = $this->request->post();
            
            $end_time = $data['end_time']?strtotime($data['end_time']):0;
            $this->request->post(['end_time'=>$end_time]);
            
            if($data['money']>$money){
                $this->error('面值不能大于你的分销金额');
            }elseif($data['money']<0.01){
                $this->error('面值不能小于0.01元');
            }elseif($data['max_num']<1){
                $this->error('数量不能小于1');
            }elseif($end_time<time()){
                $this->error('效截止日期必须大于当前日期');
            }
        }
        
        
        $this->form_items = [
            ['money', 'money', '面值（元）','面值不能大于你的分销金额：'.$money.'元'],
            ['number', 'max_num', '数量（份）'],
            ['datetime', 'end_time', '有效截止日期'],
        ];
        return $this->editContent($info);
    }
    
    /**
     * 分享优惠券
     * @param number $id
     * @return mixed|string
     */
    public function share($id=0){
        $info = getArray($this->model->where('id',$id)->find());
        $topic = ContentModel::getInfoByid($info['aid']);
        $info['end_time'] = $info['end_time']?date('Y-m-d H:i',$info['end_time']):'长期有效';
        $share_url = get_url(urls('get',['id'=>$id])).'?p_uid='.$this->user['uid'];
        $this->assign('share_url',$share_url);
        $this->assign('info',$info);
        $this->assign('topic',$topic);
        $this->assign('id',$id);
        $codeimg = get_qrcode($share_url);
        $this->assign('codeimg',$codeimg);
        return $this->fetch();
    }
    
    public function get($id=0){
        $info = getArray($this->model->where('id',$id)->find());
        
        $url = iurl('content/show',['id'=>$info['aid']]);
        if (empty($info)) {
            $this->error('优惠券不存在',$url,[],5);
        }
        
        $total = YhlogModel::where('yid',$id)->count('id');
        $result = YhlogModel::where('uid',$this->user['uid'])->where('yid',$id)->find();
        
        if($result){
            $this->error('你已经领取过了',$url.'?yid='.$result['id'],[],1);
        }
        
        if($info['end_time']&&$info['end_time']<time()){
            $this->error('该优惠券已经过期了，不能再领取',$url,[],5);
        }elseif($info['max_num']<$total){
            $this->error('该优惠券已经被领取完了！',$url,[],5);
        }
        
        $data = [
            'uid'=>$this->user['uid'],
            'aid'=>$info['aid'],
            'yid'=>$info['id'],
            'money'=>$info['money'],
            'end_time'=>$info['end_time'],
        ];
        $result = YhlogModel::create($data);
        if ($result) {
            $array = [
                'aid'=>$info['aid'],
                'sid'=>-1,
                'uid'=>$this->user['uid'],
                'introducer_1'=>$info['uid'],
            ];
            FxModel::create($array);
            $this->success('领取成功',$url.'?yid='.$result->id,[],0);
        }else{
            $this->error('数据库操作失败',$url,[],5);
        }
        
    }
    
    /**
     * 分享者创建的所有优惠券
     * @return mixed|string
     */
    public function index() {
        $map = [
            'uid'=>$this->user['uid']
        ];
        $this->list_items = [
            ['aid','分销内容','callback',function($id,$rs){
                $info = ContentModel::getInfoByid($id);
                return "<a href='".iurl('content/show',['id'=>$info['id']])."' target='_blank'>{$info['title']}</a>";
            }],
            ['money','面值','text'],
            ['max_num','总数','text'],
            ['id','已领取','callback',function($id,$rs){
                $num = YhlogModel::where('yid',$id)->count('id');
                if ($num) {
                    return "（{$num}） <a href='".urls('yhlog/index',['yid'=>$id])."'>详情</a>";
                }else{
                    return $num;
                }
            }],            
            ['end_time','有效截止日期','datetime'],
            ['id','分享','callback',function($id,$rs){
                return "<a href='".urls('share',['id'=>$id])."' class='fa fa-mail-forward'></a>";
            }],
        ];
        $this->tab_ext['page_title'] = '我创建的优惠券';
        $this->tab_ext['top_button'] = [];
        //$this->tab_ext['right_button'] = [];
        return $this -> getMemberTable(self::getListData($map, $order='id desc' ));
    }
}