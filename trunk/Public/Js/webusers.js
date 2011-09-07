function setUserStatus(status,id){
	var keyValue;var status;
	if (id){
		keyValue = id;
	}else {
		keyValue = getSelectCheckboxValues();
	}
	if (!keyValue)
	{
		alert('请选择要设置状态的项目！');
		return false;
	}
	if (status<1 || status>5){
		status = 5;
	}
	location.href = URL+"/setstatus/status/"+status+"/id/"+keyValue;
}