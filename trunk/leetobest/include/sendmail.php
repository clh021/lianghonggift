<?
header("content-type:text/html;charset=utf-8");
require_once ('email.class.php');
//##########################################
$smtpserver = "smtp.qq.com";//"smtp.sina.com";//SMTP服务器
$smtpserverport =25;//SMTP服务器端口
$smtpusermail = "565262366@qq.com";//"liusy1223r@sina.com";//SMTP服务器的用户邮箱
$smtpemailto = "309820453@qq.com";//"565262366@qq.com";//发送给谁
$smtpuser = "565262366@qq.com";//"liusy1223r@sina.com";//SMTP服务器的用户帐号
$smtppass = "123";//"";//SMTP服务器的用户密码
$mailsubject = iconv("utf-8","gbk","PHP100测试邮件系统");//邮件主题
$mailbody = iconv("utf-8","gbk","<h1> 这是一个测试程序 PHP100.com </h1>");//邮件内容
$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
##########################################
$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
$smtp->debug = FALSE;//是否显示发送的调试信息
$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);

?>