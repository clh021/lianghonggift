<?php
	include_once('../admin/leesession.php');
	checkmodules('contents');
	include_once('../include/config.php');
	include_once('../include/leecommon.php');//防止sql注入、预编义
	include_once('../include/leeutil.php');
	include_once('../include/cache.func.php');//加载读写缓存的方法

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
		$pageSize=18;
	 }else{
		$pageSize=(int)$pageSize;
		if($pageSize<=0){
			$pageSize=18;
		}
	}
	/*
	* 销毁变量，释放内存
	*/
	function unsetall(){
		unset($GLOBALS['_POST'],$GLOBALS['demo'],$GLOBALS['method'],$GLOBALS['methods'],$GLOBALS['nowtime'],$GLOBALS['nowuserid'],$GLOBALS['contents_id'],$GLOBALS['pageNo'],$GLOBALS['pageSize'],$GLOBALS['object_page'],$GLOBALS['falg'],$GLOBALS['success'],$GLOBALS['arr'],$GLOBALS['arr1'],$GLOBALS['arr2'],$GLOBALS['arr3'],$GLOBALS['arrcheck1'],$GLOBALS['arrcheck2'],$GLOBALS['arrcheck3'],$GLOBALS['cates_id'],$GLOBALS['htmlsucc'],$GLOBALS['updatehtmlpath'],$GLOBALS['cates_array'],$GLOBALS['i'],$GLOBALS['cates_path'],$GLOBALS['contents_list'],$GLOBALS['szx'],$GLOBALS['mo'],$GLOBALS['contents_id'],$GLOBALS['contents_title'],$GLOBALS['contents_key'],$GLOBALS['contents_desc'],$GLOBALS['contents_content'],$GLOBALS['cates_id'],$GLOBALS['positions_id'],$GLOBALS['contents_images'],$GLOBALS['contents_flashs'],$GLOBALS['contents_videos'],$GLOBALS['contents_downs'],$GLOBALS['contents_status'],$GLOBALS['contents_sort'],$GLOBALS['contents_hits'],$GLOBALS['contents_content'],$GLOBALS['contents_addusersid'],$GLOBALS['contents_addtime'],$GLOBALS['contents_editusersid'],$GLOBALS['contents_edittime'],$GLOBALS['contents_url'],$GLOBALS['contents_resource'],$GLOBALS['contents_remark1'],$GLOBALS['contents_remark2'],$GLOBALS['contents_remark3']);
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
	$tables_array=@cache_read('tables.php',CACHE_PATH);//CACHE_PATH--在include/config.php里定义的常量
	if(!in_array($paixu,array('contents_edittime','contents_addtime','contents_id','contents_sort'))){
		$paixu='contents_edittime';
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=http://mailto:clh21@126.com/ -->
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>欢迎进入系统后台</TITLE><script type="text/javascript" language="JavaScript" src="../js/jquery.min.js" ></script>  
<script type="text/javascript" language="JavaScript"> 
$(document).ready(function(){  //这个就是传说的ready 
          $(".list_table_main tr").mouseover(function(){     
                //如果鼠标移到class为stripe的表格的tr上时，执行函数 
                  $(this).addClass("over");}).mouseout(function(){  
                                //给这行添加class值为over，并且当鼠标一出该行时执行函数 
                  $(this).removeClass("over");})  //移除该行的class 
          $(".list_table_main tr:even").addClass("alt"); 
                //给class为stripe的表格的偶数行添加class值为alt 
}); 
</script> 
<style> 
tr.alt td { 
          background:#ecf6fc;  /*这行将给所有的tr加上背景色*/ 
} 
  
tr.over td { 
          background:#bcd4ec;  /*这个将是鼠标高亮行的背景色*/ 
} 
</style> 
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link href="style/index.css" type="text/css" rel="stylesheet" />
</HEAD>
<script type="text/javascript" language="JavaScript">
  <!--   
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
			   //window.location.href='listcontents.php?pageSize='+pageSize+'&pageNo='+pageNo+'&paixu='+paixu;
			   window.location.href='listcontents.php?pageSize='+pageSize+'&pageNo='+pageNo;//+'&paixu='+paixu;
		   }
	   }
	 }
	 /*
	 * 页面排序
	 */
	 function paixu(){
	   var pageNo1="<?php echo $pageNo; ?>";
	   pageNo1=parseInt(pageNo1);
	   var pageSize="<?php echo $pageSize; ?>";
	   pageSize=parseInt(pageSize);
	   var paixu1="<?php echo $paixu; ?>";

	   var paixu=document.getElementById('paixu').value;
	   paixu=trim(paixu);//去掉前后空格
	   if(paixu!=null && paixu!='' && paixu.length>0){
		   if(paixu!=paixu1){
			   window.location.href='listcontents.php?pageSize='+pageSize+'&pageNo='+pageNo1+'&paixu='+paixu;
		   }
	   }
	 }

	/*
     * 去掉前后空格
    */
    function trim(str){
		 return str.replace(/(^\s*)|(\s*$)/g, "");
    }
   //-->
</script>
<BODY>
<table border="0" cellpadding="0" cellspacing="0" class="list_table">
  <tr>
      <form action="" method="post" name="sousuo" class="STYLE2" id="sousuo">
	<Td  colSpan="13" height="24" align="right">
	标题<input type="text" name="c_title" id="c_title" style="width:50px">
	栏目
	<select name="c_cage" id="c_cage">
	<option value='' selected></option>
	<option value='news'>新闻</option>
	<option value='blogs'>博客</option>
	</select>
	推荐位<input type="text" name="c_positionsid" id="c_positionsid" style="width:20px">
	发布人<input type="text" name="c_adduserid" id="c_adduserid" style="width:50px">
	联系方式<input type="text" name="c_adduserid" id="c_adduserid" style="width:50px">
	点击
	<select name="c_hit" id="c_hit">
	<option value='' selected></option>
	<option value='1'>激活</option>
	<option value='2'>关闭</option>
	</select>
	回复
	<select name="c_status" id="c_status">
	<option value='' selected></option>
	<option value='1'>激活</option>
	<option value='2'>关闭</option>
	</select>
	状态
	<select name="c_status" id="c_status">
	<option value='' selected></option>
	<option value='1'>激活</option>
	<option value='2'>关闭</option>
	</select>
	排序<input type="text" name="c_adduserid" id="c_adduserid" style="width:50px"><input name="sousuo" type="submit" value="搜索"></Td>
	  </form> 
	</TR>
	</tr>
    <td><table class="list_table_main" cellSpacing=0 cellPadding=0 width="100%" border="0">
  <TBODY>
  <TR>
    <TH height=24 align="center" class="STYLE2">编号</TH>
    <TH height=24 align="center" class="STYLE2">标题</TH>
    <TH height=24 align="center" class="STYLE2">所属栏目</TH>
    <TH height=24 align="center" class="STYLE2">推荐位</TH>
    <TH height=24 align="center" class="STYLE2">发布人</TH>
    <TH height=24 align="center" class="STYLE2">联系方式</TH>
    <TH height=24 align="center" class="STYLE2">点击率</TH>
    <TH height=24 align="center" class="STYLE2">回复数</TH>
    <TH height=24 align="center" class="STYLE2">状态</TH>
    <TH height=24 align="center" class="STYLE2">排序</TH>
    <TH height=24 align="center" class="STYLE2">来源</TH>
    <TH height=24 align="center" class="STYLE2">静态页面</TH>
    <TH height=24 align="center" class="STYLE2">操作</TH>
	  </TR>
		<?php
		    @include_once '../include/mysql.php';
			$db = new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息

			$cates_array=@cache_read('cates.php',CACHE_PATH);//CACHE_PATH--在include/config.php里定义的常量
			$cates_hasdate=true;
			if(@empty($cates_array) && @count($cates_array)<1){$cates_hasdate=false;}
			$positions_array=@cache_read('positions.php',CACHE_PATH);//CACHE_PATH--在include/config.php里定义的常量
			$positions_hasdate=true;
			if(@empty($positions_array) && @count($positions_array)<1){$positions_hasdate=false;}




		    $totalRecord=$db->selectCount('contents');//总记录数
			$totalPage=ceil($totalRecord / $pageSize);//总页数
		    $start=($pageNo-1)*$pageSize;//计算当前启始的记录数
			$back_arr=$db->selectPage('contents',array(),array(),array(),$paixu.' DESC',$start,$pageSize);
			for($i=0;$i<count($back_arr);$i++){
		?>
  <TR>
    <TD height=24 align="center" class="STYLE2"><?php echo @empty($back_arr[$i]['contents_id'])?'0':$back_arr[$i]['contents_id']; ?></TD>
    <TD height=24 align="center" class="STYLE2"><?php echo @empty($back_arr[$i]['contents_title'])?'0':$back_arr[$i]['contents_title']; ?></TD>
    <TD height=24 align="center" class="STYLE2">
	<?php 
				$cates_id=@empty($back_arr[$i]['cates_id'])?'0':$back_arr[$i]['cates_id'];
				if($cates_hasdate && $cates_id!=0){
					echo $cates_array[($cates_id-1)]['cates_name'];
				}else{
					echo "<a title='请尝试更新关键数据缓存以显示类别名称。'>".$cates_id."</a>";
				}
	?>
	</TD>
    <TD height=24 align="center" class="STYLE2">
	<?php 
				$positions_id=@empty($back_arr[$i]['positions_id'])?'0':$back_arr[$i]['positions_id'];
				if($positions_id!='0'){
					$positions_name=@trim($positions_array[($positions_id-1)]['positions_name']);
					if(strlen($positions_name)<1){//
						echo "<a title='请尝试更新关键数据缓存以显示推荐位名称。'>".$positions_id."</a>";
					}else{
						echo $positions_name;
					}
				}else{
					echo '未使用推荐';
				}
	?>
	</TD>
    <TD height=24 align="center" class="STYLE2">
			<?php 
				$users_account=$db->selectSingle("users",$back_arr[$i]['contents_adduserid'],"users_id","INTEGER");
				echo @empty($users_account['users_account'])?'':$users_account['users_account']; ?>
			</TD>
    <TD height=24 align="center" class="STYLE2"><?php echo @empty($back_arr[$i]['contents_connect'])?'0':$back_arr[$i]['contents_connect']; ?></TD>
    <TD height=24 align="center" class="STYLE2"><?php echo @empty($back_arr[$i]['contents_hits'])?'0':$back_arr[$i]['contents_hits']; ?></TD>
    <TD height=24 align="center" class="STYLE2"><?php echo @empty($back_arr[$i]['contents_recive'])?'0':$back_arr[$i]['contents_recive']; ?></TD>
    <TD height=24 align="center" class="STYLE2">
	<?php echo @empty($back_arr[$i]['contents_status'])?'':($back_arr[$i]['contents_status']==1?'激活':'关闭')?>
	</TD>
    <TD height=24 align="center" class="STYLE2"><?php echo @empty($back_arr[$i]['contents_sort'])?'0':$back_arr[$i]['contents_sort']; ?></TD>
    <TD height=24 align="center" class="STYLE2"><?php echo @empty($back_arr[$i]['contents_resource'])?'0':$back_arr[$i]['contents_resource']; ?></TD>
    <TD height=24 align="center" class="STYLE2">
	<?php
			$Nopage=true;
			$object_page=TOHTML_PATH.$back_arr[$i]['contents_id'].'.html';
			if(file_exists($object_page)){
				if(!@empty($back_arr[$i]['contents_url'])||strlen($back_arr[$i]['contents_url'])>0){
					echo "<a href=".URLHTML_PATH.$back_arr[$i]['contents_url'].">".$back_arr[$i]['contents_url']."</a>"; 
				}else{
					echo "<a href=".URLHTML_PATH.$back_arr[$i]['contents_id'].".html>已生成</a>"; 
				}
			}else{
				$Nopage=false;
				echo "<a title='点击重新生成静态页面' href='../control/leecontents.php?method=html&contents_id=".$back_arr[$i]['contents_id']."&pageNo=".$pageNo."&pageSize=".$pageSize."'><font color='red'>未找到</font></a>";
			}
	?></TD>
    <TD height=24 align="center" class="STYLE2">
	<a href="editcontents.php?contents_id=<?php echo @empty($back_arr[$i]['contents_id'])?'0':$back_arr[$i]['contents_id'];?>&pageNo=<?php echo $pageNo<=1?1:($pageNo-1);?>">修改</a>
	<?php
		if($Nopage){
	?>
	<a href="../control/leecontents.php?method=delhtml&contents_id=<?php echo @empty($back_arr[$i]['contents_id'])?'0':$back_arr[$i]['contents_id'];?>&pageNo=<?php echo $pageNo; ?>&pageSize=<?php echo $pageSize; ?>">删静态</a>
	<?php
		}else{
	?>
	删静态
	<?php
	}
	?>
	<a href="../control/leecontents.php?method=del&contents_id=<?php echo @empty($back_arr[$i]['contents_id'])?'0':$back_arr[$i]['contents_id'];?>&pageNo=<?php echo $pageNo; ?>&pageSize=<?php echo $pageSize; ?>">删彻底</a></TD></TR>
	<?php } ?>
</TBODY>
</TABLE></td>
  </tr>
<?php if($totalPage>1){?>
<td><table border="0" cellpadding="0" cellspacing="0" width="100%";>
        <tr>
          <td class="STYLE2" align='center'>根据
		<select onChange="paixu();" id="paixu" name="paixu">
		<?php 
	if($paixu=='contents_edittime'){
		?>
		<option value="contents_edittime" selected="true">更新时间</option>
		<option value="contents_addtime">发表时间</option>
		<option value="contents_id">编号</option>
		<option value="contents_sort">排序号</option>
		<?php
	}elseif($paixu=='contents_addtime'){
		?>
		<option value="contents_edittime">更新时间</option>
		<option value="contents_addtime" selected="true">发表时间</option>
		<option value="contents_id">编号</option>
		<option value="contents_sort">排序号</option>
		<?php
	}elseif($paixu=='contents_id'){
		?>
		<option value="contents_edittime">更新时间</option>
		<option value="contents_addtime">发表时间</option>
		<option value="contents_id" selected="true">编号</option>
		<option value="contents_sort">排序号</option>
		<?php
	}elseif($paixu=='contents_sort'){
		?>
		<option value="contents_edittime">更新时间</option>
		<option value="contents_addtime">发表时间</option>
		<option value="contents_id">编号</option>
		<option value="contents_sort" selected="true">排序号</option>
		<?php
	}else{
		?>
		<option value="contents_edittime">更新时间</option>
		<option value="contents_addtime">发表时间</option>
		<option value="contents_id">编号</option>
		<option value="contents_sort">排序号</option>
		<?php
	}	
		?>
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
      </table></td>
  </tr>
<?php } ?>
</BODY></HTML>
