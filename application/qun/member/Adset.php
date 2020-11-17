<?php
namespace app\qun\member;

use app\common\controller\MemberBase;
use app\common\traits\AddEditList;
use app\qun\model\Adset AS AdsetModel;
use app\qun\model\Content;

class Adset extends MemberBase
{
    use AddEditList;
    protected $validate = '';
    protected $model;
    protected $form_items;
    protected $tab_ext;
    
    protected function _initialize()
    {
        parent::_initialize();
        $this->model = new AdsetModel();
    }
    
    public function edit($aid=0)
    {
        if (empty($aid)) {
            $quns = fun('qun@getByuid',$this->user['uid']);
            if (count($quns)>1) {
                $url = url('choose/index').'?url='.urlencode( url('edit').'?aid=' );
                //$this->success('请选择要管理哪个'.QUN,$url);
                $this->redirect($url);
            }else{
                $aid = $quns[0]['id'];
            }
        }
        $qun = fun('qun@getByid',$aid);
        if (empty($qun)) {
            $this->error('你还没有创建'.QUN);
        }elseif($qun['uid']!=$this->user['uid']){
            $this->error('你不能设置别人的'.QUN);
        }
        
        $day_price = $this->webdb['ad_day_price']>0 ? $this->webdb['ad_day_price'] : 10; //广告每天均价不能超过这个标准
        
        $map = [
                'aid'=>$aid
        ];
        $info = getArray($this->model->where($map)->find());
        
        if($this->request->isPost()){
            $data = $this->request->post();
            if ($data['day']<1) {
                $this->error('广告时长不能小于一天!');
            }elseif($data['price']/$data['day'] > $day_price){
                $this->error('为避免扰乱报价，广告每天均价不能大于 '.$day_price.' 元!');
            }elseif($data['day'] > 31){
                $this->error('为保证商家广告投放效果，广告最长时间只能是30天!');
            }
            $data['aid'] = $aid;
            if (empty($info)) {
                $data['uid'] = $this->user['uid'];
                $reuslt = $this->model->create($data);
            }else{
                $data['id'] = $info['id'];
                $reuslt = $this->model->update($data);
            }
            Content::editData(1,['id'=>$aid,'openad'=>$data['status'],'mid'=>1]);
            if ($reuslt) {
                $this->success('设置成功',urls('content/index'));
            }else{
                $this->error('设置失败');
            }
        }
        
        $this->tab_ext['page_title'] = $qun['title'].' 广告位设置';
        
        $this->form_items = [
                ['hidden', 'aid',$aid],
                ['money', 'price', '广告价格','',5],
                ['number', 'day', '广告时长','单位是多少天',7],
                ['radio', 'status', '状态','',[0=>'停止出售广告位',-1=>'用户购买广告需要审核',1=>'用户购买广告不需审核'],1],
        ];
        return $this->editContent($info);
    }

}
