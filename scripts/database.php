<?php

$db_server = "srv850.hstgr.io";
$db_user = "u967403313_guramee";
$db_pass = ":6Xf\$wEBt";
$db_name = "u967403313_sql_minecraft";

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

try {
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
} catch (mysqli_sql_exception) {
    console_log("Could not connect to the database.");
}

if ($conn) {
    console_log("You are connected to the database.");
} else console_log("Could not connect to the database.");
