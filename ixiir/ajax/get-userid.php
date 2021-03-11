<?php
	require_once('../global.php');
	if(rqstprm("param")!="")
	{
		$str_param=clear_param(rqstprm("param"));
		$req = "SELECT id, nom, prenom
				FROM user 
				WHERE id<>".injsql($_SESSION["userpk"])." AND (CONCAT(nom, ' ', prenom) like '%".Replace($str_param, "'", "''")."%' OR CONCAT(prenom, ' ', nom) like '%".Replace($str_param, "'", "''")."%') 
				ORDER BY prenom, nom";
		$dt_result = bddfetch($req);
		foreach($dt_result as $r_soc)
		{
			echo "<div class='lin_autocmplt' onclick=\"select_line(".$r_soc["id"].", '".rqstprm("idaff")."');\" >
						<span id='ln_".rqstprm("idaff")."_".$r_soc["id"]."' >".ucfirst($r_soc["prenom"]." ".$r_soc["nom"])."</span>
						<span id='inf_".rqstprm("idaff")."_".$r_soc["id"]."' style='display:none;' ></span>
					</div>";
		}
	}
	
?>