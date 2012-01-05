<?php
    include_once('leesession.php');//判断是不是管理员
	checkmodules('cates');//陈良红对管理员权限的判断//$m_id=23;
    include_once('../include/config.php');//配置文件
	include_once('../include/leecommon.php');//防止sql注入、预编义
	include_once('../include/leeutil.php');
	include_once('../include/cache.func.php');//加载缓存

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/index.css" type=text/css rel=stylesheet />
<title>栏目列表</title>
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
			   window.location.href='listcates.php?pageSize='+pageSize+'&pageNo='+pageNo;
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
          <th>模块</th>
		  <th>名称</th>
		  <th>路径</th>
		  <th>内容</th>
		  <th>父栏</th>
		  <th>父路径</th>
		  <th>点击率</th>
		  <th>条目数</th>
		  <th>类型</th>
		  <th>URL</th>
		  <th>添加者</th>
          <th>添加时间</th>
		  <th>更新者</th>
		  <th>更新时间</th>
		  <th>状态</th>
		  <th>排序</th>
		  <th>操作</th>
        </tr>
		<?php
		    @include_once '../include/mysql.php';
			$db = new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息

		    $totalRecord=$db->selectCount('cates');//总记录数
			$totalPage=ceil($totalRecord / $pageSize);//总页数
		    $start=($pageNo-1)*$pageSize;//计算当前启始的记录数
			$back_arr=$db->selectPage('cates',array(),array(),array(),'',$start,$pageSize);
			for($i=0;$i<count($back_arr);$i++){
		?>
		<tr>
		   <td><?php echo @empty($back_arr[$i]['cates_id'])?'0':$back_arr[$i]['cates_id']; ?></td>
		   <td><?php 
		    $modules_id=$back_arr[$i]['modules_id'];
		   	$modules_array=@cache_read('modules.php',CACHE_PATH);//CACHE_PATH--在include/config.php里定义的常量
			if(@empty($modules_array) && @count($modules_array)<=0){
				echo "<script>alert('请更新缓存。');window.history.back();</script>";
				exit;
			}else{
				echo $modules_array[($modules_id-1)]['modules_name'];
			}
				?>
		   </td>
		   <td><?php echo @empty($back_arr[$i]['cates_name'])?'0':$back_arr[$i]['cates_name']; ?></td>
		   <td><?php echo @empty($back_arr[$i]['cates_path'])?'0':$back_arr[$i]['cates_path']; ?></td>
		   <td title="<?php echo @empty($back_arr[$i]['cates_content'])?'':$back_arr[$i]['cates_content']; ?>"><?php echo @empty($back_arr[$i]['cates_content'])?'':my_substr(helphtml($back_arr[$i]['cates_content']),4,'utf-8'); ?></td>
		   <td>
		      <?php
			       if(!@empty($back_arr[$i]['cates_parentid'])){
			          $ar=$db->selectSingle('cates',$back_arr[$i]['cates_parentid'],'cates_id','INTEGER');
					  echo @empty($ar['cates_name'])?'':$ar['cates_name'];
		           }
			  ?>
		   </td>
		   <td><?php echo @empty($back_arr[$i]['cates_parent_dir'])?'0':$back_arr[$i]['cates_parent_dir']; ?></td>
		   <td><?php echo @empty($back_arr[$i]['cates_hits'])?'0':$back_arr[$i]['cates_hits']; ?></td>
		   <td><?php echo @empty($back_arr[$i]['cates_items'])?'0':$back_arr[$i]['cates_items']; ?></td>
		   <td><?php echo @empty($back_arr[$i]['cates_type'])?'0':$back_arr[$i]['cates_type']; ?></td>
		   <td><?php echo @empty($back_arr[$i]['cates_url'])?'0':$back_arr[$i]['cates_url']; ?></td>
		   <td>
		       <?php
			       if(!@empty($back_arr[$i]['cates_addusersid'])){
			          $arr=$db->selectSingle('users',$back_arr[$i]['cates_addusersid'],'users_id','INTEGER');
					  echo @empty($arr['users_account'])?'':$arr['users_account'];
		           }
			   ?>
		   </td>
		   <td title="<?php echo @empty($back_arr[$i]['cates_addtime'])?'':$back_arr[$i]['cates_addtime'];?>"><?php echo @empty($back_arr[$i]['cates_addtime'])?'':substr($back_arr[$i]['cates_addtime'],5,5);?></td>
		   <td>
		       <?php
			       if(!@empty($back_arr[$i]['cates_editusersid'])){
			          $arr=$db->selectSingle('users',$back_arr[$i]['cates_editusersid'],'users_id','INTEGER');
					  echo @empty($arr['users_account'])?'':$arr['users_account'];
		           }
			   ?>
		   </td>
		   <td title="<?php echo @empty($back_arr[$i]['cates_edittime'])?'':$back_arr[$i]['cates_edittime'];?>"><?php echo @empty($back_arr[$i]['cates_edittime'])?'':substr($back_arr[$i]['cates_edittime'],5,5);?></td>
		   <td><?php echo @empty($back_arr[$i]['cates_status'])?'':($back_arr[$i]['cates_status']==1?'激活':'关闭');?></td>
		   <td><?php echo @empty($back_arr[$i]['cates_sort'])?'0':$back_arr[$i]['cates_sort']; ?></td>
		   <td>
		       <a href="editcates.php?cates_id=<?php echo @empty($back_arr[$i]['cates_id'])?'0':$back_arr[$i]['cates_id'];?>&pageNo=<?php echo $pageNo; ?>">修改</a> 
               <a href="../control/cates.php?method=delete&cates_id=<?php echo @empty($back_arr[$i]['cates_id'])?'0':$back_arr[$i]['cates_id'];?>&pageNo=<?php echo $pageNo; ?>&pageSize=<?php echo $pageSize; ?>">删除</a>
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
		  <td><a href="listcates.php?pageSize=<?php echo $pageSize; ?>&pageNo=1">首页</a></td>
          <td><a href="listcates.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $pageNo<=1?1:($pageNo-1);?>">上一页</a></td>
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
		  <td><a href="listcates.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $pageNo>=$totalPage?$totalPage:($pageNo+1) ?>">下一页</a></td>
          <td><a href="listcates.php?pageSize=<?php echo $pageSize; ?>&pageNo=<?php echo $totalPage; ?>">尾页</a></td>
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
