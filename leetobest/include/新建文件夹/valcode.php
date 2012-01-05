<?php
    header("content-type:text/html;charset=utf-8");
	$num=$_REQUEST['num'];
	include('image.php');
	$back=checkcode($num,40,30);
    echo $back;
?>