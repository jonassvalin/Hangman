<?php session_start();
include_once 'initializationPage.php';
include_once 'updatePage.php';

/**
* Checks if it's time to initialize or update the page. Launches the
* correct page accordingly.
*/
$requestedPage = $_SESSION["page"];
switch($requestedPage) {
  case("initialize"):
  $_SESSION["page"] = "update";
  new initializationPage();
  break;
  case("update");
  $_SESSION["page"] = "update";
  new updatePage();
  break;
}

?>
