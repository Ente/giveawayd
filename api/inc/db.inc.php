<?php
#ini_set("display_errors", 1);
date_default_timezone_set("Europe/Berlin");

$db = "giveaway";
$db_username = "root";
$db_password = "";
$db_host = "localhost";

ob_start();
require_once "discord.inc.php";
ob_end_flush();


$conn = mysqli_connect($db_host, $db_username, $db_password, $db);
if(mysqli_connect_error()) {
     die(mysqli_connect_error());
};

@session_start();
function checkID() {
    if(@$_SESSION["access_token"]) {
        global $apiURLBase;
        global $conn;
        $user = apiRequest($apiURLBase);
        $id = $user->id;
        $sql = "SELECT id FROM users WHERE id = '$id';";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        $_SESSION["id"] = $user->id;

        if($count == 1) {
            return $_SESSION["log_checkid"] = true;
        } else {
            header("Location: /api/v1/registerUser.php");
        }
    } else {
        return false;
        #header("Location: /api/discord_login.php");
    }
};

function data($user_id){
    global $conn;
    $sql = "SELECT * FROM users WHERE id = '$user_id';";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if($count == 1){
        $data = mysqli_fetch_assoc($res);
        return json_encode($data);
    }
};

function check_user(int $id, int $l_id = null){
    global $conn;
    $sql = "SELECT * FROM users WHERE id = '$id';";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if($count == 1){
        if($id == $l_id){
            return true;
        } else {
            return false;
        }
    }
}

?>