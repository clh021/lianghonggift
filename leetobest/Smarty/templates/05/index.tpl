<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>{% $title %}</title>
</head>
<body>
ԭ�ģ�{% $str %}
<p>
�����е��ַ����������ո񣩣�{% $str|count_characters:true %}
<br />
ʹ�ñ������η�����{% $str|nl2br|upper %}

</body>
</html>