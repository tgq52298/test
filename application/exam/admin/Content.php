<?php
namespace app\exam\admin;

use app\common\controller\admin\C;
use app\exam\traits\Content AS TraitsContent;

//题库
class Content extends C
{
    use TraitsContent;
    
    protected function deleteOne($id=0,$mid=0){
        hook_listen('exam_delete_begin',$id);
        $result = parent::deleteOne($id,$mid);
        if($result){
            hook_listen('exam_delete_end',$id);
        }
        return $result;
    }
    
    public function index($fid=0,$mid=0,$type='')
    {
        if($type=='listall'){   //放在这里的话,就省去再单独的设置后台权限
            return $this->listall();
        }
        if(!$mid && !$fid){
            return $this->listall();
        }elseif($fid){
            $mid = $this->model->getMidByFid($fid);
        }
        $this->mid = $mid;
        
        $this->tab_ext = [
                'nav'=>[ $this->nav() , $mid],
                'page_title'=>'试题管理',
                'top_button'=>[
                        [
                                'title' => '添加新试题',
                                'icon'  => 'fa fa-plus',
                                'class' => '',
                                'href'  => auto_url('add',$fid?['fid'=>$fid]:['mid'=>$mid])
                        ],
                        [
                                'type'       => 'delete',
                        ],
                        [
                                'title'       => '添加到试卷',
                                'icon'        => 'fa fa-indent',
                                'class'       => 'ajax-post confirm',
                                'target-form' => 'ids',
                                'href'        => auto_url('info/add')
                        ],
                ],
                'search'=>[
                        'uid'=>'录入者UID',
                        'title'=>'试题名称',
                ],
                'filter_search'=>[
                        'grade'=>fun('exam@get_sort','grade'),
                        'kemu'=>fun('exam@get_sort','kemu'),
                        'step'=>fun('exam@get_sort','step'),
                ],
        ];
        
        $array =  [
                //['fid', '所属栏目', 'select',$this->s_model->getTitleList()],
                //['mid', '所属题型', 'select2',$this->m_model->getTitleList()],
                ['uid', '录入者', 'callback',function($value){
                    $array = get_user($value);
                    return $array['username'];
                }],
                ['grade', '所属年级', 'checkbox',fun('exam@get_sort','grade')],
                ['kemu', '所属科目', 'checkbox',fun('exam@get_sort','kemu')],
                ['step', '所属章节', 'checkbox',fun('exam@get_sort','step')],
                //['create_time', '录入日期', 'datetime'],
                //['view', '浏览量', 'text.edit'],
                ['list', '排序值', 'text.edit'],
                ['status', '状态', 'select',[0=>'待审',1=>'正常',2=>'推荐',-1=>'回收站']],
          ];
                
          //列表显示哪些字段
          $this->list_items = array_merge(
                        $this->getEasyIndexItems(),  //列表要显示的自定义字段
                        $array
                        );
                
        $data = self::getListData($fid ? ['fid'=>$fid] : ['mid'=>$mid]);
        return $this->getAdminTable($data);
    }
    
    public function listall()
    {
        if (empty(table_field('exam_content1','difficult'))) {
            into_sql("ALTER TABLE  `qb_exam_content1` ADD  `difficult` TINYINT( 1 ) NOT NULL COMMENT  '试题难度';
ALTER TABLE  `qb_exam_content2` ADD  `difficult` TINYINT( 1 ) NOT NULL COMMENT  '试题难度';
ALTER TABLE  `qb_exam_content3` ADD  `difficult` TINYINT( 1 ) NOT NULL COMMENT  '试题难度';
ALTER TABLE   `qb_exam_content1` ADD INDEX (  `difficult` );
ALTER TABLE   `qb_exam_content2` ADD INDEX (  `difficult` );
ALTER TABLE   `qb_exam_content3` ADD INDEX (  `difficult` );",true,1);
        }
        $this->tab_ext = [
                'nav'=>[ $this->nav() , 0],
                'page_title'=>'题库管理',
                'top_button'=>[
                        [
                                'title' => '添加试题',
                                'icon'  => 'fa fa-plus',
                                'class' => '',
                                'href'  => auto_url('postnew')
                        ],
                        [
                                'type'       => 'delete',
                        ],
                        [
                                'title'       => '添加到试卷',
                                'icon'        => 'fa fa-indent',
                                'class'       => 'ajax-post confirm',
                                'target-form' => 'ids',
                                'href'        => auto_url('info/add')
                        ],
                ],
        ];
        
        
        //列表显示哪些字段
        $this->list_items =  [
                ['title', '标题', 'link',iurl('content/show',['id'=>'__id__']),'_blank'],
                ['mid', '所属题型', 'select2',$this->m_model->getTitleList()],
                ['uid', '录入者', 'callback',function($value){
                    $array = get_user($value);
                    return $array['username'];
                }],
                //['create_time', '录入日期', 'datetime'],
                ['list', '排序值', 'text.edit'],
                ['status', '状态', 'select',[0=>'待审',1=>'正常',2=>'推荐',-1=>'回收站']],
        ];
        
        $data = $this->model->getAll();

        return $this->getAdminTable($data);
    }
}
