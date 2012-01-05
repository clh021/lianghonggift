<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>{% $title %}</title>
</head>
<body>
使用foreach语句循环输出数组。<p>
{% foreach key=key item=item from=$infobook %}
{% $key %} => {% $item %}<br />
{% /foreach %}
</body>
</html>
