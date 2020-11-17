<?php
namespace app\search\upgrade;

class U1{
	public function up(){
		 unlink(APP_PATH.'/search/model/Content.php');
		 
	}
}