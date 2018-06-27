<?php
  //require_once __DIR__ . '/vendor/autoload.php';
  include_once 'config.php';
  //require_once 'lib/steamauth/steamauth.php';
  //require_once 'steam-condenser.php';
  print_r($mysql);
  echo "<br>";
  include_once 'lib/db.php';
  db_connect();db_create();db_useradd(123456789);db_userupdatets(123456789, "test=");db_userupdatediscord(123456789, 4841654413213);
  print_r(db_usergetbysteamid(123456789));
  echo "<br>";
  exit("EXIT");
  use Discord\Discord;
  if(!isset($_SESSION['steamid'])) {
  	header('Location: '.$steamauth['loginpage']);
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
    /*
  	echo '<font size="60" color="white">'.$level['name']."</font>";
  	echo "<br><br>";
  	logoutbutton();
    */
    if (strlen($teamspeak['loginpass']) > 0){
      TeamSpeak3::init();
      $uri = "serverquery://".$teamspeak["loginname"].":".$teamspeak["loginpass"]."@".$teamspeak["host"].":".$teamspeak["queryport"]."/?server_port=".$teamspeak["serverport"]."&nickname=".urlencode($teamspeak["nickname"]);
      echo $uri."<br>";
      $ts3_VirtualServer = TeamSpeak3::factory($uri);
      $ip = isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'];
      foreach($ts3_VirtualServer->clientList() as $client)
      {
        if($client["client_type"]) continue;
        $clientInfo = $client->getInfo();
        print_r($clientInfo['client_nickname'].": ".$clientInfo['connection_client_ip']." == ".$ip);
        //if($clientInfo['connection_client_ip'] == $ip){
          $sgids = explode(",", $client["client_servergroups"]);
          foreach ($rank as $key) {
            if ($level['ts3_group_id'] == $key['ts3_group_id'])
              continue;
            if (in_array($key['ts3_group_id'], $sgids)){
              $client->remServerGroup($key['ts3_group_id']);
            }
          }
          if (!in_array($teamspeak['blacksquadgroupid'], $sgids))
            $client->addServerGroup($teamspeak['blacksquadgroupid']);
          if (!in_array($level['ts3_group_id'], $sgids))
            $client->addServerGroup($level['ts3_group_id']);
          break;
        //}
      }
    }
    if (strlen($discord['clientSecret']) > 0){
      $provider = new \Discord\OAuth\Discord([
      	'clientId'     => $discord['clientId'],
      	'clientSecret' => $discord['clientSecret'],
      	'redirectUri'  => $discord['redirectUri'],
      ]);

      if (! isset($_GET['code'])) {
      	echo '<a href="'.$provider->getAuthorizationUrl().'">Login with Discord</a>';
      } else {
      	$token = $provider->getAccessToken('authorization_code', [
      		'code' => $_GET['code'],
      	]);

      	// Get the user object.
      	$user = $provider->getResourceOwner($token);

      	// Get the guilds and connections.
      	$guilds = $user->guilds;
      	$connections = $user->connections;

      	// Accept an invite
      	$invite = $user->acceptInvite('https://discord.gg/0SBTUU1wZTUo9F8v');

      	// Get a refresh token
      	$refresh = $provider->getAccessToken('refresh_token', [
      		'refresh_token' => $getOldTokenFromMemory->getRefreshToken(),
      	]);

      	// Store the new token.
      }
      /*
      $discordbot = new Discord(['token' => $discord['token']]);
      $discordbot->on('ready', function ($discordbot) {
      	echo "Bot is ready!", PHP_EOL;
      	// Listen for messages.
      	$discordbot->on('message', function ($message, $discordbot) {
      		echo "{$message->author->username}: {$message->content}",PHP_EOL;
      	});
      });
      $discordbot->run();
    }*/
  }
}
?>
