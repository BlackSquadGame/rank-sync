<?php
  $crypto['salt'] = ""; // Some random string used to encrypt steam ids for the ?hash=

  $steamauth['apikey'] = ""; // Your Steam WebAPI-Key found at https://steamcommunity.com/dev/apikey

  $teamspeak['host'] = "127.0.0.1";
  $teamspeak['queryport'] = 10011;
  $teamspeak['serverport'] = 9987;
  $teamspeak['loginname'] = 'serveradmin';
  $teamspeak['loginpass'] = '';
  $teamspeak['nickname'] = 'BlackSquad Rank Sync';
  $teamspeak['blacksquadgroupid'] = 0;

  $discord['token'] = '';
  $discord['channelid'] = '';

  $rank['Recruit'] = array(
    "apiname" => "",
    "name" => "Level 0-29",
    "ts3_group_id" => 0,
    "discord_role_id" => 0
  );
  $rank['A003_Officer'] = array(
    "apiname" => "A003_Officer",
    "name" => "Level 30-39",
    "ts3_group_id" => 0,
    "discord_role_id" => 0
  );
  $rank['A004_SeniorOfficer'] = array(
    "apiname" => "A004_SeniorOfficer",
    "name" => "Level 40-49",
    "ts3_group_id" => 0,
    "discord_role_id" => 0
  );
  $rank['A005_HigherOfficer'] = array(
    "apiname" => "A005_HigherOfficer",
    "name" => "Level 50-59",
    "ts3_group_id" => 0,
    "discord_role_id" => 0
  );
  $rank['A006_FieldOfficer'] = array(
    "apiname" => "A006_FieldOfficer",
    "name" => "Level 60-99",
    "ts3_group_id" => 0,
    "discord_role_id" => 0
  );
  $rank['A008_BlackSquad'] = array(
    "apiname" => "A008_BlackSquad",
    "name" => "Level 100",
    "ts3_group_id" => 0,
    "discord_role_id" => 0
  );
?>
