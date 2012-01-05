{% config_load file="04/04.conf" %}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>{% #title# %}</title>
</head>
<body bgcolor="{% #bgcolor# %}">
<table border="{% #border# %}">
<tr>
	<td>{% $smarty.config.type %}</td>
	<td>{% $smarty.config.name %}</td>
</tr>
</table>

</body>
</html>
