<?php
  function db_connect() {
    $GLOBALS['db'] = new mysqli($GLOBALS['mysql']['host'], $GLOBALS['mysql']['username'], $GLOBALS['mysql']['password'], $GLOBALS['mysql']['database']);
  }
  function db_exec($sql, $fetch = false) {
    echo $sql;
    echo "<br>";
    $result = $GLOBALS['db']->query($sql);
    print_r($result);
    if (!$fetch && $result === FALSE) {
        exit("Database Error: ". $GLOBALS['db']->error ."<br>");
    }
    elseif ($fetch){ //  && $result->num_rows == 1
        while($row = $result->fetch_assoc()) { return $row; }
    }
    return $result;
  }
  function db_create() {
    db_exec("CREATE TABLE IF NOT EXISTS ".$GLOBALS['mysql']['table']." ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE, timestamp TIMESTAMP, steam VARCHAR(17) NOT NULL UNIQUE, teamspeak VARCHAR(28) UNIQUE, discord VARCHAR(18) UNIQUE)");
  }
  function db_useradd($id) {
    db_exec("INSERT IGNORE INTO ".$GLOBALS['mysql']['table']." (steam) VALUES ('".$id."')");
  }
  function db_userupdatets($steam, $teamspeak) {
    db_exec("UPDATE ".$GLOBALS['mysql']['table']." SET teamspeak='".$teamspeak."' WHERE steam='".$steam."'");
  }
  function db_userupdatediscord($steam, $discord) {
    db_exec("UPDATE ".$GLOBALS['mysql']['table']." SET discord='".$discord."' WHERE steam='".$steam."'");
  }
  function db_usergetbysteamid($id) {
    db_exec("SELECT * FROM ".$GLOBALS['mysql']['table']." where steam='".$id."'", true);
  }
  function db_usergetbyteamspeakuid($id) {
    db_exec("SELECT * FROM ".$GLOBALS['mysql']['table']." where teamspeak='".$id."'", true);
  }
  function db_usergetbydiscorduid($id) {
    db_exec("SELECT * FROM ".$GLOBALS['mysql']['table']." where discord='".$id."'", true);
  }
  function db_userremove($id) {
    db_exec("DELETE FROM ".$GLOBALS['mysql']['table']." WHERE steam=".$id."'");
  }
  function db_disconnect() {
    mysqli_close($GLOBALS['db']);
  }
?>
