<?php
	@header("Content-type: text/html; charset=utf-8");
	//$m_id=40;//此处没有做页面访问权限的检查

	//require_once '../admin/checkcookie.php';//检查用户账号账号以及访问权限
	require_once '../../include/config.php';//声明页面编码以及设置smarty基本设置
	require_once '../../include/mysql.php';//包含有操作数据库的所有方法
	 //当前页码
	 $pageNo=@trim($pageNo);
	 if(empty($pageNo)){
		$pageNo=1;
	 }else{
		$pageNo=(int)$pageNo;
		if($pageNo<=0){
			 $pageNo=1;
		}
	 }
	 
	 //每页显示多少条数据
	 $pageSize=@trim($pageSize);
	 if(empty($pageSize)){
		$pageSize=13;
	 }else{
		$pageSize=(int)$pageSize;
		if($pageSize<=0){
			$pageSize=13;
		}
	}
	
    //报错的方法，弹出相应语句，并返回上一页面
    function msg_back($msg=""){
		if($msg==""){
			echo "<script>alert('要弹出窗口的语句不能为空');</script>";
		}else{
			unsetall();//销毁所有变量，释放内存
			echo "<script>alert('$msg');window.history.back();</script>";
			exit;
		}
    }
    //报错的方法，弹出相应语句，并跳出到指定页面
    function msg_out($msg="",$path=""){
		if($msg==""){
			echo "<script>alert('要弹出窗口的语句不能为空');</script>";
		}else{
			if($msg==""){
				echo "<script>alert('要跳出的页面路径不能为空');</script>";
			}else{
				unsetall();//销毁所有变量，释放内存
				echo "<script>alert('".$msg."');window.location.href='".$path."';</script>";
				exit;
			}
		}
    }
	 //页面排序依据
	 $paixu=@trim($paixu);
	 if(empty($paixu)||$paixu=''){
		$paixu='shixian';
	 }else{
			$tables_array=@cache_read('tables.php',CACHE_PATH);//CACHE_PATH--在include/config.php里定义的常量
			if(@empty($tables_array) && @count($tables_array)<1){
				msg_back('没有检测到缓存数据，请更新缓存数据！');
			}else{
				$contents_table=$tables_array['contents'][0];
				if(!in_array($paixu,$contents_table)){
					msg_back("接收到错误的排序值".$paixu."，请自觉遵守国家法律法规！");
				}
			}
	 }

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>规划</title>
<link rel="stylesheet" type="text/css" href="../skin/css/base.css">
<script type="text/javascript" language="javascript" src="../../js/calendar.js"></script>
<base href="http://localhost/leetobest/web/" />
<base target="_self">
<script language="javascript">
function viewArc(aid){
	if(aid==0) aid = getOneItem();
	window.open("archives.asp?aid="+aid+"&action=viewArchives");
}
function editArc(aid){
	if(aid==0) aid = getOneItem();
	location="archives.asp?aid="+aid+"&action=editArchives";
}
function updateArc(aid){
	var qstr=getCheckboxItem();
	if(aid==0) aid = getOneItem();
	location="archives.asp?aid="+aid+"&action=makeArchives&qstr="+qstr+"";
}
function checkArc(aid){
	var qstr=getCheckboxItem();
	if(aid==0) aid = getOneItem();
	location="archives.asp?aid="+aid+"&action=checkArchives&qstr="+qstr+"";
}
function moveArc(aid){
	var qstr=getCheckboxItem();
	if(aid==0) aid = getOneItem();
	location="archives.asp?aid="+aid+"&action=moveArchives&qstr="+qstr+"";
}
function adArc(aid){
	var qstr=getCheckboxItem();
	if(aid==0) aid = getOneItem();
	location="archives.asp?aid="+aid+"&action=commendArchives&qstr="+qstr+"";
}
function delArc(aid){
	var qstr=getCheckboxItem();
	if(aid==0) aid = getOneItem();
	location="archives.asp?aid="+aid+"&action=delArchives&qstr="+qstr+"";
}

//获得选中文件的文件名
function getCheckboxItem()
{
	var allSel="";
	if(document.form2.id.value) return document.form2.id.value;
	for(i=0;i<document.form2.id.length;i++)
	{
		if(document.form2.id[i].checked)
		{
			if(allSel=="")
				allSel=document.form2.id[i].value;
			else
				allSel=allSel+"`"+document.form2.id[i].value;
		}
	}
	return allSel;
}

//获得选中其中一个的id
function getOneItem()
{
	var allSel="";
	if(document.form2.id.value) return document.form2.id.value;
	for(i=0;i<document.form2.id.length;i++)
	{
		if(document.form2.id[i].checked)
		{
				allSel = document.form2.id[i].value;
				break;
		}
	}
	return allSel;
}
function selAll()
{
	for(i=0;i<document.form2.id.length;i++)
	{
		if(!document.form2.id[i].checked)
		{
			document.form2.id[i].checked=true;
		}
	}
}
function noSelAll()
{
	for(i=0;i<document.form2.id.length;i++)
	{
		if(document.form2.id[i].checked)
		{
			document.form2.id[i].checked=false;
		}
	}
}
	 /*
	 * 页面跳转
	 */
	 function goto(){
	   var pageNo1="<?php echo $pageNo; ?>";
	   pageNo1=parseInt(pageNo1);
	   var pageSize="<?php echo $pageSize; ?>";
	   pageSize=parseInt(pageSize);
	   var paixu="<?php echo $paixu; ?>";

	   var pageNo=document.getElementById('pageNo').value;
	   pageNo=trim(pageNo);//去掉前后空格
	   if(pageNo!=null && pageNo!='' && pageNo.length>0){
		   pageNo=parseInt(pageNo);
		   if(pageNo>0 && pageNo!=pageNo1){
			   window.location.href='listcontents.php?pageSize='+pageSize+'&pageNo='+pageNo+'&paixu='+paixu;
		   }
	   }
	 }
</script>
</head>
<body leftmargin="8" topmargin="8" background='skin/images/allbg.gif'>
<!--  搜索表单  -->
<form name='form3' action='' method='post'>
<input type='hidden' name='dopost' />
<table width='98%'  border='0' cellpadding='1' cellspacing='1' bgcolor='#CBD8AC' align="center" style="margin-top:8px">
  <tr bgcolor='#EEF4EA'>
    <td background='skin/images/wbg.gif'>
      <table border='0' cellpadding='0' cellspacing='0'>
        <tr>
		<td width="58%" align="left"><strong>&nbsp;文档列表&nbsp;</strong></td>
          <td align='right'>搜索条件：
          <select name='cid'>
          <option value='0'>选择类型...</option>
          	<option value='1'>名称</option>
          </select>
          关键字：
          	<input type='text' name='keyword'/>
          <input name="imageField" type="image" src="skin/images/frame/search.gif" width="45" height="20" border="0" class="np" />
    		<select name='orderby'>
            <option value='id'>排序...</option>
            <option value='pubdate'>发布时间</option>
      		</select>
        </td>
       </tr>
      </table>
    </td>
  </tr>
</table>
</form>
<!--  内容列表   -->
<form name="form2" action='<?php echo URL_PATH;?>webcontrol/leeguihua.php?method=add' method='post'>

<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
<tr align="center" bgcolor="#FAFAF1" height="22">
	<td width="5%">选择</td>
	<td width="8%">任务时限</td>
	<td width="10%">任务名称</td>
	<td width="8%">完成办法</td>
	<td width="5%">地点</td>
	<td width="8%">协助人</td>
	<td width="6%">重要性</td>
	<td width="8%">紧急程度</td>
	<td width="8%">完成条件</td>
	<td width="8%">任务备注</td>
	<td width="8%">完成总结</td>
	<td width="8%">总结时间</td>
</tr>
<?php
			$db = new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
		    $totalRecord=$db->selectCount('tguihua');//总记录数
			$totalPage=ceil($totalRecord / $pageSize);//总页数
		    $start=($pageNo-1)*$pageSize;//计算当前启始的记录数
			$back_arr=$db->selectPage('tguihua',array(),array(),array(),$paixu.' DESC',$start,$pageSize);
			for($i=0;$i<count($back_arr);$i++){
?>
<tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';" height="22" >
	<td><input name="id" type="Radio" id="id" value="<?php echo $back_arr[$i]['id'];?>" class="np"></td>
	<td><?php echo $back_arr[$i]['shixian'];?></td>
	<td align="left" title="<?php echo empty($back_arr[$i]['title'])?'<font color="red">空</font>':$back_arr[$i]['title'];?>"><a href='#'><u><?php echo $back_arr[$i]['title'];?></u></a></td>
	<td title="<?php echo $back_arr[$i]['banfa'];?>"><?php echo $back_arr[$i]['banfa'];?></td>
	<td title="<?php echo $back_arr[$i]['place'];?>"><?php echo $back_arr[$i]['place'];?></td>
	<td title="<?php echo $back_arr[$i]['xiezhu'];?>"><?php echo $back_arr[$i]['xiezhu'];?></td>
	<td><?php echo empty($back_arr[$i]['zhongyao'])?'<font color="red">空</font>':($back_arr[$i]['zhongyao']=='1'?'不重要':($back_arr[$i]['zhongyao']=='2'?'一般':($back_arr[$i]['zhongyao']=='3'?'重要':($back_arr[$i]['zhongyao']=='4'?'很重要':'<font color="red">未知值</font>'))));?></td>
	<td><?php echo empty($back_arr[$i]['jinji'])?'<font color="red">空</font>':($back_arr[$i]['jinji']=='1'?'不急':($back_arr[$i]['jinji']=='2'?'一般':($back_arr[$i]['jinji']=='3'?'急':($back_arr[$i]['jinji']=='4'?'很急':'<font color="red">未知值</font>'))));?></td>
	<td title="<?php echo $back_arr[$i]['tiaojian'];?>"><?php echo $back_arr[$i]['tiaojian'];?></td>
	<td title="<?php echo $back_arr[$i]['beizhu'];?>"><?php echo $back_arr[$i]['beizhu'];?></td>
	<td title="<?php echo $back_arr[$i]['zongjie'];?>"><?php echo $back_arr[$i]['zongjie'];?></td>
	<td title="<?php echo $back_arr[$i]['zongjietime'];?>"><?php echo $back_arr[$i]['zongjietime'];?></td>
</tr>
<?php
			}
?>
<tr align="right" bgcolor="#EEF4EA">
<?php if($totalPage>1){?>
<table border="0" cellpadding="0" cellspacing="0" width="100%";>
        <tr>
          <td class="STYLE2" align='center'>根据
		<select onChange="paixu();" id="paixu" name="paixu">
		<option value='contents_edittime'>更新时间</option>
		<option value='contents_addtime'>发表时间</option>
		<option value='contents_id'>编号</option>
		<option value='contents_sort'>排序号</option>
		</select>排序
		  </td>
		  <?php
	         if($pageNo<=1){
	      ?>
          <td class="STYLE2" align='center'>首页</td>
          <td class="STYLE2" align='center'>上一页</td>
		  <?php
             }else{
		  ?>
		  <td class="STYLE2" align='center'><a href="listcontents.php?pageSize=<?php echo $pageSize; ?>&pageNo=1">首页</a></td>
          <td class="STYLE2" align='center'><a href="listcontents.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $pageNo<=1?1:($pageNo-1);?>">上一页</a></td>
		  <?php
			 }
	      ?>
		  <?php
		      if($pageNo>=$totalPage){
		  ?>
		  <td class="STYLE2" align='center'>下一页</td>
		  <td class="STYLE2" align='center'>尾页</td>
		  <?php
		      }else{
		  ?>
		  <td class="STYLE2" align='center'><a href="listcontents.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $pageNo>=$totalPage?$totalPage:($pageNo+1) ?>">下一页</a></td>
          <td class="STYLE2" align='center'><a href="listcontents.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $totalPage; ?>">尾页</a></td>
		  <?php
			  }	  
		  ?>
          <td class="STYLE2" align='center'>去第
            <select onChange="goto();" id="pageNo" name="pageNo">
			  <?php
			      for($i=1;$i<=$totalPage;$i++){
			  	  if($i==$pageNo){
			  ?>
			  <option value="<?php echo $i ?>" selected='true'><?php echo $i ?></option>
			  <?php	  }else{
			  ?>
			  <option value="<?php echo $i ?>"><?php echo $i ?></option>
			  <?php
		              }
				  }
			  ?>
            </select>
            页</td>
        </tr>
      </table>
<?php } ?>
</tr>
<tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';" height="22" >
	<td><input type="submit" class="coolbg" value="新增"></td>
	<td><input type='text' id="shixian" name="shixian" title="完成任务的时限" style='width:80px' onfocus="setday(this)" readonly/></td>
	<td align="left"><input id="title" name="title" type='text' title="填写任务名称" style='width:150px' /></td>
	<td><input id="banfa" name="banfa" type='text' title="完成任务的方法" style='width:70px' /></td>
	<td><input id="place" name="place" type='text' title="任务完成的地点" style='width:70px' /></td>
	<td><input id="xiezhu" name="xiezhu" type='text' style='width:70px' title="协助人" /></td>
	<td>
          <select id="zhongyao" name='zhongyao' style='width:50'>
			<option value='2'>一般</option>
          	<option value='4'>很重要</option>
          	<option value='3'>重要</option>
          	<option value='1'>不重要</option>
          </select></td>
	<td>
          <select id="jinji" name='jinji' style='width:50'>
			<option value='2'>一般</option>
          	<option value='4'>很急</option>
          	<option value='3'>急</option>
          	<option value='1'>不急</option>
          </select></td>
	<td><input id="tiaojian" name="tiaojian" type='text' style='width:100px' title="填写完成任务的条件"/></td>
	<td colspan="3" align="left"><input id="beizhu" name="beizhu" type='text' title="填写任务备注" style='width:260px' /></td>

</tr>
<tr bgcolor="#FAFAF1">
<td height="28" colspan="12">
	&nbsp;&nbsp;&nbsp;
	<a href="javascript:selAll()" class="coolbg">全选</a>
	<a href="javascript:noSelAll()" class="coolbg">取消</a>
	<a href="javascript:updateArc(0)" class="coolbg">&nbsp;更新&nbsp;</a>
	<a href="javascript:checkArc(0)" class="coolbg">&nbsp;审核&nbsp;</a>
	<a href="javascript:adArc(0)" class="coolbg">&nbsp;推荐&nbsp;</a>
	<a href="javascript:moveArc(0)" class="coolbg">&nbsp;移动&nbsp;</a>
	<a href="javascript:delArc(0)" class="coolbg">&nbsp;删除&nbsp;</a>
</td>
</tr>
</table>
</form>
</body>
</html>