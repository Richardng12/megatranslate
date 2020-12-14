<?php
$db_host = "localhost"; //change this depending on local
$db_name = "translationmapping"; //change this depending on local 
$db_user = "root";
$db_pass = "root";
$db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
