<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>{% $title %}</title>
</head>
<body>
<table width="100" border="0" align="left" cellpadding="0" cellspacing="0">
{% section name=sec1 loop=$obj %}
    <tr>
        <td colspan="2">{% $obj[sec1].bigclass %}</td>
    </tr>
    {% section name=sec2 loop=$obj[sec1].smallclass %}
    <tr>
        <td width="25">&nbsp;</td>
        <td width="75">{% $obj[sec1].smallclass[sec2].s_type %}</td>
    </tr>
    {% /section %}
{% /section %}
</table>
</body>
</html>
