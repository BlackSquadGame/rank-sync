<?php
	require 'SteamConfig.php';
	$context = stream_context_create(array(
		'http' => array('ignore_errors' => true)
	));
	$url = file_get_contents("https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v1/?appid=550650&key=".$steamauth['apikey']."&steamid=".$_SESSION['steamid'], false, $context);
	$content = json_decode($url, true);
	if (!$content['playerstats']['success']) {
		exit("<font color='red'>".$content['playerstats']['error']."</font>");
	}
	$dir = "cache/{$content['playerstats']['steamID']}/";
	if (!file_exists($dir)) {
		mkdir($dir, 0777, true);
	}
	$buffer = fopen($dir."achievements.json", "w+");
	fwrite($buffer, json_encode($content, JSON_PRETTY_PRINT));
	fclose($buffer);
	$_SESSION['steam_achievements'] = $content['playerstats']['achievements'];
	$steamprofile['achievements'] = $_SESSION['steam_achievements'];
?>
