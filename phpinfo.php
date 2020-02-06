<?php

$mysqli = new mysqli('localhost', 'root', 'asdf2262', 'information_schema');

if ($mysqli->connect_errno) {

    die('Connection Error ('.$mysqli->connect_errno.'): '.

    $mysqli->connect_error);

} else {

    echo ("DB Connected!");

}

    phpinfo();
?>
