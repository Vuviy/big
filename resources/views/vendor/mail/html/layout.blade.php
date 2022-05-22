<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css">
    {{ file_get_contents(resource_path('views/vendor/mail/html/themes/media.css')) }}
</style>
<!--[if (mso)|(mso 16)]>
<style type="text/css">
    {{ file_get_contents(resource_path('views/vendor/mail/html/themes/mso.css')) }}
</style>
<![endif]-->
</head>
<body>
<div class="es-wrapper-color">
<!--[if gte mso 9]>
<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
    <v:fill type="tile" color="#f6f6f6"></v:fill>
</v:background>
<![endif]-->
<table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td valign="top">
{{-- Header --}}
{{ $header ?? '' }}
{{-- Menu --}}
{{ $menu ?? '' }}
{{-- Email Body --}}
{{ Illuminate\Mail\Markdown::parse($slot) }}
{{-- Subcopy --}}
{{ $subcopy ?? '' }}
{{-- Footer --}}
{{ $footer ?? '' }}
</td>
</tr>
</table>
</div>
</body>
</html>
