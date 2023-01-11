<?php
require $_SERVER["DOCUMENT_ROOT"] . "/api/inc/giveawayd.php";
require $_SERVER["DOCUMENT_ROOT"] . "/api/inc/api.giveawayd.php";


use GiveawayD\GiveawayD;
use GiveawayD\api;

$gwd = new GiveawayD;

while(true){
    $sql = "SELECT g_time_normal, g_id, g_webhook_url FROM giveaways;";
    $res = mysqli_query($gwd->db, $sql);
    $num = mysqli_num_rows($res);
        if($num >= 1){
            $data = mysqli_fetch_assoc($res);
            foreach($data as $gw){
                if(time() > $gw["g_time_normal"]){
                    $participants = $gwd->get_participants($gw["g_id"]);
                    $winner_row = array_rand($participants);
                    $winner_user = $winner_row["user_id"];

                }
            }
        }


}
?>