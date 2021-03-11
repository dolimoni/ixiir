<html>
	<head>
		<meta charset="UTF-8" />
		<title>Ixiir</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<script>
			url_of_site='https://www.aqrableek.com/';
			str_msgconf="Est ce que vous voulez continuer cette opération ?";
			if(window.history.replaceState){window.history.replaceState(null, null, window.location.href);}
		</script>

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="shortcut icon" href="https://www.aqrableek.com/images/logo.png">
	</head>
	<body>
		<?php 
		include("../global.php");
		$dtr = bddfetch("SELECT * from user where date_ajout>='2018-12-39' and ismaj=0",$pdo);
		foreach($dtr as $lin)
		{
			if($lin["login"]!="")
			{
				$msg="<html>
						<head>
							<meta charset='UTF-8' />
						</head>
						<body style='text-align:right;' >
							مرحبا
							<br />
							<p>بعد إطلاق الإصدار الجديد لموقع إكسير، نود إبلاغك بأنه تم تعيين رمز سري مؤقت لحسابك. يرجى تغييره بعد الوصول إلى الحساب.</p>
							<p>
								<b>الرمز السري </b>
								<br />
								passtmp2019
							<p>
							<hr />
							<p>
								www.ixiir.com
								<br />
								contact@ixiir.com
							</p>
						</body>
					</html>";
				//sendmsg("kassem.baroudi@gmail.com", "إكسير - النسخة الجديدة", $msg);
				sendmsg($lin["login"], "إكسير - النسخة الجديدة", $msg);
				bddmaj("UPDATE user SET ismaj=1 WHERE id=".injsql($lin["id"],$pdo),$pdo);
				sleep(0.5);
			}
			//break;
		}
		?>
	</body>
</html>