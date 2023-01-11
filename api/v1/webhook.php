<?php

define("NAME", "GiveawayD");
define("WEBHOOK_URL", "https://canary.discord.com/api/webhooks/1048712951974088815/lAw9Vr_oDmhpYvs68Uz9NdeGvZgc8M0YrMLswqLwtGyHwmioyxTOYt6_emRUyE4-IByW");

function webhook($fun){

$parms = [
    "username" => NAME,
    "avatar_url" => "https://pbs.twimg.com/media/EptqDvyWwAgiVc9.jpg:large",
    "content" => "{$fun}",
    "thread" => "GiveawayD working!"
];

$parm1 = json_encode($parms);

$ch = curl_init(WEBHOOK_URL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $parm1);

$output = curl_exec($ch);
return $output;
};



echo webhook("TEST");

?>