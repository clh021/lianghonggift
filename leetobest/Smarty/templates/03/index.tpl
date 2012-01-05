<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>{% $title %}</title>
</head>
<body>
{%*  使用get变量获取url中的变量值(ex: http://localhost/model/04/03/index.php?type=computer)  *%}
变量type的值是：{% $smarty.get.type %}<br />
当前路径为：{% $smarty.server.PHP_SELF %}<br />
当前时间为：{% $smarty.now %}

</body>
</html>
