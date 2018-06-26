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
    <title>BlackSquad Rank Sync</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
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
  </head>
  <body style="background-color: #EEE;">
    <div class="container" style="margin-top: 30px; margin-bottom: 30px; padding-bottom: 10px; background-color: #FFF;">
		<center><img src="img/BlackSquad.png" />
		<hr>
		<?php
			if(!isset($_SESSION['steamid'])) {
				echo "<div style='margin: 30px auto; text-align: center;'>Welcome Guest! Please log in!<br>";
				loginbutton();
				echo "</div>";
			}  else {
				include ('steamauth/userInfo.php');
				$url = file_get_contents("https://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid=550650&key=".$steamauth['apikey']."&steamid=".$_SESSION['steamid']);
				$content = json_decode($url, true);
				$buffer = fopen("cache/{$_SESSION['steamid']}/achievements.json", "w+");
				fwrite($buffer, json_encode($content, JSON_PRETTY_PRINT));
				fclose($buffer);
		?>
		<span><?php logoutbutton(); ?></span>
		<?php
			}    
		?>
		<hr>
		</center>
		<div class="pull-right">
			<i><a href="https://github.com/BlackSquadGame/rank-sync">BlackSquad Rank Sync</a> by <a href="https://github.com/Bluscream">Bluscream</a>.</i>
		</div>
	</div> 
  </body>
</html>
