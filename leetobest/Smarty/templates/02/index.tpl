<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<style>
	body{
		margin:12px;
		font-size: 12px;
		text-align: center;
	}

</style>
<title>{% $title %}</title>
</head>
<body>
������Ϣ��<p>
{% *  ʹ������ȡ������ĵ�һ��Ԫ��ֵ  * %}
ͼ�����{% $arr[0] %}<br />
{%*  ʹ�ü�ֵȡ�õڶ�������Ԫ��ֵ  *%}
ͼ�����ƣ�{% $arr.name %}<br />
{%*  ʹ�ü�ֵȡ�ö�ά�����Ԫ��ֵ  *%}
ͼ�鵥�ۣ�{% $arr.unit_price.price %}/{% $arr.unit_price.unit %}
</body>
</html>
