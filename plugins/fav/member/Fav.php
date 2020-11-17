<?php
namespace plugins\fav\member;

use app\common\controller\MemberBase;
use plugins\fav\model\Fav as FavModel;

class Fav extends MemberBase
{
    
    public function delete($id=0){
        $info = FavModel::get($id);
        if ($info['uid']!=$this->user['uid']) {
            $this->error('你无权删除他人的内容');
        }
        FavModel::destroy($id);
        $this->success('删除成功');
    }
    
    
    public function index($type=''){
        if ($type) {
            $array = modules_config($type);
            if (empty($array)) {
                $this->error('频道有误');
            }
        }
        $map = [
                'uid'=>$this->user['uid']
        ];
        $data_list = FavModel::where($map)->order("id desc")->paginate(15);
        $data_list->each(function(&$rs,$key){
            $array = FavModel::get_info($rs['aid'],$rs['sysid']);
            $rs['title'] = $array['title'];
            $rs['url'] = $array['url'];
            $rs['sort_name'] = $array['sort_name'];
            $rs['sort_url'] = $array['sort_url'];
            $rs['module_name'] = $array['module_name'];
            $rs['module_dir'] = $array['module_dir'];
            $rs['info'] = $array;
            return $rs;
        });
        
        $pages = $data_list->render();
        $listdb = getArray($data_list)['data'];
            
        //给模板赋值变量
        $this->assign('pages',$pages);
        $this->assign('listdb',$listdb);
        return $this->fetch();
    }
    

}
