<?php
    require ('steamauth/steamauth.php');  
	require_once ('config.php');
	$achievements_file = "cache/achievements.json";
	if (!file_exists($achievements_file)) {
		$url = file_get_contents("https://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?key=".$steamauth['apikey']."&appid=550650");
		$content = json_decode($url, true);
		$buffer = fopen($achievements_file, "w+");
		fwrite($buffer, json_encode($content, JSON_PRETTY_PRINT));
		fclose($buffer);
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/index.css">
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			.table {
				table-layout: fixed;
				word-wrap: break-word;
			}
		</style>
		<title>BlackSquad Rank Sync</title>
	</head>
	<body><!--  style="background-color: #EEE;"-->
		<video autoplay muted loop id="myVideo">
			<source src="vid/BSQ_main_25s_0421.mp4" type="video/mp4">
		</video>
		<div class="content"><!--  style="margin-top: 30px; margin-bottom: 30px; padding-bottom: 10px; background-color: #FFF;" -->
			<div class="container">
				<center><img src="img/BlackSquad.png" /><br><br>
				<?php
				if(!isset($_SESSION['steamid'])) {
					loginbutton();
				}  else {
					include ('steamauth/userInfo.php');
					include ('steamauth/userAchievements.php');
					$level = "Level 0-30";
					foreach($steamprofile['achievements'] as $value) {
						if (!$value["achieved"]) continue;
						switch ($value["apiname"]) {
							case "A008_BlackSquad": $level = "Level 100"; break;
							case "A006_FieldOfficer": $level = "Level 60-99"; break;
							case "A005_HigherOfficer": $level = "Level 50-59"; break;
							case "A004_SeniorOfficer": $level = "Level 40-49"; break;
							case "A003_Officer": $level = "Level 30-39"; break;
						}
					}
					echo '<font size="60" color="white">'.$level."</font>";
					echo "<br><br>";
					logoutbutton();
				}    
				?>
				</center>
			</div> 
		<!--div class="pull-right">
			<i><a href="https://github.com/BlackSquadGame/rank-sync">BlackSquad Rank Sync</a> by <a href="https://github.com/Bluscream">Bluscream</a>.</i>
		</div-->
		</div> 
	</body>
</html>
