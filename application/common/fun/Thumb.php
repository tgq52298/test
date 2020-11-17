<?php
namespace app\common\fun;

/*缩略图*/
class Thumb{
	function TT($src='',$width=0,$height=0){
		return request()->domain().'/_tim.php?src='.urlencode($src).'&w='.$width.'&h='.$height;
	}
}