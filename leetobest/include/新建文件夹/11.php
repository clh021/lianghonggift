<?php
   //$img='pic4145.jpg';
   //header("Content-Type: image/jpeg");
   //header("Content-Disposition: attachment; filename=$img"); // THIS ONE

   $data = 'iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABl'
       . 'BMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDr'
       . 'EX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r'
       . '8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==';
$data = base64_decode($data);

$im = imagecreatefromstring($data);
if ($im !== false) {
    header('Content-Type: image/png');
    imagepng($im);
}
else {
    echo 'An error occured.';
}
$str='A1dc';
for($i=0;$i<strlen($str);$i++){
	echo $str[$i].'<br>';
}

?>
