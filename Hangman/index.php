<?php
session_unset();
session_start();
include_once 'startPage.php';

/**
* Starts the session and launches the startPage
*/
$_SESSION["page"] = "initialize";
new startPage();

?>
