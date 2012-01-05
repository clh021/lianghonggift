<?php
	include_once('../admin/leesession.php');
	checkmodules('contents');
	include_once('../include/config.php');
	include_once('../include/leecommon.php');//防止sql注入、预编义

	$contents_id=@trim($contents_id);
	if(empty($contents_id)){
		echo "<script>alert('内容编号不允许为空');window.history.back();</script>";
		exit;
	}else{
		$contents_id=(int)$contents_id;
		if($contents_id<=0){
			echo "<script>alert('内容编号不对');window.history.back();</script>";
			exit;
		}
	}

	$pageNo=@trim($pageNo);
	if(empty($pageNo)){
		echo "<script>alert('当前页码不允许为空');window.history.back();</script>";
		exit;
	}else{
		$pageNo=(int)$pageNo;
		if($pageNo<=0){
			echo "<script>alert('当前页码不对');window.history.back();</script>";
			exit;
		}
	}


	include_once'../include/cache.func.php';//加载缓存
	$content_modules_id=0;
	$modules_array=@cache_read('modules.php',CACHE_PATH);//CACHE_PATH--在include/config.php里定义的常量
	if(!@empty($modules_array) && @count($modules_array)>0){
		for($m=0;$m<count($modules_array);$m++){
			if($modules_array[$m]['modules_path']=='contents'){
				$content_modules_id=$m+1;
				break;
			}
		}
	}else{
		echo "<script>alert('请更新缓存。');window.history.back();</script>";
		exit;
	}
	include('../include/mysql.php');//加载数据库操作文件
	$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
	$falg=$db->selectBool('contents',$contents_id,'contents_id','INTEGER');
	if($falg===false){
		echo "<script>alert('该数据已经不存在了');window.history.back();</script>";
		exit;
	}
	$back_arr=$db->selectSingle('contents',$contents_id,'contents_id','INTEGER');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0040)http://2school.wygk.cn/admin/syscome.asp -->
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>趁霓虹灯未亮个人管理系统后台</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8"><LINK 
href="<?php echo URL_PATH."admin/images/syscome.files/Admin.css" ?>" rel=stylesheet>
<script type="text/javascript" src="<?php echo URL_PATH."fckeditor/fckeditor.js" ?>"></script>
<script type="text/javascript" language="JavaScript">
<!--
   function check(){
        var contents_title=document.getElementById('contents_title').value;
		contents_title=trim(contents_title);//调用函数---去掉前后空格
		if(contents_title.length<=0){
			alert("请填写标题");
			return false;
		}
        var contents_key=document.getElementById('contents_key').value;
		contents_key=trim(contents_key);//调用函数---去掉前后空格
		if(contents_key.length<=0){
			alert("请填写关键字");
			return false;
		}
        var contents_connect=document.getElementById('contents_connect').value;
		contents_connect=trim(contents_connect);//调用函数---去掉前后空格
		if(contents_connect.length<=0){
			alert("请填写联系方式");
			return false;
		}
        var contents_resource=document.getElementById('contents_resource').value;
		contents_resource=trim(contents_resource);//调用函数---去掉前后空格
		if(contents_resource.length<=0){
			alert("请填写内容来源");
			return false;
		}
		
   }

   /*
      去掉前后空格
    */
   function trim(str){
		 return str.replace(/(^\s*)|(\s*$)/g, "");
   } 
   
   function load(){
		var sBasePath = '<?php echo URL_PATH."fckeditor/" ?>'+document.location.href.substring(0,document.location.href.lastIndexOf('_samples')) ;
		var oFCKeditor = new FCKeditor( 'contents_content' ) ;
		oFCKeditor.BasePath=sBasePath;
		oFCKeditor.ReplaceTextarea();
  }
//-->
</script>
<STYLE type=text/css>.STYLE1 {
	FONT-WEIGHT: bold; COLOR: #0099ff
}
body,td,th {
	font-size: 12px;
	color: #222;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</STYLE>
</HEAD>
<BODY onLoad="load()">
<form  action="<?php echo URL_PATH; ?>control/leecontents.php?method=update&contents_id=<?php echo $contents_id; ?>" method="post" onSubmit="return check();">
<TABLE cellSpacing=1 cellPadding=3 width="100%" align=center border=0>
  <TBODY>
  <TR>
    <TD height=24 align="right">标题：</TD>
    <TD height=24><input type="text" id="contents_title" name="contents_title" value="<?php echo empty($back_arr['contents_title'])?'':$back_arr['contents_title']; ?>"/><font color="red">( * 必填 )</font></TD>
  </TR>
  <TR>
    <TD height=24 align="right">关键字：</TD>
    <TD height=24><input type="text" id="contents_key" name="contents_key" value="<?php echo empty($back_arr['contents_key'])?'':$back_arr['contents_key']; ?>"/></TD>
  </TR>
  <TR>
    <TD height=24 align="right">描述：</TD>
    <TD height=24><input type="text" id="contents_desc" name="contents_desc" value="<?php echo empty($back_arr['contents_desc'])?'':$back_arr['contents_desc']; ?>"/></TD>
  </TR>
  <TR>
    <TD align="right">内容：</TD>
    <TD width="90%" height="100"><textarea id="contents_content" name="contents_content" ><?php echo empty($back_arr['contents_content'])?'':$back_arr['contents_content']; ?></textarea></TD></TR>
  <TR>
    <TD height=24 align="right">所属栏目：</TD>
    <TD height=24>
		      <select id="cates_id" name="cates_id"/>
			     <?php
	$cates_array=@cache_read('cates.php',CACHE_PATH);//CACHE_PATH--在include/config.php里定义的常量

	if(!@empty($cates_array) && @count($cates_array)>0){
		$arr1=array();
		for($i=0;$i<count($cates_array);$i++){//转换成可用于的递归的格式
			if($cates_array[$i]['cates_status']==1){//过滤掉禁用的栏目
				array_push($arr1, $cates_array[$i]['cates_id'].'-'.$cates_array[$i]['cates_parentid'].'-'.$cates_array[$i]['cates_name']);//
			}
		}
		/*
		include_once'../include/recursive.php';//递归
		$rec=new Recursive($arr1,'&nbsp;&nbsp;');//将所有栏目组成数组传入递归类
		$rec->digui('0',0);//将数组所有数据递归分类
		$back=$rec->back;//所有栏目全部遍历出
		$rec1=new Recursive($arr1,'&nbsp;&nbsp;');
		$rec1->digui(strval($cates_id),0);//将数组所有数据递归分类
		*/
	}
					include_once'../include/recursive.php';//递归
			        $cates_sql="SELECT * FROM cates WHERE cates_status=1";
			        $cates_result=mysql_query($cates_sql);
			        $cates_array=array();//取出启用的所有栏目
			        while($row=mysql_fetch_array($cates_result,MYSQL_BOTH)){
			        	$cates_array=array_pad($cates_array,count($cates_array)+1,$row);
			        }
					$arr_c=array();
					if(!@empty($cates_array) && @count($cates_array)>0){
						$arr1=array();
						for($i=0;$i<count($cates_array);$i++){
							array_push($arr1, $cates_array[$i]['cates_id'].'-'.$cates_array[$i]['cates_parentid'].'-'.$cates_array[$i]['cates_name']);//
						}
                        include_once'../include/recursive.php';//递归
                        $rec=new Recursive($arr1,'&nbsp;&nbsp;');//将所有栏目组成数组传入递归类
						$rec->digui('0',0);//将数组所有数据递归分类
						$back=$rec->back;//所有栏目全部遍历出
						$rec1=new Recursive($arr1,'&nbsp;&nbsp;');
						//$rec1->digui(strval($cates_id),0);//将数组所有数据递归分类
						$back_c=$rec1->back;//递归出所有属于此栏目ID的所有数据
                        
						$back='0@ @ !'.$back;//所有栏目数据前加上一个特殊的根目录栏目数组
						//$back_c=$cates_id.'@'.$back_arr['cates_parentid'].'@'.$back_arr['cates_title'].'!'.$back_c;//所有属于此栏目的栏目数组
						if(substr($back,-1)=='!'){
                            $back=substr($back,0,-1);
						}//去掉最后“！”符号

						if(substr($back_c,-1)=='!'){
                            $back_c=substr($back_c,0,-1);
						}

						$arr_b=explode('!',$back);//将所有栏目划分为数组
						$arr_c=explode('!',$back_c);//将所属栏目划分为数组

						include_once'../include/array.php';//删除数组元素
						$arr_b=delete_array($arr_b,$arr_c);//将所有栏目数组中去除掉下属的数组数据
                        
						for($j=0;$j<count($arr_b);$j++){//遍历处理后【出去自己下属的数组数据】的栏目数组数据
							$arr2=explode('@',$arr_b[$j]);//拆分最后的数组数据【这是最底层的一次拆分】
							if($back_arr['cates_id']==intval($arr2[0])){//遍历出每单个数组中的数据，并分别绑定到网页标签元素上
				 ?>
				 <option value="<?php echo $arr2[0]; ?>" selected="true"><?php echo $arr2[2] ;?></option>
				 <?php
							}else{
				 ?>
				 <option value="<?php echo $arr2[0]; ?>"><?php echo $arr2[2] ;?></option>
				 <?php
							}
						}
						unset($rec);
						unset($rec_1);
					}
				 ?>
			  </select>
	</TD></TR>
  <TR>
    <TD height=24 align="right">推荐位：</TD>
    <TD height=24>
		      <select id="positions_id" name="positions_id"/>
				<option value="0">不推荐</option>
				<option value="1">一号推荐位</option>
				<option value="2">二号推荐位</option>
				<option value="3">三号推荐位</option>
				<option value="4">四号推荐位</option>
				<option value="5">五号推荐位</option>
				<option value="6">六号推荐位</option>
				<option value="7">七号推荐位</option>
				<option value="8">八号推荐位</option>
			     <?php
				     if($back_arr['positions_id']==1){
				 ?>
				<option value="1" selected="true">一号推荐位</option>
				 <?php
					 }elseif($back_arr['positions_id']==2){
				 ?>
				<option value="2" selected="true">二号推荐位</option>
				 <?php
					 }elseif($back_arr['positions_id']==3){
				 ?>
				<option value="3" selected="true">三号推荐位</option>
				 <?php
					 }elseif($back_arr['positions_id']==4){
				 ?>
				<option value="4" selected="true">四号推荐位</option>
				 <?php
					 }elseif($back_arr['positions_id']==5){
				 ?>
				<option value="5" selected="true">五号推荐位</option>
				 <?php
					 }elseif($back_arr['positions_id']==6){
				 ?>
				<option value="6" selected="true">六号推荐位</option>
				 <?php
					 }elseif($back_arr['positions_id']==7){
				 ?>
				<option value="7" selected="true">七号推荐位</option>
				 <?php
					 }elseif($back_arr['positions_id']==8){
				 ?>
				<option value="2" selected="true">二号推荐位</option>
				 <?php
					 }else{
				 ?>
				<option value="0" selected="true">不推荐</option>
				 <?php
					 }
				 ?>
			  </select>
			  </TD></TR>
  <TR>
    <TD height=24 align="right">图片：</TD>
    <TD height=24>点击上传  点击添加上传个数<input type="hidden" id="contents_images" name="contents_images" value="">
			  </TD></TR>
  <TR>
    <TD height=24 align="right">falsh动画：</TD>
    <TD height=24>点击上传  点击添加上传个数<input type="hidden" id="contents_flashs" name="contents_flashs" value="">
			  </TD></TR>
  <TR>
    <TD height=24 align="right">视频：</TD>
    <TD height=24>点击上传  点击添加上传个数<input type="hidden" id="contents_videos" name="contents_videos" value="">
			  </TD></TR>
  <TR>
    <TD height=24 align="right">建立下载链接：</TD>
    <TD height=24>
		      <select id="contents_downs" name="contents_downs"/>
			     <?php
				     if($back_arr['contents_downs']==1){
				 ?>
				<option value="1" selected="true">建立</option>
				<option value="0">不建立</option>
				 <?php
					 }else{
				 ?>
				<option value="1">建立</option>
				<option value="0" selected="true">不建立</option>
				 <?php
					 }
				 ?>
			  </select>
			  </TD></TR>
  <TR>
    <TD height=24 align="right">状态：</TD>
    <TD height=24>
		      <select id="contents_status" name="contents_status"/>
			     <?php
				     if($back_arr['contents_status']==1){
				 ?>
                 <option value="1" selected="true">激活</option>
				 <option value="2">关闭</option>
				 <?php
					 }else{
				 ?>
                 <option value="1">激活</option>
				 <option value="2" selected="true">关闭</option>
				 <?php
					 }
				 ?>
			  </select>
			  </TD></TR>
  <TR>
    <TD height=24 align="right">排序：</TD>
    <TD height=24>
		      <select id="contents_sort" name="contents_sort"/>
			     <?php
				     for($i=1;$i<=9;$i++){
						 if($back_arr['contents_sort']==$i){
				 ?>
                 <option value="<?php echo $i;?>" selected="true"><?php echo $i;?></option>
				 <?php
						 }else{
				 ?>
				 <option value="<?php echo $i;?>"><?php echo $i;?></option>
				 <?php
						 }
					 }
				 ?>
			  </select>1-9 ,9最大，最靠前
			  </TD></TR>
  <TR>
    <TD height=24 align="right">联系方式：</TD>
    <TD height=24>
			  <input type="text" id="contents_connect" name="contents_connect" value="<?php echo empty($back_arr['contents_connect'])?'':$back_arr['contents_connect']; ?>"/><font color="red">( * 必填 )</font>
			  </TD></TR>
  <TR>
    <TD height=24 align="right">内容来源：</TD>
    <TD height=24>
			  <input type="text" id="contents_resource" name="contents_resource" value="<?php echo empty($back_arr['contents_resource'])?'':$back_arr['contents_resource']; ?>"/><font color="red">( * 必填 )</font>
			  </TD></TR>
  <TR>
    <TD height=24 align="right"></TD>
    <TD height=24>
		  <input type="hidden" id="contents_hits" name="contents_hits" value="<?php echo empty($back_arr['contents_hits'])?'0':$back_arr['contents_hits']; ?>" />
		  <input type="hidden" id="contents_recive" name="contents_recive" value="<?php echo empty($back_arr['contents_recive'])?'0':$back_arr['contents_recive']; ?>" />
		  <input type="hidden" id="contents_adduserid" name="contents_adduserid" value="<?php echo empty($back_arr['contents_adduserid'])?'':$back_arr['contents_adduserid']; ?>" />
		  <input type="hidden" id="contents_addtime" name="contents_addtime" value="<?php echo empty($back_arr['contents_addtime'])?'':$back_arr['contents_addtime']; ?>" />
		  <input type="hidden" id="contents_url" name="contents_url" value="<?php echo empty($back_arr['contents_url'])?'':$back_arr['contents_url']; ?>" />
		  <input type="hidden" id="contents_remark1" name="contents_remark1" value="" />
		  <input type="hidden" id="contents_remark2" name="contents_remark2" value="" />
		  <input type="hidden" id="contents_remark3" name="contents_remark3" value="" />
			  <input type="submit" id="contents" name="contents" value="提交"/>&nbsp;&nbsp;&nbsp;&nbsp;
			  <input type="reset" id="reset" name="reset" value="重置"/>
			  </TD></TR>
  </TBODY></TABLE>
  </form>
</BODY></HTML>
