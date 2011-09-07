<?php
class WebusersViewModel extends ViewModel {
	public $viewFields = array(
		'Webusers'=>array('id','email','nickname','icon','last_login_time','last_login_ip','login_count','create_time','update_time','status','level','integral','_as'=>'u'),
		'Webusers_dtl'=>array('remark','info','home','town','sex','qq','contryid','realname','address','telphoto','telfax','mobile','alipay_id','alipay_name','friend_cnt','_on'=>'u.id=d.uid','_as'=>'d'),
	);
}
?>