<?php
     include_once 'leesession.php';
     checkmodules('roles');//陈良红对管理员权限的判断//$m_id=39;
	 include('../include/config.php');
	 include_once '../include/leecommon.php';

	 //当前页码
	 //$pageNo=@$_REQUEST['pageNo'];
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
	 //$pageSize=@$_REQUEST['pageSize'];
	 $pageSize=@trim($pageSize);
	 if(empty($pageSize)){
		$pageSize=10;
	 }else{
		$pageSize=(int)$pageSize;
		if($pageSize<=0){
			$pageSize=10;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/index.css" type="text/css" rel="stylesheet" />
<title>角色列表</title>
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
			   window.location.href='listRoles.php?pageSize='+pageSize+'&pageNo='+pageNo;
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
<body>
<table border="0" cellpadding="0" cellspacing="0" class="list_table">
  <tr>
    <td><table border="0" cellpadding="0" cellspacing="0" class="list_table_main">
        <tr>
          <th>编号</th>
		  <th>角色名</th>
		  <th>添加者</th>
          <th>添加时间</th>
		  <th>状态</th>
          <th>操作</th>
        </tr>
		<?php
		    @include_once '../include/mysql.php';
			$db = new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
			
			$sql="SELECT * FROM roles ";
			$res=mysql_query($sql);
			$totalRecord=mysql_num_rows($res);//总记录数
			$totalPage=ceil($totalRecord / $pageSize);//总页数
		    $start=($pageNo-1)*$pageSize;//计算当前启始的记录数
		    $sql_limit="SELECT * FROM roles  LIMIT ".$start.",".$pageSize;
		    $result=mysql_query($sql_limit);
			while($back_arr=mysql_fetch_array($result,MYSQL_BOTH)){
		?>
		<tr>
		   <td><?php echo @empty($back_arr['roles_id'])?'0':$back_arr['roles_id']?></td>
		   <td><?php echo @empty($back_arr['roles_name'])?'':$back_arr['roles_name']?></td>
		   
		   <td>
		       <?php
			       if(!@empty($back_arr['users_id'])){
			          $sql_users="SELECT * FROM users WHERE users_id=".$back_arr['users_id'];
			          $res_user=mysql_query($sql_users);
			          $arr=mysql_fetch_array($res_user,MYSQL_BOTH);
					  echo @empty($arr['users_account'])?'':$arr['users_account'];
		           }
			   ?>
		   </td>
		   <td title="<?php echo @empty($back_arr['roles_addtime'])?'':$back_arr['roles_addtime'];?>"><?php echo @empty($back_arr['roles_addtime'])?'':substr($back_arr['roles_addtime'],5,5);?></td>
		   <td><?php echo @empty($back_arr['roles_status'])?'':($back_arr['roles_status']==1?'激活':'关闭')?></td>
		   <td>
		       <a href="editRoles.php?roles_id=<?php echo @empty($back_arr['roles_id'])?'0':$back_arr['roles_id'];?>&pageNo=<?php echo $pageNo; ?>">修改</a>
               <a href="../control/roles.php?method=delete&roles_id=<?php echo $back_arr['roles_id']; ?>&pageNo=<?php echo $pageNo; ?>&pageSize=<?php echo $pageSize?>">删除</a>
		   </td>
		</tr>
		<?php
			}
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
		  <td><a href="listRoles.php?pageSize=<?php echo $pageSize; ?>&pageNo=1">首页</a></td>
          <td><a href="listRoles.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $pageNo<=1?1:($pageNo-1);?>">上一页</a></td>
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
		  <td><a href="listRoles.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $pageNo>=$totalPage?$totalPage:($pageNo+1) ?>">下一页</a></td>
          <td><a href="listRoles.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $totalPage; ?>">尾页</a></td>
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
            </select>
            页</td>
        </tr>
      </table></td>
  </tr>
  <?php
	  }
  ?>
</table>
</body>
</html>
<?php
   $db->close();//关闭数据库连接
   unset($db);
?>

