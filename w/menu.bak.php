<?php
	require_once '../include/config.php';//声明页面编码以及设置smarty基本设置
?>
<html>
<head>
<title>menu</title>
<link rel="stylesheet" href="skin/css/base.css" type="text/css" />
<link rel="stylesheet" href="skin/css/menu.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language='javascript'>var curopenItem = '1';</script>
<script language="javascript" type="text/javascript" src="skin/js/frame/menu.js"></script>
<base target="main" />
</head>
<body target="main">
<table width='99%' height="100%" border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td style='padding-left:3px;padding-top:8px' valign="top">
	<!-- Item 1 Strat -->
      <dl class='bitem'>
        <dt onClick='showHide("items1_1")'><b>快捷菜单</b></dt>
        <dd style='display:block' class='sitem' id='items1_1'>
          <ul class='sitemu'>
            <li>
              <div class='items'>
                <div class='fllct'><a href='main/guihua.php' target='main'>近期规划安排</a></div>
              </div>
            </li>
            <li>
              <div class='items'>
                <div class='fllct'><a href='archives.html' target='main'>近期任务管理</a></div>
              </div>
            </li>
            <li>
              <div class='items'>
                <div class='fllct'><a href='main/daycheck.php' target='main'>每日自我检查</a></div>
              </div>
            </li>
            <li>
              <div class='items'>
                <div class='fllct'><a href='archives.html' target='main'>随意记事本</a></div>
              </div>
            </li>
            <li><div class='items'><div class='fllct'><a href='archives.html' target='main'>资料收藏夹</a></div></div></li>
          </ul>
        </dd>
      </dl>
      <!-- Item 1 End -->


	<!-- Item 2 Strat -->
	  <?php
	$listhtmls=scandir(TOHTML_PATH.'/blogs');
	if(count($listhtmls)>2){
		?>
      <dl class='bitem'>
        <dt onClick='showHide("items1_2")'><b>博客列表</b></dt>
        <dd style='display:block' class='sitem' id='items1_2'>
          <ul class='sitemu'>

		<?php
		for($i=(count($listhtmls)-1);$i>=2;$i--){

			$substr=substr($listhtmls[$i],2,1);
			$subm=substr($listhtmls[$i],0,2);
			if($substr=='1'){
				echo "<li><div class='items'><div class='fllct'><a href='".URLHTML_PATH.'blogs/'.$listhtmls[$i]."' target='main'>".$subm."月上旬</a></div></div></li>";
			}elseif($substr=='2'){
				echo "<li><div class='items'><div class='fllct'><a href='".URLHTML_PATH.'blogs/'.$listhtmls[$i]."' target='main'>".$subm."月中旬</a></div></div></li>";
			}elseif($substr=='3'){
				echo "<li><div class='items'><div class='fllct'><a href='".URLHTML_PATH.'blogs/'.$listhtmls[$i]."' target='main'>".$subm."月下旬</a></div></div></li>";
			}else{
				echo substr($listhtmls[$i],0,2).'数据错误';
			}
		}
	}

	?>
          </ul>
        </dd>
      </dl>
      <!-- Item 2 End -->

	<!-- Item 3 Strat -->
	  <?php
	$listhtmls=scandir(TOHTML_PATH.'/news');
	if(count($listhtmls)>2){
		?>
      <dl class='bitem'>
        <dt onClick='showHide("items1_3")'><b>新闻列表</b></dt>
        <dd style='display:block' class='sitem' id='items1_3'>
          <ul class='sitemu'>

		<?php
		for($i=(count($listhtmls)-1);$i>=2;$i--){

			$substr=substr($listhtmls[$i],2,1);
			$subm=substr($listhtmls[$i],0,2);
			if($substr=='1'){
				echo "<li><div class='items'><div class='fllct'><a href='".URLHTML_PATH.'news/'.$listhtmls[$i]."' target='main'>".$subm."月上旬</a></div></div></li>";
			}elseif($substr=='2'){
				echo "<li><div class='items'><div class='fllct'><a href='".URLHTML_PATH.'news/'.$listhtmls[$i]."' target='main'>".$subm."月中旬</a></div></div></li>";
			}elseif($substr=='3'){
				echo "<li><div class='items'><div class='fllct'><a href='".URLHTML_PATH.'news/'.$listhtmls[$i]."' target='main'>".$subm."月下旬</a></div></div></li>";
			}else{
				echo substr($listhtmls[$i],0,2).'数据错误';
			}
		}
	}
	?>
          </ul>
        </dd>
      </dl>
      <!-- Item 2 End -->

	  </td>
  </tr>
</table>
</body>
</html>