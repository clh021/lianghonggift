<?php
     include_once'leesession.php';
	checkmodules('friends');//陈良红对管理员权限的判断//$m_id=18;
	 //特别说明：只要具备有后台登录权限的用户都可以浏览此页面，拥有本页面特权的用户可以浏览到所有用户的日志，没有的，只能浏览到自己的日志。
	 include_once'../include/config.php');
	include_once'../include/leeutil.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/index.css" type="text/css" rel="stylesheet" />
<title>人脉资源列表</title>
<script type="text/javascript" language="JavaScript" src="../js/jquery.min.js" ></script>  
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
</head>
<style> 
tr.alt td { 
          background:#ecf6fc;  /*这行将给所有的tr加上背景色*/ 
} 
  
tr.over td { 
          background:#bcd4ec;  /*这个将是鼠标高亮行的背景色*/ 
} 
</style> 
<script type="text/javascript" language="JavaScript">
  <!--           
         function goto(){
		   var pageNo=document.getElementById('pageNo').value;
		   if(pageNo.length>0){
			   window.location.href='listfriends.php?pageNo='+pageNo;
		   }
	     }
   //-->
</script>
<body>
<table border="0" cellpadding="0" cellspacing="0" class="list_table">
  <tr>
    <td><table class="list_table_main" width="100%" border="0" cellpadding="0" cellspacing="0">
	<thead> 
        <tr>
          <th>编号</th>
		  <th>用户</th>
		  <th>姓名</th>
          <th>账号</th>
          <th>关系</th>
          <th>level</th>
          <th>性别</th>
		  <th>生日</th>
		  <th>农阳</th>
		  <th>QQ</th>
		  <th>手机</th>
		  <th>邮箱</th>
		  <th>籍贯</th>
          <th>状态</th>
          <th>排序</th>
          <th >操作</th>
        </tr>
</thead> 
		<?php
		    @include_once'../include/mysql.php';
			$db = new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息

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
			 
			//每页显示多少条数据
			$pageSize=@$_REQUEST['pageSize'];
			$pageSize=@trim($pageSize);
			if(empty($pageSize)){
				$pageSize=18;
			}else{
				$pageSize=(int)$pageSize;
				if($pageSize<=0){
					$pageSize=18;
				}
			}

		    $totalRecord=$db->selectCount('friends');//总记录数
			$totalPage=ceil($totalRecord / $pageSize);//总页数
		    $start=($pageNo-1)*$pageSize;//计算当前启始的记录数
			$back_arr=$db->selectPage('friends',array(),array(),array(),'',$start,$pageSize);
			for($i=0;$i<count($back_arr);$i++){
		?>
<tbody> 
		<tr>
		   <td><?php echo @empty($back_arr[$i]['friends_id'])?'':$back_arr[$i]['friends_id']?></td>
		   <td><?php
				$users_account=$db->selectSingle("users",$back_arr[$i]['users_id'],"users_id","INTEGER");
				echo @empty($users_account['users_account'])?'':$users_account['users_account'];	
		?></td>
		   <td><?php echo @empty($back_arr[$i]['friends_name'])?'':$back_arr[$i]['friends_name']?></td>
		  <td>
		   <?php
			if(@empty($back_arr[$i]['friends_friendsid'])||strlen($back_arr[$i]['friends_friendsid'])>1){
				$users_account=$db->selectSingle("users",$back_arr[$i]['friends_friendsid'],"users_id","INTEGER");
				echo @empty($users_account['users_account'])?'':$users_account['users_account'];
			}else{
				echo '待认证';
			}
			?>
		   </td>
		   <td><?php echo @empty($back_arr[$i]['friends_relations'])?'':$back_arr[$i]['friends_relations']?></td>
		   <td><?php echo @empty($back_arr[$i]['friends_level'])?'':$back_arr[$i]['friends_level']?></td>
		   <td><?php echo @empty($back_arr[$i]['friends_sex'])?'未知':($back_arr[$i]['friends_sex']==1)?'男':(($back_arr[$i]['friends_sex']==2)?'女':'未知')?></td>
		   <td><?php echo @empty($back_arr[$i]['friends_birthday'])?'':$back_arr[$i]['friends_birthday']?></td>
		   <td><?php echo @empty($back_arr[$i]['friends_calendar'])?'':$back_arr[$i]['friends_calendar']?></td>
		   <td><?php echo @empty($back_arr[$i]['friends_qq'])?'':$back_arr[$i]['friends_qq']?></td>
		   <td><?php echo @empty($back_arr[$i]['friends_mobile'])?'':$back_arr[$i]['friends_mobile']?></td>
		   <td><?php echo @empty($back_arr[$i]['friends_email'])?'':$back_arr[$i]['friends_email']?></td>
		   <td><?php echo @empty($back_arr[$i]['friends_birthplace'])?'':$back_arr[$i]['friends_birthplace']?></td>
		   <td><?php echo @empty($back_arr[$i]['friends_status'])?'':($back_arr[$i]['friends_status']==1?'激活':'关闭')?></td>
		   <td><?php echo @empty($back_arr[$i]['friends_sort'])?'':$back_arr[$i]['friends_sort']?></td>
		   <td>
		       <a href="detailfriends.php?friends_id=<?php echo @empty($back_arr[$i]['friends_id'])?'0':$back_arr[$i]['friends_id'];?>&pageNo=<?php echo $pageNo; ?>">详细</a>
			   &nbsp;&nbsp;
               <a href="../control/friends.php?method=del&friends_id=<?php echo @empty($back_arr[$i]['friends_id'])?'0':$back_arr[$i]['friends_id'];?>&pageNo=<?php echo $pageNo; ?>&pageSize=<?php echo $pageSize; ?>">删除</a>
		   </td>
		</tr>
</tbody> 
		<?php
			}
		?>
      </table></td>
  </tr>
  <?php
      if($totalPage>1){
  ?> <td><table border="0" cellpadding="0" cellspacing="0" class="fenye">
        <tr>
		  <?php
	         if($pageNo<=1){
	      ?>
          <td>首页</td>
          <td>上一页</td>
		  <?php
             }else{
		  ?>
		  <td><a href="listfriends.php?pageSize=<?php echo $pageSize; ?>&pageNo=1">首页</a></td>
          <td><a href="listfriends.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $pageNo<=1?1:($pageNo-1);?>">上一页</a></td>
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
		  <td><a href="listfriends.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $pageNo>=$totalPage?$totalPage:($pageNo+1) ?>">下一页</a></td>
          <td><a href="listfriends.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $totalPage; ?>">尾页</a></td>
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
