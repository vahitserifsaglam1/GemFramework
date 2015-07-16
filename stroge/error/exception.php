<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>İstisna : {{ message }} </title>
</head>
<body>

<h1 style="font-family:Open Sans, sans-serif;">GemFramework Uygulama İstinası</h1>
<hr/>
<b>{{ file }} Dosyasında Bir İstisna Yakalandı:</b>
<hr/>
<pre>Mesaj : {{ message }}</pre>
<hr/>
Satır : {{ line }}
<hr/>
Hata Kodu : {{ code }}
<hr/>

<p><h4>Trace:</h4></p>
{{ trace }}
</body>
</html>
