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
购书信息：<p>
{% *  使用索引取得数组的第一个元素值  * %}
图书类别：{% $arr[0] %}<br />
{%*  使用键值取得第二个数组元素值  *%}
图书名称：{% $arr.name %}<br />
{%*  使用键值取得二维数组的元素值  *%}
图书单价：{% $arr.unit_price.price %}/{% $arr.unit_price.unit %}
</body>
</html>
