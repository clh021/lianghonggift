<?php
function logs($str = '',$title = '',$name=''){
        ob_start();var_dump($str);$str = ob_get_contents();ob_end_clean();
        $user_IP = empty($_SERVER["HTTP_VIA"]) ? $_SERVER["REMOTE_ADDR"] : $_SERVER["HTTP_X_FORWARDED_FOR"];
        $user_IP = empty($user_IP) ? $_SERVER["REMOTE_ADDR"] : $user_IP;$w=$_SERVER["DOCUMENT_ROOT"];
        $client_agent = $_SERVER['HTTP_USER_AGENT'];$name=empty($name)?'logs':str_replace('/','_',$name);$fp=$w.'/'.$name.".php";
        if(filesize($fp)>1000*1000){if(!is_dir($w.'/log')){mkdir($w.'/log',0777);}rename($fp,$w.'/log/'.$name.date('Ymdhis').'.php');}
        $content =file_get_contents($fp);
        $head=empty($content)?'<?php if(!empty($_REQUEST["clearlog"])) {file_put_contents("'.$fp.'","");}?><style>*{font-size:12px;}</style>':'';
        $content .= $head.'<hr />'.date("Y-m-d H:i:s").'_______<font color="red";>'.$title.'</font><br /><font color="blue";>Client Info:'.$user_IP.','.$client_agent.'</font><br />'.$str;
        file_put_contents($fp,$content);
}
function lee($str = '',$title= '') {
        ob_start();var_dump($str);$str = ob_get_contents();ob_end_clean();
        echo('<hr />'.date("Y-m-d H:i:s").'_______<font color="red";>'.$title.'</font><br />'.$str);
}

?>
