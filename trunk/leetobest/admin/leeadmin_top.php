<?php
    include_once('leesession.php');
    include_once('../include/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>趁霓虹灯未亮</title>
<script type="text/javascript" language="javascript" src="../flash/MSClass.js" charset="utf-8"></script>
<script type="text/javascript" language="javascript" src="../js/jquery.min.js" charset="GBK"></script>
<style type="text/css">
*{
	padding:0;
	margin:0;
	font: 12px "宋体";
	border-width: 0px;
}
.bigtop {
	height: 85px;
	width: 100%;
	background: url(images/top_bg.gif) repeat-x;
}
.logo {
	color:#fff;
	height:85px;
	line-height:85px;
	padding:0 0 0 20px;
	font-size:36px;
	float: left;
}
.bigtop .link {
	float: right;
	height: 85px;
	width: 55%;
}
.quicklink {
	height: 20px;
	width: 100%;
}
.quicklink  li {
	float: right;
	color: #FFFFFF;
	list-style: none;
}
.quicklink  a {
	color: #FFFFFF;
	text-decoration: none;
}
.quicklink  a:hover {
	color: #00FF00;
	text-decoration: underline;
}
.nav1ink {
	height: 65px;
	width: 100%;
}
.nav1ink li {
	float: left;
	height: 18px;
	width: 70px;
	list-style: none;
	border: 1px solid #CCCCCC;
	text-align: center;
	line-height: 18px;
	margin: 0px 0px 1px 1px;
}
.nav1ink a {
	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	text-decoration: none;
	height: 18px;
	width: 70px;
	display: block;
	line-height: 18px;
}
.nav1ink a:hover {
	color: #083463;
	background: #CCC center;
	font-size: 14px;
	font-weight: bold;
	height: 18px;
	width: 70px;
	line-height: 18px;
}
</style>
</head>

<body>
<div class="bigtop">
<h2 class="logo">假如今天，是我生命中的最后一天</h2>

<div class="link">
<div class="quicklink">
<ul>
<li>[<a href="<?php echo URL_PATH; ?>login/login.php" target="_top">退出</a>]</li>
<li>[<a href="<?php echo URL_PATH; ?>" target="_top">首页</a>]</li>
<li>[<a href="<?php echo URL_PATH; ?>admin/leeadmin_right.php" target="examples">项目总结</a>]</li>
</ul>
</div>
<div id="marquee" style="color: #FFFFFF;">只需要认真做好你要做的事情。 凡事马上行动! 爱心指数正在考核中…… 凡事马上行动! 趁霓虹灯未亮系统正在被期待…… 凡事马上行动! 目标达成中…… 凡事马上行动! 人脉扩展中…… 凡事马上行动! 身体健壮中…… 凡事马上行动! 效率提升中…… 凡事马上行动! 能力提升中…… 凡事马上行动! 知识丰富中…… 凡事马上行动! 财务充沛中…… 凡事马上行动! 资讯全面中……我每天大量的吸引着成功和财富，我可以拥有任何人间美好的事物，我是一个非常成功的人，我过着平衡式成功的人生，我很乐意接受更多的财富和更大的成就，成功致富的机会不断地被我吸引而来，成功一定是属于我的，因为我是值得的，我拥有大量的财富，我的生命充满了快乐和希望，我拥有无与伦比的自信和魅力，我的思想专注于创造成功和财富，我拥有伟大的思想，我拥有超强的行动力，我每天乐在工作，成功和财富大量的流到我身边，我好像磁铁一样大量的吸引着成功和财富，我每天都很幸运，我过着快乐幸福美满的人生，是的，我可以拥有一切，是的我可以实现任何的目标和理想，没错，成功一定是属于我的。
</div>
<div class="nav1ink">
<ul>
<?php
			$channels_set=$_SESSION['ud_status_set'];
			if(substr($channels_set,-1)==','){
				$channels_set=substr($channels_set,0,-1);
			}
			$channels_status=explode(',',$channels_set);

			@include_once '../include/cache.func.php';//加载读写缓存的方法
			$channels_array=@cache_read('channels.php',CACHE_PATH);//CACHE_PATH--在include/config.php里定义的常量
			if(empty($channels_array) && count($channels_array)<1){
				echo "<font  color='red'>请更新缓存数据并刷新</font>";
			}else{
				for($i=1;$i<=sizeof($channels_array);$i++){
					if(intval($channels_array[($i-1)]['channels_status'])==1){
						if(in_array($i,$channels_status)){
							?>
<li><a href="<?php echo URL_PATH; ?>admin/leeadmin_left.php?channel=<?php echo $channels_array[($i-1)]['channels_id'];?>" target="leftFrame"><?php echo $channels_array[($i-1)]['channels_name'];?></a></li>
							<?php
						}
					}
				}
			}
?>
</ul>
</div>
</div>

</div>

</body>
<script type="text/javascript" language="JavaScript">
new Marquee("marquee",2,1,500,22,50,0,0);
//2向左，1滚动步长，可视宽，可视高，滚动速度，停顿延迟，
</script>
</html>
