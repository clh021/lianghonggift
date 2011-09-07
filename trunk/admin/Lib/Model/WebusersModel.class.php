<?php
// 用户模型
class WebusersModel extends CommonModel {
	public $_validate	=	array(
		array('email','/^[0-9a-z]+@(([0-9a-z]+)[.])+[a-z]{2,3}$/','邮箱格式错误'),
		array('password','require','密码必须'),
		array('repassword','require','确认密码必须'),
		array('repassword','password','确认密码不一致',self::EXISTS_VAILIDATE,'confirm'),
		array('email','','邮箱已经存在',self::EXISTS_VAILIDATE,'unique',self::MODEL_INSERT),
		);
	public $_auto		=	array(
		array('password','pwdHash',self::MODEL_BOTH,'callback'),
		array('create_time','time',self::MODEL_INSERT,'function'),
		array('update_time','time',self::MODEL_UPDATE,'function'),
		);
	protected function pwdHash() {
		if(isset($_POST['password'])) {
			return pwdHash($_POST['password']);
		}else{
			return false;
		}
	}
}
?>