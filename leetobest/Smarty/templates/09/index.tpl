<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>{% $title %}</title>
</head>
<body>
{% if $smarty.get.type == 'mr' %}
欢迎光临，{% $smarty.get.type %}
{% else %}
对不起，您不是本站VIP，无权访问此栏目。
{% /if %}
</body>
</html>
