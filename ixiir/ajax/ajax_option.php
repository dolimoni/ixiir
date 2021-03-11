<?php
	require_once('../global.php');
	if(rqstprm("param_id")!="")
	{
		if(rqstprm("tbl")=="ville")
		{
			echo "<option value='' >".get_label("lbl_ville")."</option>";
			$req = "select id, nom_".$_SESSION["lang"]." AS NOMLINE FROM ville WHERE pays=".injsql(rqstprm("param_id"),$pdo)." ORDER BY `order`, NOMLINE";
		}
		if(rqstprm("tbl")=="specialite")
		{
			echo "<option value='' >Spécialité</option>";
			$req = "select id, nom_".$_SESSION["lang"]." AS NOMLINE FROM metier_specialiste WHERE metier IS NULL OR metier=".injsql(rqstprm("param_id"),$pdo)." ORDER BY NOMLINE";
		}
		if($req!="")
		{
			$dt_result = bddfetch($req,$pdo);
			foreach($dt_result as $r_soc)
			{
				$str_sel="";
				if(rqstprm("param_sel")==$r_soc["id"]){$str_sel="selected";}
				echo "<option value='".$r_soc["id"]."' $str_sel >".$r_soc["NOMLINE"]."</option>";
			}
		}
	}
	
?>