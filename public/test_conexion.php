<?php

$enlace = mysql_connect('localhost', 'molina', '893jmd86Yd');
if  (!$enlace) {
    die('No pudo conectarse: ' . mysql_error());
} else echo 'Conexión';
