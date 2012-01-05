<?php
    include_once('leesession.php');
    include_once('../include/config.php');
	include_once '../include/cache.func.php';//加载读写缓存的方法
	$left_modules_channel=0;//设定本页面所属频道的ID号码，也可以通过程序查找频道英文名称是leehom的频道，获取ID
	 $left_channel=@$_REQUEST['channel'];
	 $left_channel=@trim($left_channel);
	 if(!empty($left_channel)){
		 if($left_channel<=0){
			 echo "<script>alert('获取的频道不对');window.history.back();</script>";
		     exit;
		 }else{
			 $left_modules_channel=intval($left_channel);
		 }
	 }
	$channels_array=@cache_read('channels.php',CACHE_PATH);//CACHE_PATH--在include/config.php里定义的常量
	for($i=1;$i<count($channels_array);$i++){
		if($channels_array[($i-1)]['channels_status']!=1){
			if($left_modules_channel==$i){
				echo "<script>alert('该频道已被关闭。');window.history.back();</script>";
				exit;
			}
		}
	}

	$modules_id_set=$_SESSION['modules_id_set'];//获取session允许的模块
    if(substr($modules_id_set,-1)==','){
	   $modules_id_set=substr($modules_id_set,0,strlen($modules_id_set)-1);
    }
    $modules_id_sets=explode(',',$modules_id_set);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="JavaScript" src="../js/jquery.min.js" ></script>
<title>趁霓虹灯未亮管理后台--树形菜单</title>
<style type="text/css">
body{
	scrollbar-base-color:#2563AC;
	scrollbar-arrow-color:#FFFFFF;
	scrollbar-shadow-color:#c1ea8b;
	background:url(images/user_all_bg.gif) repeat-x; width:98%;height:120px;
	background-color:#2563AC;
}
	*{padding:0; margin:0;}
</style>
<script type="text/javascript">
	var Item = 1;
	function showHideSidebar(Item){
		var obj=document.getElementById("sidebar"+Item);
		obj.style.display = obj.style.display == "none" ? "" : "none"; 
		var obj1=document.getElementById("explode"+Item);
		obj1.className=obj.style.display == "none" ? "collapse" : "explode";
	}
	//我想用JQuery实现动态效果。
	//$("document").ready(function(){
	//	alert('jjj');
	//	function showHideSidebar(Item){
	//		$("#sidebar"+Item).click(function(){
	//			alert('213');
				//if($("#sidebar"+Item).is(":hidden")){
				//	$("#sidebar"+Item).show(800);
				//}else{
				//	$("#sidebar"+Item).show(1000);
				//}
	//		});
	//	}

		//$("#sidebar"+Item).css({display:""});
		//$("#sidebar"+Item[]).css({display:""});
			//obj.style.display=obj.style.display=="none"?"":"none";
		//var obj1=$(".explode"+Item);
		//	obj1.className=obj.style.display=="none"?"collapse":"explode";
	//});
</script>
</head>
<body>
<div class="left">
            <div><img src="images/top.gif" alt=" " /></div>
            <div id="main-div">
                <div id="menu-list">
            		<ul>
					 <li class="explode" id="explode0" ><a href="javascript:showHideSidebar(0)">个人信息管理</a>
						<ul style="margin:0; padding:0" id="sidebar0">
						  <li class="menu-item"><a href="../control/leedb_cache.php?method=structure" target="examples">更新缓存结构</a></li>
						  <li class="menu-item"><a href="../control/leedb_cache.php?method=data" target="examples">更新缓存数据</a></li>
						  <li class="menu-item"><a href="../control/my_newpwd.php" target="examples">修改密码</a></li>
						  <li class="menu-item"><a href="../control/my_info.php" target="examples">个人资料</a></li>
						</ul>
					 </li>
					   <?php
			@include_once'../include/cache.func.php';//加载读写缓存的方法
			$modules_array=@cache_read('modules.php',CACHE_PATH);//加载所有存在模块的缓存
			if(empty($modules_array) && count($modules_array)<1){
				echo "<font  color='red'>请更新缓存数据并刷新</font>";
			}else{
				foreach($modules_array as $value){
					if($value['modules_status']==1){
						$modules_channel=$value['modules_channel'];//取出此模块所属的频道集合
						if(substr($modules_channel,-1)==','){
						   $modules_channel=substr($modules_channel,0,-1);
						}
						$modules_channel=explode(',',$modules_channel);//将频道集合处理成为数组
						if(in_array($left_modules_channel,$modules_channel)){//判断频道是否包含了此模块
							 $modules_id=$value['modules_id'];
							 if(in_array($modules_id,$modules_id_sets)){
								 $modules_name=$value['modules_name'];
								 $modules_path=$value['modules_path'];
					   ?>
						<li class="collapse" id="explode<?php echo $modules_id;?>" >
						<a href="javascript:showHideSidebar(<?php echo $modules_id;?>)"><?php echo $modules_name; ?>管理</a>
							<ul style="margin:0; padding:0; display:none;" id="sidebar<?php echo $modules_id;?>">
								<li class="menu-item"><a href="list<?php echo $modules_path; ?>.php" target="examples"><?php echo $modules_name; ?>列表</a></li>
								<li class="menu-item"><a href="add<?php echo $modules_path; ?>.php" target="examples">增加<?php echo $modules_name; ?></a></li>
							</ul>
						</li>
					   <?php
							 }
						 }
					}
				}
							



			}
					   ?>
                   </ul>
                </div>
            </div>
            <div><img src="images/bottom.gif" alt=" " /></div>
        </div>
</body>
</html>

