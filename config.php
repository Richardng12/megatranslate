<?php

/**
 * Configuration for database connection
 *
 */

$host       = "localhost";
$username   = "root"; //change this depending on local
$password   = "root"; //change this depending on local - move to env variables later
$dbname     = "translationmapping";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
