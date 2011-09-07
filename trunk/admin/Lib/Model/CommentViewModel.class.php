<?php
class CommentViewModel extends ViewModel {
	public $viewFields = array(
		'Tplcomment'=>array('id','uid','tid','content','create_time','status','_as'=>'c'),
		'Webusers'=>array('email','_as'=>'u','_on'=>'c.uid=u.id'),
		'Tplcontent'=>array('title','_as'=>'t','_on'=>'c.tid=t.id'),
	);
}
?>