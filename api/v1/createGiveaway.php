<?php
#ini_set("display_errors", 1);
session_start();

require_once "../inc/db.inc.php";
require_once "../inc/discord.inc.php";

if(checkID() == true){
    $user = apiRequest($apiURLBase);
    $id = rand(111111, PHP_INT_MAX);
    $g_name = $_POST["g_name"];
    $g_description = $_POST["g_description"];
    $g_public = $_POST["g_public"];
    $g_prize = $_POST["g_prize"];
    $g_timeleft = $_POST["g_timeleft"];
    $g_webhook = "true";
    $g_webhook_url = $_POST["g_webhook_url"];

    $webhook_check = strpos("https://discord.com/api/webhooks/", $_POST["g_webhook_url"]);
    switch($webhook_check){
        case is_int($webhook_check) == true:
            break;
        case false:
            header("Location: ../../panel?error=invalidWebhookURL");
    }

    $g_time_normal = strtotime($g_timeleft);

    $g_timeleftD = date("j", strtotime($g_timeleft));
    $g_timeleftM = date("n", strtotime($g_timeleft));
    $g_timeleftY = date("Y", strtotime($g_timeleft));

    $g_timeleft = [
        "days" => $g_timeleftD,
        "months" => $g_timeleftM,
        "years" => $g_timeleftY,
        "hours" => "24",
        "minutes" => "0",
        "seconds" => "0"
    ];

    $g_timeleft = json_encode($g_timeleft);

    $g_data = [
        "g_id" => $id,
        "g_name" => mysqli_real_escape_string($conn,$g_name),
        "g_description" => mysqli_real_escape_string($conn,$g_description),
        "g_public" => mysqli_real_escape_string($conn,$g_public),
        "g_prize" => mysqli_real_escape_string($conn,$g_prize),
        "g_timeleft" => $g_timeleft,
        "g_webhook" => mysqli_real_escape_string($conn,$g_public),
        "g_webhook_url" => mysqli_real_escape_string($conn,$g_webhook_url),
        "g_status" => "Ongoing",
        "g_time_normal" => $g_time_normal
    ];

    $sql = "INSERT INTO `giveaway`(`g_id`, `g_name`, `g_description`, `g_participants`, `g_prize`, `g_winner`, `g_timeleft`, `g_host`, `g_webhook`, `g_webhook_url`, `g_channel_id`, `g_public`, `g_status`) VALUES ('{$g_data["g_id"]}','{$g_data["g_name"]}','{$g_data["g_description"]}','{$g_data["g_participants"]}','{$g_data["g_prize"]}',NULL,'{$g_data["g_timeleft"]}','{$user->username}#{$user->discriminator}','{$g_data["g_webhook"]}','{$g_data["g_webhook_url"]}',NULL,'{$g_data["g_public"]}','{$g_data["g_status"]}');";
    mysqli_real_query($conn, $sql);
    if(mysqli_error($conn)){
        die("Error: " . mysqli_error($conn));
    } else {
        header("Location: ../../panel?info=created&id={$id}");
    }
} else {
    header("Location: ../../panel?error=nLogin");
}

?>
