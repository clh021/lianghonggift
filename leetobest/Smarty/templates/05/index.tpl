<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>{% $title %}</title>
</head>
<body>
原文：{% $str %}
<p>
变量中的字符数（包括空格）：{% $str|count_characters:true %}
<br />
使用变量修饰方法后：{% $str|nl2br|upper %}

</body>
</html>
