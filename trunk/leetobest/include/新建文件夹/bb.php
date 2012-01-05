<?php
    header("content-type:text/html;charset=utf-8");

	$width=200;
	$height=200;
	$im=imagecreatetruecolor($width,$height);//创建一个背景色--或者说创建一个画布---返回一个资源值
	$white=imagecolorallocate($im,255,255,255);//设置颜色
	$blue=imagecolorallocate($im,0,0,64);//设置颜色
	imagefill($im,0,0,$blue);//区域填充
	imageline($im,0,0,$width,$height,$white);//画线
	imagestring($im,4,50,150,'Sales',$white);//填充文字
	header("content-type:image/png");//输出
	imagepng($im);
	imagedestroy($im);//销毁资源
?>