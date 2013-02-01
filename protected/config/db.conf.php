<?php
$db = array(
    'connectionString' => 'mysql:host=localhost;dbname=template',
    'emulatePrepare' => true,
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'tablePrefix' => 'tb_',
);
if( YII_DEBUG )
{
    $db_debug = array(
        'enableProfiling' => true,
        'enableParamLogging' => true,
    );

    $db = array_merge($db, $db_debug);
}

return $db;