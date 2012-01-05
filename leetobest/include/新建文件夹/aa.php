<?php

define("GIF",1);

define("JPG",2);

define("PNG",3);

/**

$src_file     sourse file

$dest_file dest file

$new_size     array('width'=>?,'height'=?)

$quantity     the quantity of desc

$method     gd1.0 or gd2.0

**/

function ResizeImage($src_file="", $dest_file="", $new_size=array('width'=>100,'height'=>78), $quantity="80",$method="gd2")

{

             //get infomation of iamge

             /*

             0 => width

             1 => height

             2 => 1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP，7 = TIFF(intel byte order)，8 = TIFF(motorola byte order)，9 = JPC，10 = JP2，11 = JPX，12 = JB2，13 = SWC，14 = IFF，15 = WBMP，16 = XBM

             3 => height="yyy" width="xxx"

             */

             $imginfo = getimagesize($src_file);

             if ($imginfo == null)

                     return false;



             // GD can only handle JPG & PNG images

             if ($imginfo[2] != JPG && $imginfo[2] != PNG && $inginfo[2] != GIF && ($method == 'gd1' || $method == 'gd2')){

                     die("file is not be supported");

                     return false;

             }

             $srcWidth = $imginfo[0];

             $srcHeight = $imginfo[1];



             $radio=max(($srcWidth/$new_size['width']),($srcHeight/$new_size['height']));

             $destWidth=(int)$srcWidth/$radio;

             $destHeight=(int)$srcHeight/$radio;



             switch ($method) {

             case "gd1" :

                     if (!function_exists('imagecreatefromjpeg')) {

                             die("PHP running on your server does not support the GD image library");

                     }

                     if ($imginfo[2] == JPG)

                                 $src_img = imagecreatefromjpeg($src_file);

                     elseif($imginfo[2] == PNG)

                                 $src_img = imagecreatefrompng($src_file);

                    else $src_img = imagecreatefromgif($src_file);

                     if (!$src_img){

                                 return false;

                     }

                     $dst_img = imagecreate($destWidth, $destHeight);

                     imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $destWidth, (int)$destHeight, $srcWidth, $srcHeight);

                     imagejpeg($dst_img, $dest_file, $quantity);

                     imagedestroy($src_img);

                     imagedestroy($dst_img);

                     break;



             case "gd2" :

                     // check if support GD2

                     if (!function_exists('imagecreatefromjpeg')) {

                             die("PHP running on your server does not support the GD image library");

                     }

                     if (!function_exists('imagecreatetruecolor')) {

                             die("PHP running on your server does not support GD version 2.x, please change to GD version 1.x on your method");

                     }

                     if ($imginfo[2] == JPG)

                                 $src_img = imagecreatefromjpeg($src_file);

                     elseif($imginfo[2] == PNG)

                                 $src_img = imagecreatefrompng($src_file);

                    else $src_img = imagecreatefromgif($src_file);

                     if (!$src_img){

                                 return false;

                     }

                     $dst_img = imagecreatetruecolor($destWidth, $destHeight);

                     imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $destWidth, (int)$destHeight, $srcWidth, $srcHeight);

                     imagejpeg($dst_img, $dest_file, $quantity);

                     imagedestroy($src_img);

                     imagedestroy($dst_img);

                     break;

             }

             // Set mode of uploaded picture

             chmod($dest_file, 0755);



             // We check that the image is valid

             $imginfo = @getimagesize($dest_file);

             if ($imginfo == null){

                     @unlink($dest_file);

                     return false;

             } else {

                     return true;

             }

}

?> 