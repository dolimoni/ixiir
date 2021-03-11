<?php 
	include("../../global.php");
	require_once('google-login-api.php');
	if(isset($_GET['code']))
	{
		try
		{
			$gapi = new GoogleLoginApi();
			$data = $gapi->GetAccessToken($str_google_appid, $str_returnurlgoogle, $str_google_secret, $_GET['code']);
			$access_token = $data['access_token'];
			$user_info = $gapi->GetUserProfileInfo($access_token);
			$_SESSION['fb_access_token']=$access_token;
			if(isset($user_info['id']) && isset($user_info['name']["givenName"]) && isset($user_info['name']["familyName"]) && isset($user_info['emails'][0]["value"]))
			{
				$obj["id"]=$user_info['id'];
				$obj["prenom"]=$user_info['name']["givenName"];
				$obj["nom"]=$user_info['name']["familyName"];
				$obj["source"]="google";
				set_login($user_info['emails'][0]["value"], "", true, $obj);
			}
			else{redirect(get_url("login")."?e=notconnect");}
		}
		catch(Exception $e) {redirect(get_url("login")."?e=notconnect");}
	}
	redirect(get_url("login"));
	
?>