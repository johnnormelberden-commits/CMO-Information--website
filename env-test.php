<?php

echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '<title>Railway Environment Test</title>';
echo '</head>';

echo '<body style="
    background:#0d1117;
    color:white;
    font-family:Arial;
    padding:40px;
">';

echo '<h1 style="color:#58a6ff;">Railway Environment Test</h1>';

echo '<p>Testing whether the CMO INFORMATION WEBSITE can see the MySQL variables.</p>';

echo '<hr>';

$variables = [
    'MYSQLHOST',
    'MYSQLPORT',
    'MYSQLUSER',
    'MYSQLPASSWORD',
    'MYSQLDATABASE',
    'MYSQL_DATABASE',
    'PORT'
];

foreach ($variables as $variable) {

    $value = getenv($variable);

    echo '<p>';

    echo '<strong>' . htmlspecialchars($variable) . ':</strong> ';

    if ($value === false || trim($value) === '') {

        echo '<span style="color:#ff6b6b;">MISSING</span>';

    } else {

        // Never display the actual password
        if ($variable === 'MYSQLPASSWORD') {

            echo '<span style="color:#00ff88;">FOUND</span>';

        } else {

            echo '<span style="color:#00ff88;">FOUND</span>';
        }
    }

    echo '</p>';
}

echo '</body>';
echo '</html>';

?>
