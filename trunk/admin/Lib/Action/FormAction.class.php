<?php
class FormAction extends CommonAction {
	//过滤查询字段
	function _filter(&$map){
		isset($_POST['name']) && $map['title'] = array('like',"%".$_POST['name']."%");
	}
}
?>