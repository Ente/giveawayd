<?php

#ini_set("display_errors",1);
function Timer($endArray){

//Gib den Endzeitpunkt an!
//$endTime = mktime(15, 30, 0, 11, 17, 2022); //Stunde, Minute, Sekunde, Monat, Tag, Jahr;
$endTime = mktime($endArray["hours"], $endArray["minutes"], $endArray["seconds"], $endArray["months"], $endArray["days"], $endArray["years"]);
//Aktuellezeit des microtimestamps nach PHP5, für PHP4 muss eine andere Form genutzt werden.
$timeNow = microtime(true);

//Berechnet differenz von der Endzeit vom jetzigen Zeitpunkt aus.
$diffTime = $endTime - $timeNow;

//Zerlegt $diffTime am Dezimalpunkt, rundet vorher auf 2 Stellen nach dem Dezimalpunkt und gibt diese zurück.
$milli = explode(".", round($diffTime, 2));
$millisec = round($milli[1]);

//Berechnung für Tage, Stunden, Minuten
$day = floor($diffTime / (24*3600));
$diffTime = $diffTime % (24*3600);
$hour = floor($diffTime / (60*60));
$diffTime = $diffTime % (60*60);
$min = floor($diffTime / 60);
$sec = $diffTime % 60;

//Ausgabe von $day (Tage), $hour (Stunden), $sec (Sekunden), $millisec (Millisekunden)
echo $day." Days ";
echo $hour." Hours ";
echo $min." Minutes ";
echo $sec." Seconds ";
}
Timer(json_decode($_GET["time"], true));
?> 