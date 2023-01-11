<?php
#ini_set("display_errors", 1);
require_once "../inc/db.inc.php";
require_once '../inc/discord.inc.php';


$user = apiRequest($apiURLBase);

if(isset($user) || isset($_GET["id"])){
  if($user->id == $_GET["id"]){
  $sql = "DELETE FROM `users` WHERE id = " . $user->id;
  $res = mysqli_query($conn, $sql);
  print_r(mysqli_affected_rows($conn)); die();
  if(mysqli_error($conn)){
    echo "1";
    die("Error: " . mysqli_error($conn));
  } else {
    #echo $sql; die();
    session_unset();
    header("Location: ../../?info=account_deleted");
  }
  } else {
    die("You are not authorized to do that! This has been reported");
  }
} else {
  echo "no id set!";
}



?>
