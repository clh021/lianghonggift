<?php
     include_once 'leesession.php';
	 include('../include/config.php');
	 @include_once '../include/leecommon.php';
     $m_id=50;
     @include_once 'session1.php';//权限的判断
     @include_once '../include/mysql.php';
     @include_once '../util/util.php';
     
     //当前页码
     $pageNo=@$_REQUEST['pageNo'];
	 $pageNo=@trim($pageNo);
	 if(empty($pageNo)){
	    $pageNo=1;
	 }else{
	    $pageNo=(int)$pageNo;
		if($pageNo<=0){
		   $pageNo=1;
		}
	 }
         //echo gettype($pageNo).strlen($pageNo).$pageNo.'<hr />';
	 //每页显示多少条数据
	 $pageSize=@$_REQUEST['pageSize'];
	 $pageSize=@trim($pageSize);
	 if(empty($pageSize)){
	    $pageSize=4;
	 }else{
	    $pageSize=(int)$pageSize;
		if($pageSize<=0){
		    $pageSize=4;
		}
	 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/index.css" type="text/css" rel="stylesheet" />
<title>用户详细信息列表</title>
</head>
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

	   var pageNo=document.getElementById('pageNo').value;
	   pageNo=trim(pageNo);//去掉前后空格
	   if(pageNo!=null && pageNo!='' && pageNo.length>0){
		   pageNo=parseInt(pageNo);
		   if(pageNo>0 && pageNo!=pageNo1){
			   window.location.href='listUsers_detailed.php?pageSize='+pageSize+'&pageNo='+pageNo;
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
    <td><table border="0" cellpadding="0" cellspacing="0" class="list_table_main">
        <tr>
          <th>编号</th>
          <th>用户类别</th>
          <th>账号</th>
          <th>排序</th>
		  <th>注册时间</th>
		  <th>状态</th>
          <th>操作</th>
        </tr>
		<?php
         $db = new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);

		 $sql_count="SELECT ud.*,u.users_account FROM users_detailed ud,users u WHERE ud.users_id=u.users_id";
		 $result_count=mysql_query($sql_count);
         $totalRecord=mysql_num_rows($result_count);//总记录数
		 $totalPage=ceil($totalRecord / $pageSize);//总页数
         
		 $currRe=($pageNo-1)*$pageSize;//计算当前启始的记录数

		 $sql=$sql_count." LIMIT $currRe,$pageSize";
		 $res=mysql_query($sql);
		 while($row=mysql_fetch_array($res,MYSQL_BOTH)){
        ?>
		<tr>
		    <td><?php echo empty($row['ud_id'])?0:$row['ud_id']; ?></td>
		    <td>
		    <?php
					  //echo @empty($arr['ut_name'])?'':$arr['ut_name'];
						echo empty($row['userstype_id'])?0:$row['userstype_id'];
			   ?>
			   </td>
		    <td><?php echo empty($row['users_account'])?0:$row['users_account']; ?></td>
		    <td><?php echo empty($row['ud_sort'])?'':$row['ud_sort']; ?></td>
			<td title="<?php echo empty($row['ud_addtime'])?'':$row['ud_addtime']; ?>"><?php echo empty($row['ud_addtime'])?'':my_substr(helphtml($row['ud_addtime']),10,'utf-8',' '); ?></td>
			<td><?php echo empty($row['ud_status_set'])?'':$row['ud_status_set']; ?></td>
			<td><a href="editUsers_detailed.php?ud_id=<?php echo $row['ud_id']; ?>&pageNo=<?php echo $pageNo; ?>">修改</a></td>

		</tr>
	 <?php
		 }
	     //注销变量
	     unset($sql_count);
		 unset($result_count);
		 unset($totalRecord);
		 unset($currRe);
		 unset($sql);
		 unset($res);
		 unset($row);
	     $db->close();//关闭数据连接
	     unset($db);
	 ?>
      </table></td>
  </tr>
  <?php
      if($totalPage>1){
  ?>
  <td><table border="0" cellpadding="0" cellspacing="0" class="fenye">
        <tr>
		  <?php
	         if($pageNo<=1){
	      ?>
          <td>首页</td>
          <td>上一页</td>
		  <?php
	                  }else{
				   ?>
				   <td><a href="listUsers_detailed.php?pageSize=<?php echo $pageSize; ?>&pageNo=1">首页</a></td>
				   <td><a href="listUsers_detailed.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $pageNo<=1?1:($pageNo-1); ?>">上一页</a></td>
				   <?php
					  }
		           ?>
		  <?php
		      if($pageNo>=$totalPage){
		  ?>
		  <td>下一页</td>
		  <td>尾页</td>
		  <?php
				       }else{
				   ?>
				   <td><a href="listUsers_detailed.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $pageNo>=$totalPage?$totalPage:($pageNo+1) ?>">下一页</a></td>
				   <td><a href="listUsers_detailed.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $totalPage; ?>">尾页<a></td>
				   <?php
					   }   
		           ?>
          <td>去第
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
              <option></option>
            </select>
            页</td>
        </tr>
      </table></td>
  </tr>
  <?php
	  }
  ?>
</table>
</BODY>
</HTML>
