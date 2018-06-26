<?php
if (empty($_SESSION['steam_uptodate']) or empty($_SESSION['steam_personaname'])) {
	require 'SteamConfig.php';
	$url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?key=".$steamauth['apikey']."&steamids=".$_SESSION['steamid']);
	$content = json_decode($url, true);
	$dir = "cache/{$content['response']['players'][0]['steamid']}/";
	if (!file_exists($dir)) {
		mkdir($dir, 0777, true);
	}
	$buffer = fopen($dir."profile.json", "w+");
	fwrite($buffer, json_encode($content, JSON_PRETTY_PRINT));
	fclose($buffer);
	$user = $content['response']['players'][0];
	$_SESSION['steam_steamid'] = $user['steamid'];
	$_SESSION['steam_communityvisibilitystate'] = $user['communityvisibilitystate'];
	$_SESSION['steam_profilestate'] = $user['profilestate'];
	$_SESSION['steam_personaname'] = $user['personaname'];
	$_SESSION['steam_lastlogoff'] = $user['lastlogoff'];
	$_SESSION['steam_profileurl'] = $user['profileurl'];
	$_SESSION['steam_avatar'] = $user['avatar'];
	$_SESSION['steam_avatarmedium'] = $user['avatarmedium'];
	$_SESSION['steam_avatarfull'] = $user['avatarfull'];
	$_SESSION['steam_personastate'] = $user['personastate'];
	if (isset($user['realname'])) { 
		   $_SESSION['steam_realname'] = $user['realname'];
	   } else {
		   $_SESSION['steam_realname'] = "Real name not given";
	}
	if (isset($user['primaryclanid'])){
		$_SESSION['steam_primaryclanid'] = $user['primaryclanid'];
		$_SESSION['steam_timecreated'] = $user['timecreated'];
	}
	$_SESSION['steam_uptodate'] = time();
}
$steamprofile['steamid'] = $_SESSION['steam_steamid'];
$steamprofile['communityvisibilitystate'] = $_SESSION['steam_communityvisibilitystate'];
$steamprofile['profilestate'] = $_SESSION['steam_profilestate'];
$steamprofile['personaname'] = $_SESSION['steam_personaname'];
$steamprofile['lastlogoff'] = $_SESSION['steam_lastlogoff'];
$steamprofile['profileurl'] = $_SESSION['steam_profileurl'];
$steamprofile['avatar'] = $_SESSION['steam_avatar'];
$steamprofile['avatarmedium'] = $_SESSION['steam_avatarmedium'];
$steamprofile['avatarfull'] = $_SESSION['steam_avatarfull'];
$steamprofile['personastate'] = $_SESSION['steam_personastate'];
$steamprofile['realname'] = $_SESSION['steam_realname'];
if (isset($_SESSION['steam_primaryclanid'])){
	$steamprofile['primaryclanid'] = $_SESSION['steam_primaryclanid'];
	$steamprofile['timecreated'] = $_SESSION['steam_timecreated'];
}
$steamprofile['uptodate'] = $_SESSION['steam_uptodate'];

// Version 3.2
?>
    
