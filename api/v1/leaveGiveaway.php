<?php

require $_SERVER["DOCUMENT_ROOT"] . "/api/inc/giveawayd.php";
require $_SERVER["DOCUMENT_ROOT"] . "/api/inc/api.giveawayd.php";
ob_start();
require $_SERVER["DOCUMENT_ROOT"] . "/api/discord_login.php";
ob_end_flush();
require $_SERVER["DOCUMENT_ROOT"] . "/api/inc/discord.inc.php";

use GiveawayD\GiveawayD;
use GiveawayD\api;

global $apiURLBase;
$id = apiRequest($apiURLBase)->id ?? null;
$g_id = $_POST["g_id"] ?? null;

if($id == null || $g_id == null){
    header("Location: /?error=missing_ids");
}

$api = new api(new GiveawayD);
if($api->leaveGiveaway($id, $g_id))


?>