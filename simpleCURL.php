<?php 
echo "Welcome to CURL PHP<br><br><br>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.mcdonalds.com/us/en-us/full-menu.html");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_respnse = curl_exec($ch);

curl_close($ch);

//$server_respnse = json_decode($server_respnse);



echo "<textarea cols='40' rows='40'>".$server_respnse."</textarea>";

?>



