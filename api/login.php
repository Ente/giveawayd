<?php
require $_SERVER["DOCUMENT_ROOT"] . "/api/inc/db.inc.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/inc/discord.inc.php";

session_start();

if(isset($_SESSION["access_token"])) {
    header("Location: ../panel");
} else {
    header("Location: ../");
}

?>