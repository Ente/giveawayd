<!DOCTYPE html>
<html lang="en">
<?php

require_once "api/inc/db.inc.php";

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>GiveawayD - Simple Giveaway Website with Discord Integration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap">
    <link rel="stylesheet" href="assets/css/styles.min.css?h=5e45cf66b170e84f294a29a109b64069">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
        <div class="container"><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/support">Support</a></li>
                    <li class="nav-item"><a class="nav-link invisible" href="panel">Panel</a></li>
                </ul><span class="navbar-text actions"> <a class="login" href="<?php if(isset($_SESSION["access_token"]) == true){ checkID(); echo "/panel";} else { echo "api/discord_login.php";}  ?>"><?php if(isset($_SESSION["access_token"]) == true){ echo "Panel";} else { echo "Log In";};    ?></a><a class="btn btn-light action-button" role="button" href="<?php if(checkID()){ echo "/api/logout.php"; } else { echo "/api/login.php";}  ?>"><?php if(checkID()){ echo "Sign out";} else { echo "Sign up"; };   ?></a></span>
            </div>
        </div>
    </nav>
    <div class="justify-content-center text-center">
        <h1 style="font-family: Lato, sans-serif;">🎉 GiveawayD 🎉<br></h1>
    </div>
    <?php 
if(!isset($_GET["id"])){
    echo <<< D
    <div class="justify-content-center text-center">
        <h1>Create your own Giveaways!</h1>
        <p>Just login/signup and get started.</p><img src="assets/img/duckdance.gif?h=566f1e69e7e82e433a52524f23859501">
    </div>
D;
};

?>
    <?php 

if(isset($_GET["id"])){
    $g_id = $_GET["id"];
    $sql = "SELECT * FROM giveaway WHERE g_id = '{$g_id}';";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    if($count == 1){
        $data = mysqli_fetch_assoc($res);
        $g_found = 1;

        if($data["g_public"] == "false"){
            $data["g_participants"] = "The giveaway participants list is private.";
            
        } else {
            $g1 = 1;
            foreach((array) json_decode($data["g_participants"]) as $name => $id){
               if($g1 == 1){
                $num = count(json_decode($data["g_participants"], true));
                if(is_null($num) || $num == FALSE){
                    $num = "None";
                }

                if($num == 1){
                    $data["g_participants"] = "$name";
                } else {
                    $data["g_participants"] = "$name,";
                }
                $g1 = 0;
               } else {
                $data["g_participants"] .= " $name,";
               }
            }
        }
    } else {
        $g_found = 0;
    }
} else {
    $g_found = 0;
};


if($g_found == 1){
    $time = json_decode($data["g_timeleft"], true);
    $json_date = json_encode([
        "hours" => "{$time["hours"]}",
        "minutes" => "{$time["minutes"]}",
        "seconds" => "{$time["seconds"]}",
        "days" => "{$time["days"]}",
        "months" => "{$time["months"]}",
        "years" => "{$time["years"]}"
    ]);

    $json_date1 = urlencode($json_date);
    
    echo <<< DATA
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="text-center"><strong>Giveaway</strong>: {$time["days"]}.{$time["months"]}.{$time["years"]} - {$data["g_name"]}</p></div></div>
                <div class="row"><div class="col-md-6"><p>Participants: {$num}
                    <br>Status: {$data["g_status"]} | Is Public: {$data["g_public"]}</p></div>
                    <div class="col-md-6"><p><strong>Participants List</strong>:<br>{$data["g_participants"]}</p></div></div>
                </div><h1 class="text-center">Prize: {$data["g_prize"]}</h1><h1 class="text-center">Time left: <script type="text/javascript">
                var auto_refresh = setInterval(
                function () {
                    $('#div').load('api/v1/getTimer.php?time={$json_date1}');
                }, 1000);
                </script><div id="div">Loading...</h1>
DATA;
            }

require_once "api/inc/giveawayd.php";
use GiveawayD\GiveawayD;
$ga = new GiveawayD;
global $apiURLBase;
$user = apiRequest($apiURLBase);
$uid = $user->id;
#if(check_user($uid, $uid)){

    $leave = <<< DAT
<form action="/api/leaveGiveaway" method="POST" name="lvGw" hidden>
    <input name="g_id" value="{$g_id}"> 
</form>
<p>Or <a href="#" onclick="document.forms['lvGw'].submit();">leave</a>.</p>
DAT;

if(@$ga->check_giveaway(@$g_id)){
    if(@$ga->check_participant(@$g_id)){
        echo "<p style='text-align: center;color: blue;'>Already participant in this giveaway!</p>";
        echo $leave;
    } else {
        echo "<p>No participant of the giveaway</p>";
    }
}
// }

?>
                <footer class="text-center d-block footer-basic position-sticky"><ul class="list-inline"><li class="list-inline-item"><a href="/">Home</a></li><li class="list-inline-item"><a href="#">Other Services</a></li><li class="list-inline-item"><a href="https://github.com/Ente" target="_blank">GitHub</a></li><li class="list-inline-item"><a href="#">Terms</a></li><li class="list-inline-item"><a href="#">Privacy Policy</a></li></ul><p class="copyright" style="font-family: monospace;">GiveawayD x Ente © 2021</p></footer>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
                
            </body>
</html>