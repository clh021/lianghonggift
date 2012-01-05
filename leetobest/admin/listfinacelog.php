<?php
     include_once('leesession.php');
     checkmodules('finacelog');//陈良红对管理员权限的判断//$m_id=5;
	 include_once('../include/config.php');
	 include_once('../include/leecommon.php');
	 include_once('../include/leeutil.php');
	 include_once('../include/mysql.php');

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
		$pageSize=19;
	 }else{
		$pageSize=(int)$pageSize;
		if($pageSize<=0){
			$pageSize=19;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/index.css" type=text/css rel=stylesheet />
<title>财务日志列表</title>
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
			   window.location.href='listfinacelog.php?pageSize='+pageSize+'&pageNo='+pageNo;
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
		  <th>用户</th>
		  <th>时间</th>
		  <th>支出额</th>
		  <th>支出原因</th>
		  <th>收入额</th>
		  <th>收入原因</th>
		  <th>财务结算</th>
		  <th>财务总结</th>
		  <th>记录时间</th>
          <th width='5%'>操作</th>
        </tr>
		<?php
			$db = new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息

		    $totalRecord=$db->selectCount('finacelog');//总记录数
			$totalPage=ceil($totalRecord / $pageSize);//总页数
		    $start=($pageNo-1)*$pageSize;//计算当前启始的记录数
			$back_arr=$db->selectPage('finacelog',array(),array(),array(),'finacelog_date desc',$start,$pageSize);
			for($i=0;$i<count($back_arr);$i++){
		?>
		<tr>
		   <td><?php echo @empty($back_arr[$i]['finacelog_id'])?'0':$back_arr[$i]['finacelog_id']?></td>
		   <td><?php 
				$users_account=$db->selectSingle("users",$back_arr[$i]['users_id'],"users_id","INTEGER");
				echo @empty($users_account['users_account'])?'':$users_account['users_account'];?></td>
		   <td title='<?php echo @empty($back_arr[$i]['finacelog_date'])?'':$back_arr[$i]['finacelog_date'];?>'><?php echo @empty($back_arr[$i]['finacelog_date'])?'':substr($back_arr[$i]['finacelog_date'],5,10);?></td>
		   <td><?php echo @empty($back_arr[$i]['finacelog_payout'])?'':$back_arr[$i]['finacelog_payout']?></td>
		   <td title='<?php echo @empty($back_arr[$i]['finacelog_whypay'])?'':$back_arr[$i]['finacelog_whypay']?>'><?php echo @empty($back_arr[$i]['finacelog_whypay'])?'':my_substr($back_arr[$i]['finacelog_whypay'],12,'UTF-8')?></td>
		   <td><?php echo @empty($back_arr[$i]['finacelog_putin'])?'':$back_arr[$i]['finacelog_putin']?></td>
		   <td title='<?php echo @empty($back_arr[$i]['finacelog_whyput'])?'':$back_arr[$i]['finacelog_whyput']?>'><?php echo @empty($back_arr[$i]['finacelog_whyput'])?'':my_substr($back_arr[$i]['finacelog_whyput'],12,'UTF-8')?></td>
		   <td><?php echo @empty($back_arr[$i]['finacelog_balance'])?'':$back_arr[$i]['finacelog_balance']?></td>
		   <td title='<?php echo @empty($back_arr[$i]['finacelog_sumup'])?'':$back_arr[$i]['finacelog_sumup']?>'><?php echo @empty($back_arr[$i]['finacelog_sumup'])?'':my_substr($back_arr[$i]['finacelog_sumup'],12,'UTF-8')?></td>
		   <td title='<?php echo @empty($back_arr[$i]['finacelog_addtime'])?'':$back_arr[$i]['finacelog_addtime']?>'><?php echo @empty($back_arr[$i]['finacelog_addtime'])?'':substr($back_arr[$i]['finacelog_addtime'],8,-3)?></td>
		   <td>
		       <a href="editfinacelog.php?finacelog_id=<?php echo @empty($back_arr[$i]['finacelog_id'])?'0':$back_arr[$i]['finacelog_id'];?>&pageNo=<?php echo $pageNo; ?>">修改</a>
               <a href="../control/finacelog.php?method=delete&finacelog_id=<?php echo @empty($back_arr[$i]['finacelog_id'])?'0':$back_arr[$i]['finacelog_id'];?>&pageNo=<?php echo $pageNo; ?>&pageSize=<?php echo $pageSize; ?>">删除</a>
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
		  <td><a href="listfinacelog.php?pageSize=<?php echo $pageSize; ?>&pageNo=1">首页</a></td>
          <td><a href="listfinacelog.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $pageNo<=1?1:($pageNo-1);?>">上一页</a></td>
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
		  <td><a href="listfinacelog.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $pageNo>=$totalPage?$totalPage:($pageNo+1) ?>">下一页</a></td>
          <td><a href="listfinacelog.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $totalPage; ?>">尾页</a></td>
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
