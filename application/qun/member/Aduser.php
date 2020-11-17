<?php
namespace app\qun\member;

use app\common\controller\MemberBase;
use app\common\traits\AddEditList;
use app\qun\model\Aduser AS AduserModel;
use app\qun\model\Adset AS AdsetModel;

class Aduser extends MemberBase
{
    use AddEditList;
    protected $validate = '';
    protected $model;
    protected $form_items;
    protected $tab_ext;
    
    protected function _initialize()
    {
        parent::_initialize();
        $this->model = new AduserModel();
    }
    
    /**
     * 购买广告位
     * @param number $aid
     * @param number $ad_id
     * @return mixed|string
     */
    public function add($aid=0,$ad_id=0){
        
        $qun = fun('qun@getByid',$aid);
        if (empty($qun)) {
            $this->error(QUN.'不存在!');
        }
        
        $map = [
                'aid'=>$aid
        ];
        $info = getArray(AdsetModel::where($map)->find());
        if (empty($info)) {
            $this->error('广告位不存在!');
        }elseif ($info['status']==0){
            $this->error('当前广告位暂停出售!');
        }
        
        $listad = getArray( $this->model->where($map)->order('id','desc')->limit(1)->find() );
        
        if($this->request->isPost()){
            $data = $this->request->post();
            if ($this->user['rmb'] < $info['price']){
                $this->error('你的余额不足,请先充值!');
            }elseif(strlen($data['title'])>100){
                $this->error('广告文字太多了!');
            }
            $data['title'] = filtrate($data['title']);
            if (empty($data['url'])) {
                $qus = fun('qun@getByuid',$this->user['uid']);
                $qus && $data['url'] = iurl('content/show',['id'=>$qus[0]['id']]);
            }
            if ($listad['end_time']<time()) {
                $listad['end_time'] = time();
            }            
            $data['money'] = $info['price'];
            $data['begin_time'] = $listad['end_time'];
            $data['end_time'] = $listad['end_time']+$info['day']*3600*24;
            $data['status'] = $info['status']==1?1:0;
            $data['uid'] = $this->user['uid'];
            $data['ad_id'] = $info['id'];
            $data['create_time'] = time();
            $reuslt = $this->model->create($data);
            
            if ($reuslt) {
                if ($info['status']==1) {
                    add_rmb($this->user['uid'], -abs($info['price']), 0,'购买广告位');
                    add_rmb($qun['uid'], abs($info['price']), 0,'出售广告位');
                    $content = $title = $this->user['username'].'购买了你的广告位,收益 '.$info['price'].'元 已到帐';
                }else{
                    add_rmb($this->user['uid'], -abs($info['price']), abs($info['price']),'购买广告位');
                    $content = $title = $this->user['username'].'购买了你的广告位,请尽快去审核,才有收益';
                    $content .= ",<a href='".get_url(urls('index'))."'>点击查看详情</a>";
                }
                send_msg($qun['uid'],$title,$content);
                send_wx_msg($qun['uid'], $content);
                $this->success('购买成功',urls('listbuy'));
            }else{
                $this->error('购买失败');
            }            
        }
        
        $this->tab_ext['page_title'] = " 广告位购买，{$info['price']}元/{$info['day']}天，你当前可用余额为:".$this->user['rmb'];
        
        $this->form_items = [
                ['hidden', 'aid',$aid],
                ['text', 'title', '广告文字'],
                ['text', 'url', '广告网址','可以留空,则跳转到你的'.QUN.'主页'],
        ];
        return $this->addContent();
    }
    
    /**
     * 购买我的广告的所有客户
     * @param number $aid 圈子ID
     * @param number $ad_id
     * @return mixed|string
     */
    public function index($aid=0,$ad_id=0)
    {
        if (empty($aid)) {
            $quns = fun('qun@getByuid',$this->user['uid']);
            if (count($quns)>1) {
                $url = url('choose/index').'?url='.urlencode( url('index').'?aid=' );
                //$this->success('请选择要管理哪个'.QUN,$url);
                $this->redirect($url);
            }else{
                $aid = $quns[0]['id'];
            }
        }
        
        $this->tab_ext['right_button'] = [
                ['type'=>'delete']
        ];
        
        $this->list_items = [
                ['uid','购买者','username'],
                ['create_time','购买时间','datetime'],                
                ['money','支付金额','text'],
                ['begin_time','广告开始时间','datetime'],
                ['end_time','广告结束时间','datetime'],
                ['title','广告标题','text'],
                //['url','广告网址','text'],
                ['status','审核与否','callback',function($value,$rs){
                    if($value==1){
                        $code = '<i class="glyphicon glyphicon-ok-sign" style="color:green;font-size:18px;"></i>';
                    }else{
                        $code = '<a href="'.urls('passyz',['id'=>$rs['id']]).'" title="点击通过审核"><i class="fa fa-minus-circle" style="color:blue;font-size:23px;"></i></a>';
                    }
                    return $code;
                }],
        ];
        
        $data_list= $this->model->where('aid',$aid)->order("id desc")->paginate(15);
        $this->tab_ext['page_title'] = '购买广告的用户';
        return $this->getMemberTable($data_list);
    }
    
    /**
     * 我购买过的广告位
     * @param number $aid
     * @param number $ad_id
     * @return mixed|string
     */
    public function listbuy()
    {
        $this->list_items = [
                ['create_time','购买时间','datetime'],
                ['status','审核与否','yesno'],
                ['money','支付金额','text'],
                ['begin_time','广告开始时间','datetime'],
                ['end_time','广告结束时间','datetime'],
                ['title','广告标题','text'],
                ['url','广告网址','text'],
        ];
        
        $data_list= $this->model->where('uid',$this->user['uid'])->order("id desc")->paginate(15);
        $this->tab_ext['page_title'] = '我购买过的广告';
        $this->tab_ext['right_button'] = [
                ['type'=>'delete']
        ];
        return $this->getMemberTable($data_list);
    }
    
    /**
     * 广告通过审核
     * @param number $id
     */
    public function passyz($id=0){
        $info = $this->model->get($id);
        if (empty($info)) {
            $this->error('内容不存在');
        }
        $qun = fun('qun@getByid',$info['aid']);
        if ($qun['uid']!=$this->user['uid']) {
            $this->error('你没权限!');
        }elseif($info['status']==1){
            $this->error('已经通过审核了!');
        }
        
        $data = [
                'id'=>$id,
                'status'=>1,
        ];
        $result = $this->model->update($data);
        if ($result){
            //把展示日期提前一下显示
            $lastad = $this->model->where('id','<',$id)->order('id','desc')->limit(1)->find();
            if ($lastad['end_time']<time()) {
                $time = $info['end_time'] - $info['begin_time'];
                $data['begin_time'] = time(); //以审核通过的时间开始算广告时长
                $data['end_time'] = $data['begin_time'] + $time;
                $this->model->update($data);
            }
            add_rmb($qun['uid'], abs($info['money']), 0,'广告通过审核');
            add_rmb($info['uid'], 0, -abs($info['money']),'广告通过审核');
            
            $content = $title = $this->user['username'].' 审核通过了你的广告位';
            $content .= ",<a href='".get_url(urls('content/show',['id'=>$info['aid']]))."'>点击查看详情</a>";
            send_msg($info['uid'],$title,$content);
            send_wx_msg($info['uid'], $content);
            
            $this->success('审核成功!');
        }else{
            $this->error('审核失败!');
        }
    }
    
    /**
     * 删除某个用户购买的广告
     * @param number $ids
     */
    public function delete($ids=0){
        $info = $this->model->get($ids);
        if (empty($info)) {
            $this->error('内容不存在');
        }
        $qun = fun('qun@getByid',$info['aid']);
        if ($qun['uid']!=$this->user['uid'] && $info['uid']!=$this->user['uid']) {
            $this->error('你没权限!');
        }
        
        $result = $this->model->destroy($ids);
        if ($result) {
            if ($info['uid']!=$this->user['uid']) {     //删除他人投放的广告     
                $money = 0;
                if($info['status']==1 && $info['end_time']>time()){
                    if ($this->user['rmb']>=$info['money']) {
                        $money = $info['money'];
                    }elseif($this->user['rmb']>0){
                        $money = $this->user['rmb'];
                    }                    
                    add_rmb($this->user['uid'], -abs($money), 0,'删除他人的广告');
                    add_rmb($info['uid'], abs($money), 0,'广告被删除作补偿');
                }
                $content = $title = $this->user['username'].'删除了你购买的广告,已补偿你 '.$money.'元';
                send_msg($info['uid'],$title,$content);
                send_wx_msg($info['uid'], $content);
            }
            
            if($info['status']==0){
                add_rmb($info['uid'], abs($info['money']), -abs($info['money']),'广告被删除作补偿');
                $content = $title = $this->user['username'].'你购买的广告被删除了,已补偿你 '.$info['money'].'元';
                send_msg($info['uid'],$title,$content);
                send_wx_msg($info['uid'], $content);
            }
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}
