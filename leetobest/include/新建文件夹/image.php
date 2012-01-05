<?php
    /*
	* 对图片的处理
	*/

	/*
	* 生成缩略图
	*
	* oldImge--原来的图--最好有完整路径
	* new_Pre--新的图片文件前缀
	* path---路径
	* new_width--新图片的宽
	* new_width--新图片的高
	* method--生成图片的方法
	*/
	function thumb($oldImge='',$new_Pre='',$path='',$new_width=0,$new_height=0,$method='gd2'){
	  $flag=false;
	  if(file_exists(FILE_PATH.$oldImge)){//判断文件是否存在---FILE_PATH(在include/config.php文件里定义的常量)
	      $oldImge=basename($oldImge);//给出一个包含有指向一个文件的全路径的字符串
	      $imginfo = getimagesize($oldImge);//测定任何 GIF，JPG，PNG，SWF，SWC，PSD，TIFF，BMP，IFF，JP2，JPX，JB2，JPC，XBM 或 WBMP 图像文件的大小并返回图像的尺寸以及文件类型
		  //返回一个具有四个单元的数组。索引 0 包含图像宽度的像素值，索引 1 包含图像高度的像素值。索引 2 是图像类型的标记：1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP，7 = TIFF(intel byte order)，8 = TIFF(motorola byte order)，9 = JPC，10 = JP2，11 = JPX，12 = JB2，13 = SWC，14 = IFF，15 = WBMP，16 = XBM。索引 3 是文本字符串，内容为“height="yyy" width="xxx"”
		  if(!@empty($imginfo)){
			  $srcWidth = $imginfo[0];
              $srcHeight = $imginfo[1];
              $radio=max(($srcWidth/$new_width),($srcHeight/$new_height));
              $destWidth=(int)$srcWidth/$radio;
              $destHeight=(int)$srcHeight/$radio;

              if($imginfo[2]==2){
				  $source=@imagecreatefromjpeg($oldImge);//jpg
			  }else if($imginfo[2]==3){
				  $source=@imagecreatefrompng($oldImge);//png
			  }else{
				  $source=@imagecreatefromgif($oldImge);//gif图片
				  //$source=@imagecreatefrompng($oldImge);//php不能生成bmp图片
			  }

              $path=empty($path)?FILE_PATH:$path;//FILE_PATH(在include/config.php文件里定义的常量)
			  $new_Pre=empty($new_Pre)?'thumb_':$new_Pre;
			  $new_img=$path.$new_Pre.$oldImge;

			  if(!@empty($source) && @is_resource($source)===true){
				  switch($method){
					  case "gd1" :
						   $dst_img = imagecreate($destWidth, $destHeight);///创建画布，imagecreate是新建一个调色板的图像,imagecreate()是GD1库的
                  
						  //拷贝部分图像并调整大小。将一幅图像中的一块正方形区域拷贝到另一个图像中。属于GD1库
						  imagecopyresized($dst_img, $source, 0, 0, 0, 0, $destWidth, (int)$destHeight, $srcWidth, $srcHeight);//复制图片
                          if($imginfo[2]==3){
							  imagepng($dst_img,$new_img);//以 png 格式将图像输出到浏览器或文件
						  }else if($imginfo[2]==2){
							  imagejpeg($dst_img,$new_img , '80');//以 JPEG 格式将图像输出到浏览器或文件，后面的80是透明度
						  }else{
							  imagegif ($dst_img,$new_img);//以 gif 格式将图像输出到浏览器或文件
						  }

						  chmod($new_img, 0755);//赋权限

						  imagedestroy($dst_img);//销毁画布

						  $flag=true;//返回值
						  break;

					  case "gd2" :
						  $dst_img = imagecreatetruecolor($destWidth, $destHeight);//创建画布---imagecreatetruecolor是新建一个真彩色的图像。imagecreatetruecolor是GD2库的
                  
						  //imagecopyresampled---重采样拷贝部分图像并调整大小。将一幅图像中的一块正方形区域拷贝到另一个图像中，平滑地插入像素值，因此，尤其是，减小了图像的大小而仍然保持了极大的清晰度，属于GD2库
						  imagecopyresampled($dst_img, $source, 0, 0, 0, 0, $destWidth, (int)$destHeight, $srcWidth, $srcHeight);//复制图片
                          if($imginfo[2]==3){
							  imagepng($dst_img,$new_img);//以 png 格式将图像输出到浏览器或文件
						  }else if($imginfo[2]==2){
							  imagejpeg($dst_img,$new_img , '80');//以 JPEG 格式将图像输出到浏览器或文件
						  }else{
							  imagegif ($dst_img,$new_img);//以 gif 格式将图像输出到浏览器或文件
						  }

						  chmod($new_img, 0755);//赋权限

						  imagedestroy($dst_img);//销毁画布

						  $flag=true;//返回值
						  break;
					  default:
                          break;
				  }
			  }
		  }
	  }

      return $flag;
	}
    
	/*
	* 生成验证码
	* str--为要生成验证码的随机数
    * width--宽度
	* height--高度
	*/
	function checkcode($str='',$width=0,$height=0){
	   if(strlen($str)<=0){
		   echo "<script>alert('随机数字符串没有值');</script>";
		   return;
	   }

	   if($width<=0){
		   echo "<script>alert('验证码宽度值不对');</script>";
		   return;
	   }

	   if($height<=0){
		   echo "<script>alert('验证码高度值不对');</script>";
		   return;
	   }

       $rand_img = imagecreatetruecolor($width, $height);//创建一个图像
	   $col=imagecolorallocate($rand_img,240,240,240);//为图像分配颜色
	   imagefill($rand_img,0,0,$col);//区域填充
	   /*
	   * 循环生成图片文字
	   */
	   for($i=0;$i<strlen($str);$i++){
		   //mt_rand比rand执行效率快
		   $x=mt_rand(1,8)+$width*$i/4;//设置文字左上角x坐标
		   $y=mt_rand(1,$height);//设置文字左上角y坐标
		   $font_color=imagecolorallocate($rand_img,mt_rand(0,150),mt_rand(0,150),mt_rand(0,150));//设置文字颜色
		   imagestring($rand_img,5,$x,$y,$str[$i],$font_color);//写入文字--imageline()-画线
	   }
       
	   //生成干扰码
	   for($i=0;$i<200;$i++){
		   $rand_color=imagecolorallocate($rand_img,rand(200,255),rand(200,255),mt_rand(200,255));//设置文字颜色
		   imagesetpixel($rand_img,rand()%70,rand()%20,$rand_color);
	   }
	   imagepng($rand_img,'rand.jpg');//生成图像
	   imagedestroy($rand_img);//销毁画布
	   return 'rand.jpg';
	}

	//$file='pic4145.jpg';
    //thumb($file,'thumb_','',500,500,'gd1');
	//checkcode('Ac56',60,40);
?>