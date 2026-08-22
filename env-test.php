<?php

header('Content-Type: text/plain');

$variables = [
    'MYSQLHOST',
    'MYSQLPORT',
    'MYSQLUSER',
    'MYSQLPASSWORD',
    'MYSQLDATABASE'
];

foreach ($variables as $variable) {
    $value = getenv($variable);

    if ($variable === 'MYSQLPASSWORD') {
        echo $variable . ': ' .
            (($value !== false && $value !== '') ? 'FOUND' : 'MISSING') .
            PHP_EOL;
    } else {
        echo $variable . ': ' .
            (($value !== false && $value !== '') ? 'FOUND' : 'MISSING') .
            PHP_EOL;
    }
}
