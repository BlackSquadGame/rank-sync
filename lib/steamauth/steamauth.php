<?php
	ob_start();
	session_start();

	if (isset($_GET['steamlogin'])){
		require 'openid.php';
		require 'SteamConfig.php';
		$openid = new LightOpenID($steamauth['domainname']);
		if(!$openid->mode) {
			$openid->identity = 'https://steamcommunity.com/openid';
			header('Location: ' . $openid->authUrl());
		} elseif ($openid->mode == 'cancel') {
			exit('Canceled authentication!');
		} else {
			if($openid->validate()) {
				$id = $openid->identity;
				$ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
				preg_match($ptn, $id, $matches);
				$_SESSION['steamid'] = $matches[1];
				if (!headers_sent()) {
					header('Location: '.$steamauth['loginpage']);
					exit;
				} else {
?>
					<script type="text/javascript">
						window.location.href="<?=$steamauth['loginpage']?>";
					</script>
					<noscript>
						<meta http-equiv="refresh" content="0;url=<?=$steamauth['loginpage']?>" />
					</noscript>
<?php
					exit;
				}
			} else {
				exit("Not logged in.");
			}
		}
	}

	if (isset($_GET['steamlogout'])){
		require 'SteamConfig.php';
		session_unset();
		session_destroy();
		header('Location: '.$steamauth['logoutpage']);
		exit;
	}

	if (isset($_GET['steamupdate'])){
		unset($_SESSION['steam_uptodate']);
		require 'userInfo.php';
		header('Location: '.$_SERVER['PHP_SELF']);
		exit;
	}
?>
