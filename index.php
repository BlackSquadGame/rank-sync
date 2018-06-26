<?php
  require __DIR__ . '/vendor/autoload.php';
  require ('lib/steamauth/steamauth.php');
	require_once ('config.php');
  require_once 'steam-condenser.php';
  //$id = SteamId::create('bluscream');
  //print_r(json_encode($id, JSON_PRETTY_PRINT));
  //$stats = $id->getGameStats('blacksquad');
  //print_r($stats);
  //$achievements = $id->getAchievements(550650);
  //print_r($achievements);
	//$achievements_file = "cache/achievements.json";
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
					include ('lib/steamauth/userInfo.php');
					include ('lib/steamauth/userAchievements.php');
					$level = $rank['Recruit'];
					foreach($steamprofile['achievements'] as $value) {
						if (!$value["achieved"]) continue;
						switch ($value["apiname"]) {
							case "A008_BlackSquad":
                $level = $rank['A008_BlackSquad'];break;
							case "A006_FieldOfficer":
                $level = $rank['A006_FieldOfficer'];break;
							case "A005_HigherOfficer":
                $level = $rank['A005_HigherOfficer'];break;
							case "A004_SeniorOfficer":
                $level = $rank['A004_SeniorOfficer'];break;
							case "A003_Officer":
                $level = $rank['A003_Officer'];break;
						}
					}
					echo '<font size="60" color="white">'.$level['name']."</font>";
					echo "<br><br>";
					logoutbutton();
          try {
            TeamSpeak3::init();
            $uri = "serverquery://".$teamspeak["loginname"].":".$teamspeak["loginpass"]."@".$teamspeak["host"].":".$teamspeak["queryport"]."/?server_port=".$teamspeak["serverport"]."&nickname=".urlencode($teamspeak["nickname"]);
            echo $uri."<br>";
            $ts3_VirtualServer = TeamSpeak3::factory($uri);
            $ip = isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'];
            //$client = $ts3_VirtualServer->clientFindDb($ip, true);
            foreach($ts3_VirtualServer->clientList() as $client)
            {
              if($client["client_type"]) continue;
              $clientInfo = $client->getInfo();
              print_r($clientInfo['connection_client_ip']." == ".$ip);
              if($clientInfo['connection_client_ip'] == $ip){
                if( $ts3_VirtualServer->serverGroupClientAdd($teamspeak['blacksquadgroupid'], $client[0]) )
                    echo "You are now registered as Black Squad Player!";
                if( $ts3_VirtualServer->serverGroupClientAdd($level['ts3_group_id'], $client[0]) )
                    echo "Dein Rank wurde erfolgreich geändert!";
              }
            }
          } catch(Exception $e) {
            exit("Fehler!<br/>ErrorID: <b>". $e->getCode() ."</b>; Error Message: <b>". $e->getMessage() ."</b>;");
          }
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
