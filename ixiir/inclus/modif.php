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
		$dtr = bddfetch("SELECT id, nom_fr, nom_en, nom_ar from metier_specialiste where ismaj=0", "SET CHARACTER SET utf8",$pdo);
		foreach($dtr as $lin)
		{
			//echo $lin["id"]." -- ".Replace(Replace(trim($lin["nom_ar"]), "<h1>", ""), "</h1>", "")." ".Replace(Replace(trim($lin["nom"]), "<h1>", ""), "</h1>", "")."<br />";
			bddmaj("UPDATE metier_specialiste set nom_fr=".injsql(Replace(Replace(trim($lin["nom_fr"]), "<h1>", "")),$pdo).", nom_en=".injsql(Replace(Replace(trim($lin["nom_en"]), "<h1>", "")),$pdo).", nom_ar=".injsql(Replace(Replace(trim($lin["nom_ar"]), "<h1>", "")),$pdo).", ismaj=1 WHERE id=".injsql($lin["id"],$pdo).";",$pdo);
		}
		?>
	</body>
</html>