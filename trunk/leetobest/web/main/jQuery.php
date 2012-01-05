<?php
   $username = @trim($_REQUEST["username"]);
   $content = @trim($_REQUEST["content"]);
   //$back="<div class='comment'><h6>张三：</h6><span class='para'>沙发。</span><div>";
   $back="<div class='comment'><h6>".$username."</h6><span class='para'>".$content."。</span><div>";
   echo $back;
?>