<?php

require 'vendor/autoload.php';

use Spatie\Browsershot\Browsershot;

$html = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body{
    font-family:Arial;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    background:#f4f4f4;
}
.box{
    width:900px;
    padding:40px;
    border:5px solid #1e3a8a;
    text-align:center;
}
h1{
    color:#1e3a8a;
}
</style>
</head>

<body>

<div class="box">
    <h1>EduTech</h1>
    <h2>Browsershot funcionando correctamente</h2>
    <p>Si ves este PDF, ya no volveremos a usar Dompdf.</p>
</div>

</body>
</html>
';

Browsershot::html($html)
    ->setNodeBinary('C:\Program Files\nodejs\node.exe')
    ->setChromePath('C:\Program Files\Google\Chrome\Application\chrome.exe')
    ->showBackground()
    ->landscape()
    ->format('A4')
    ->save('prueba.pdf');

echo "PDF generado correctamente";