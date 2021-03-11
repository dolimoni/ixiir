<?php
	function getcon()
	{
		$pdo=null;
		$pdo = new PDO("mysql:host=".$_SESSION["BDDHOST"].";dbname=".$_SESSION["BDDNAME"], $_SESSION["BDDUSER"], $_SESSION["BDDPASS"]);
		$pdo -> exec("SET CHARACTER SET utf8_general_ci");
		//$pdo -> exec("SET CHARACTER SET ascii_general_ci");
		return $pdo;
	}
	
	function bddmaj($sql,$pdo)
	{
		//$pdo=getcon();
		$nb = $pdo->exec($sql);
		return $nb;
	}
	function bddadgetid($sql,$pdo)
	{
		//$pdo=getcon();
		$nb = $pdo->exec($sql); 
		return $pdo->lastInsertId();
	}
	function bddfetch($sql,$pdo, $exc="")
	{
		//$pdo=getcon();
		if($exc!=""){$pdo -> exec($exc);}
		$sth = $pdo->prepare($sql);
		$sth->execute();
		$result = $sth->fetchAll(); 		
		return $result;
	}
	function injsql($prm,$pdo)
	{
		//$pdo=getcon();
		return $pdo->quote($prm);
	}
	
?>