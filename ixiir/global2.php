<?php

	/*

	error_reporting(E_ALL);

	ini_set('display_errors', 1);

	*/

	date_default_timezone_set('Africa/Casablanca');	

	@session_start();

	$_SESSION["DIRNAME"] = dirname(__FILE__);

	include("inclus/functions.php");

	include("inclus/bdd.php");

	include("inclus/lang.php");

	$is_local=(indexof(curPageURL(), "localhost")>=0 || indexof(curPageURL(), "192.168.")>=0);

	function get_sitename(){return "IXIIR";}

	function get_mailadmin(){return "ixiirpress@gmail.com";}

	function get_phoneadmin(){return "+212 000 000 000";}

	function get_adresse(){return "Adresse - Casablanca, Maroc";}

	

	$strurlsite="https://" . $_SERVER["HTTP_HOST"] . "/";

	$_SESSION["BDDHOST"]="localhost";

	$_SESSION["BDDNAME"]="ixiircom_bdd";

	$_SESSION["BDDUSER"]="ixiircom_user";

	$_SESSION["BDDPASS"]="ixirBddPass@28934";

	

	$str_facebook_appid="328716634500168";

	$str_facebook_secret="134046da28276967ab4429ce95c97f90";

	$str_google_appid="1031254644942-3hr9m40uhgcko82p0ufo27fg3islqr16.apps.googleusercontent.com";

	$str_google_secret="DJ4IyWpmLxgLhNjsIyeXi-9Z";

	$str_returnurlgoogle=$strurlsite.'inclus/google/call-back.php';

	

	if(!isset($_SESSION["login"])){$_SESSION["login"] = "";}

	if(!isset($_SESSION["pass"])){$_SESSION["pass"] = "";}

	if(!isset($_SESSION["userpk"])){$_SESSION["userpk"] = "";}

	if(!isset($_SESSION["nom"])){$_SESSION["nom"] = "";}

	if(!isset($_SESSION["prenom"])){$_SESSION["prenom"] = "";}

	if(!isset($_SESSION["pays"])){$_SESSION["pays"] = "";}

	if(!isset($_SESSION["ville"])){$_SESSION["ville"] = "";}

	if(!isset($_SESSION["metier"])){$_SESSION["metier"] = "";}

	if(!isset($_SESSION["specialite"])){$_SESSION["specialite"] = "";}

	if(!isset($_SESSION["user_image"])){$_SESSION["user_image"] = "";}

	if(!isset($_SESSION["user_type"])){$_SESSION["user_type"] = "";}

	

	if(!isset($_SESSION["fb_access_token"])){$_SESSION["fb_access_token"] = "";}

	$is_adminsrch=(rqstprm("isadminsearch")=="1" && $_SESSION["user_type"]==0);

    $nbrperpag=26;

	$nbrnotif=0;

	$nbrnotif_cmd=0; $strtxtnotif_cmd=""; $nbrnotif_livre=0; $strtxtnotif_livre=""; $nbrnotif_perte=0; $strtxtnotif_perte="";

	$str_defimageuser="images/deaultuser.jpg";

	$str_orderpost=0;if(rqstprm("orderpst")=="1"){$str_orderpost=1;}
    $pdo=getcon();

	function is_user_login()

	{

		return (!empty($_SESSION["login"]) && !empty($_SESSION["pass"]));

	}

	function set_login($str_login, $str_pass, $pdo, $is_reseau=false, $obj=null)

	{

		global $strurlsite;

		$result=array();

		if($is_reseau)

		{

			$req= "SELECT * FROM user u WHERE u.login=".injsql($str_login, $pdo)." OR id_reseaux=".injsql($str_login, $pdo)." OR CONCAT(id_reseaux, '@facebook.com')=".injsql($str_login, $pdo);

			$result = bddfetch($req, $pdo);

			if(!isset($result[0]["id"]))

			{

				$str_id=""; $str_nom=""; $str_prenom=""; $str_source=""; $str_pass=time();

				if(isset($obj["id"])){$str_id=$obj["id"];}

				if(isset($obj["nom"])){$str_nom=$obj["nom"];}

				if(isset($obj["prenom"])){$str_prenom=$obj["prenom"];}

				if(isset($obj["source"])){$str_source=$obj["source"];}

				$req = "INSERT INTO user(nom, prenom, login, source, id_reseaux, pass, lang) 

						VALUES(".injsql(htmlspecialchars($str_nom), $pdo).", ".injsql(htmlspecialchars($str_prenom), $pdo).", ".injsql(htmlspecialchars($str_login), $pdo).", ".injsql(htmlspecialchars($str_source), $pdo).", ".injsql(htmlspecialchars($str_id), $pdo).", ".injsql(htmlspecialchars($str_pass), $pdo).", ".injsql(htmlspecialchars($_SESSION["lang"]), $pdo).")";

				$str_idinsr=bddadgetid($req, $pdo);

				$_SESSION["userpk"] = $str_idinsr;

				$_SESSION["login"] = $str_login;

				$_SESSION["pass"] = $str_pass;

				$_SESSION["nom"] = $str_nom;

				$_SESSION["prenom"] = $str_prenom;

				$_SESSION["pays"] = "";

				$_SESSION["ville"] = "";

				$_SESSION["metier"] = "";

				$_SESSION["specialite"] = "";

				$_SESSION["user_image"] = "";

				$_SESSION["user_type"] = 1;

				redirect($strurlsite);

			}

		}

		else

		{

			$req= "SELECT * FROM user u WHERE u.login = ".injsql($str_login, $pdo)." and (u.pass = ".injsql($str_pass, $pdo)." OR u.pass = ".injsql(md5($str_pass), $pdo)." OR u.pass_save = ".injsql($str_pass, $pdo)." OR u.pass_save = ".injsql(md5($str_pass), $pdo).")";

			$result = bddfetch($req, $pdo);

		}

		if(isset($result[0]["id"]))

		{

			$isvalide=true;

			if($result[0]["user_vld"]=="0")

			{

				$dureesejour = (strtotime(date("Y-m-d H:i:s")) - strtotime($result[0]["date_out"]));

				$isvalide=/*(intval($dureesejour/(60*60*24))<=15)*/false;

				if($isvalide)

				{

					$req = "UPDATE user SET user_vld=1, date_out=NULL WHERE bloqbyadmin=0 AND id=".injsql($result[0]["id"], $pdo);

					$nbr=bddmaj($req, $pdo);

				}

			}

			if($isvalide)

			{

				$_SESSION["userpk"] = $result[0]["id"];

				$_SESSION["login"] = $result[0]["login"];

				$_SESSION["pass"] = $result[0]["pass"];

				$_SESSION["nom"] = $result[0]["nom"];

				$_SESSION["prenom"] = $result[0]["prenom"];

				$_SESSION["pays"] = $result[0]["pays"];

				$_SESSION["ville"] = $result[0]["ville"];

				$_SESSION["metier"] = $result[0]["metier"];

				$_SESSION["specialite"] = $result[0]["specialite"];

				$_SESSION["user_image"] = $result[0]["image"];

				$_SESSION["user_type"] = $result[0]["user_type"];

				$_SESSION["lang"] = $result[0]["lang"];

				if($is_reseau){redirect($strurlsite);}

				else{return "OK";}

			}

			else

			{

				if($is_reseau){redirect(get_url("login")."?e=notconnect");}

				else{return get_label("lbl_msg_login_err_bloquer");}

			}

		}

		else{if($is_reseau){redirect(get_url("login")."?e=notconnect");}else{return get_label("lbl_msg_login_err_authentf");}}

		return "";

	}

	function set_logout()

	{

		$_SESSION["userpk"] = "";

		$_SESSION["login"] = "";

		$_SESSION["pass"] = "";

		$_SESSION["nom"] = "";

		$_SESSION["prenom"] = "";

		$_SESSION["pays"] = "";

		$_SESSION["ville"] = "";

		$_SESSION["metier"] = "";

		$_SESSION["specialite"] = "";

		$_SESSION["user_image"] = "";

		$_SESSION["user_type"] = "";

	}

	function img_userdef($strlien="")

	{

		global $strurlsite,$str_defimageuser;

		$strrtrn=$strurlsite; 

		if($strlien!=""){$strrtrn.=$strlien;}else{$strrtrn.=$str_defimageuser;}

		return $strrtrn;

	}

	function get_metier($str_id, $pdo)

	{

		$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMLBL FROM metier u WHERE id = ".injsql($str_id, $pdo);

		$result = bddfetch($req, $pdo);

		if(isset($result[0]["id"])){return $result[0];}

		else{return null;}

	}

	function get_specialite($str_id, $pdo)

	{

		$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMLBL FROM metier_specialiste u WHERE id = ".injsql($str_id, $pdo);

		$result = bddfetch($req, $pdo);

		if(isset($result[0]["id"])){return $result[0];}

		else{return null;}

	}

	function get_url($page="")

	{

		global $strurlsite;

		$str_pagertrn=$strurlsite;

		if($page=="profil"){$str_pagertrn.="mon-profil.php";}

		elseif($page=="login"){$str_pagertrn.="sign-in.php";}

		return $str_pagertrn;

	}

	function get_spinloading($str_id="dv_loading_glob")

	{

		return "<div id='$str_id' ><img src='".$_SESSION["path"]."images/loader-dark.gif' id='img_loading_setbarcode' /><div>".get_label("lbl_traitmntencour")."...</div></div>";

	}

	function get_copieright()

	{

		?><p>© <?php echo Replace(Replace(Replace(get_label("lbl_copyright"), "[[PARAM1]]", date("Y")), "[[PARAM2]]", get_sitename()), "[[PARAM3]]", ""); ?></p><?php

	}

	function get_lienfooter()

	{

		global $strurlsite;

		?>

		<ul>

			<!--<li><a href="<?php echo $strurlsite; ?>comment-ca-marche.php" ><?php echo get_label("lbl_cmntcmrch"); ?></a></li>-->

			<li><a href="<?php echo $strurlsite; ?>qui-somme-nous.php" ><?php echo get_label("lbl_quisomenous"); ?></a></li>

			<li><a href="<?php echo $strurlsite; ?>conditions.php" ><?php echo get_label("lbl_condition_utilisation"); ?></a></li>

			<li><a href="mailto:<?php echo get_mailadmin(); ?>" ><?php echo get_mailadmin(); ?></a></li>

			<li><a href="<?php echo $strurlsite."?lang=fr"; ?>" >Français</a></li>

			<li><a href="<?php echo $strurlsite."?lang=ar"; ?>" >العربية</a></li>

			<li><a href="<?php echo $strurlsite."?lang=en"; ?>" >English</a></li>

		</ul>

		<?php

	}

	function get_user_statique($str_id,$pdo, $str_payusr="",$income=0)

	{

		echo "<hr />";

		$req = "SELECT 0 AS LINAF, COUNT(*) AS NBRTOT FROM user_vue uv WHERE uv.user_id=".injsql($str_id, $pdo)."

				UNION

				SELECT 1 AS LINAF, COUNT(*) AS NBRTOT FROM user_abonne ua WHERE ua.user_id=".injsql($str_id, $pdo)." AND abonne_del=0

				UNION

				SELECT 2 AS LINAF, COUNT(*) AS NBRTOT FROM posts p WHERE p.par=".injsql($str_id, $pdo)."

				UNION

				SELECT 3 AS LINAF, COUNT(*) AS NBRTOT FROM posts p JOIN posts_vue pv ON pv.post=p.id WHERE p.par=".injsql($str_id, $pdo);

			

		$dt_result=bddfetch($req, $pdo);

		echo get_label("lbl_nbrvisit_page")."<br /><b style='font-size:15pt;' >".$dt_result[0]["NBRTOT"]."</b>";

		echo "<br />".get_label("lbl_abonne_fidele")."<br /><b style='font-size:15pt;' >".$dt_result[1]["NBRTOT"]."</b>";

		echo "<br />".get_label("lbl_les_posts")."<br /><b style='font-size:15pt;' >".$dt_result[2]["NBRTOT"]."</b>";

		echo "<br />".get_label("lbl_nbrvueposts")."<br /><b style='font-size:15pt;' >".$dt_result[3]["NBRTOT"]."</b>";

		$nbr_clas=0; $nbr_clas_pay=0;

		$req = "SELECT *

				FROM (

					SELECT @rank := @rank + 1 AS ranking, tbl.*

					FROM(

						SELECT p.par

								, SUM(COALESCE((SELECT COUNT(*) FROM posts_vue pv WHERE pv.post=p.id), 0)

									  + (COALESCE((SELECT COUNT(*) FROM posts_comment pc WHERE pc.post=p.id), 0)*3)

									  + (COALESCE((SELECT COUNT(*) FROM posts_jaime pj WHERE pj.post=p.id), 0)*2)) AS NBRJAIME

						FROM posts p

						GROUP BY p.par

						ORDER BY NBRJAIME DESC

					) tbl

				) tbl2

				WHERE tbl2.par=".injsql($str_id, $pdo);

		$dt_result=bddfetch($req, $pdo, "SET @rank=0;");

		if(isset($dt_result[0])){$nbr_clas_pay=$dt_result[0]["ranking"];}

		echo "<br />".get_label("lbl_ratepageworld")."<br /><b style='font-size:15pt;' >".$nbr_clas_pay."</b>";

		if($str_payusr=="")

		{

			$req="SELECT pays FROM user WHEER id=".injsql($str_id, $pdo);

			$result_user=bddfetch($req, $pdo);

			if(isset($result_user[0]["pays"])){$str_payusr=$result_user[0]["pays"];}

		}

		if($str_payusr!="")

		{

			$req = "SELECT *

					FROM (

						SELECT @rank := @rank + 1 AS ranking, tbl.*

						FROM(

							SELECT p.par

									, SUM(COALESCE((SELECT COUNT(*) FROM posts_vue pv WHERE pv.post=p.id), 0)

										  + (COALESCE((SELECT COUNT(*) FROM posts_comment pc WHERE pc.post=p.id), 0)*3)

										  + (COALESCE((SELECT COUNT(*) FROM posts_jaime pj WHERE pj.post=p.id), 0)*2)) AS NBRJAIME

							FROM posts p

							JOIN user u ON u.id=p.par

							WHERE u.pays=".injsql($str_payusr, $pdo)."

							GROUP BY p.par

							ORDER BY NBRJAIME DESC

						) tbl

					) tbl2

					WHERE tbl2.par=".injsql($str_id, $pdo);

			$dt_result=bddfetch($req, $pdo, "SET @rank=0;");

			if(isset($dt_result[0])){$nbr_clas=$dt_result[0]["ranking"];}

			echo "<br />".get_label("lbl_ratepagepays")."<br /><b style='font-size:15pt;' >".$nbr_clas."</b>";

		}
		echo "<br />".get_label("lbl_income")."<br /><b style='font-size:15pt;' >".number_format($income, 2, '.', '')." $</b>";

	}

	function get_btn_suivi($user_id, $pdo, $user_vue="", $just_nbr=false)

	{

		if($user_vue==""){$user_vue=$_SESSION["userpk"];}

		$req="SELECT COUNT(*) AS NBRTOT FROM user_abonne ub WHERE ub.user_vue=".injsql($user_vue, $pdo)." AND ub.user_id=".injsql($user_id, $pdo)." AND abonne_del=0;";

		$dt_abonne=bddfetch($req, $pdo);

		if($just_nbr){return $dt_abonne[0]["NBRTOT"];}

		else

		{

			if($dt_abonne[0]["NBRTOT"]>0)

			{

				echo "<br /><div class='btn_share btn_unfollow' id='dv_unfolow' onclick=\"deletefolow(".$user_id.", ".$user_vue.", 'delflw', true)\" ><i class='la la-hand-rock-o' ></i> ".get_label('lbl_delsuivi')."</div>";

			}

			else

			{

				echo "<br /><div class='btn_share dv_folow' id='dv_unfolow' onclick=\"deletefolow(".$user_id.", ".$user_vue.", 'flw', true)\" ><i class='la la-hand-pointer-o' ></i> ".get_label('lbl_suivi')."</div>";

			}

		}

	}



	function get_htmlpost2($dt_page, $str_pour,$pdo, $str_id='', $nbr=-1)

	{

		global $strurlsite, $nbrperpag, $is_adminsrch, $str_pour_pay, $str_pour_ville, $str_pour_metier, $str_pour_special, $str_pour_famille, $str_orderpost;

		$is_connect=is_user_login();

		$str_where=""; $str_col=", 0 NBRCACHER "; $str_styleglb="";

		if($str_id!=""){$str_where.=" AND p.id=".injsql($str_id, $pdo)." ";$str_styleglb="border-radius: 0px;border-left: 0px;border-right: 0px;";}

		else

		{

			if(rqstprm("txt_search")!="")

			{

				$str_mocle=trim(rqstprm("txt_search"));

				$str_where.=" AND (p.detail like '%".Replace($str_mocle, "'", "''")."%' OR u.nom like '".Replace($str_mocle, "'", "''")."%' OR u.prenom like '".Replace($str_mocle, "'", "''")."%' OR CONCAT(u.prenom, ' ', u.nom) like '".Replace($str_mocle, "'", "''")."%' OR CONCAT(u.nom, ' ', u.prenom) like '".Replace($str_mocle, "'", "''")."%')";

			}

			if($is_adminsrch)

			{

				if(rqstprm("txt_pays")!=""){$str_where.=" AND u.pays=".injsql(rqstprm("txt_pays"), $pdo)." ";}

				if(rqstprm("txt_ville")!=""){$str_where.=" AND u.ville=".injsql(rqstprm("txt_ville"), $pdo)." ";}

				if(rqstprm("txt_metier")!=""){$str_where.=" AND u.metier=".injsql(rqstprm("txt_metier"), $pdo)." ";}

				if(rqstprm("txt_specialite")!=""){$str_where.=" AND u.specialite=".injsql(rqstprm("txt_specialite"), $pdo)." ";}

			}

			else

			{

				//if($str_pour==0){$str_where.=" AND p.pour=$str_pour ";}

				if($str_pour==1){$str_where.=" AND (p.par=".injsql($_SESSION["userpk"], $pdo)." OR ((p.pour=$str_pour AND u.pays=".injsql($_SESSION["pays"], $pdo).") OR (p.pour=2 AND v.pays=".injsql($_SESSION["pays"], $pdo).") OR (p.pour=6 AND u.pays=".injsql($_SESSION["pays"], $pdo)."))) ";}

				if($str_pour==2){$str_where.=" AND (p.par=".injsql($_SESSION["userpk"], $pdo)." OR ((p.pour=$str_pour AND u.ville=".injsql($_SESSION["ville"], $pdo).") OR (p.pour=6 AND u.ville=".injsql($_SESSION["ville"], $pdo)."))) ";}

				/*

				if($str_pour==1){$str_where.=" AND p.pour=$str_pour AND u.pays=".injsql($_SESSION["pays"])." ";}

				if($str_pour==2){$str_where.=" AND p.pour=$str_pour AND u.ville=".injsql($_SESSION["ville"])." ";}

				*/

				if($str_pour==3){$str_where.=" AND (p.par=".injsql($_SESSION["userpk"], $pdo)." OR p.pour=$str_pour AND u.metier=".injsql($_SESSION["metier"], $pdo).") ";}

				if($str_pour==4){$str_where.=" AND (p.par=".injsql($_SESSION["userpk"], $pdo)." OR p.pour=$str_pour AND u.specialite=".injsql($_SESSION["specialite"], $pdo).") ";}

				if($str_pour==5){$str_where.=" AND (p.par=".injsql($_SESSION["userpk"], $pdo)." OR p.pour=$str_pour AND u.nom like ".injsql($_SESSION["nom"], $pdo).") ";}

				if($str_pour==6)

				{

					if(rqstprm("user")!=""){$str_where.=" AND p.par=".injsql(rqstprm("user"), $pdo)." ";}

					else{$str_where.=" AND p.par=".injsql($_SESSION["userpk"], $pdo)." ";}

				}

			}

			if($_SESSION["user_type"]==0)

			{

				if(rqstprm("txt_masquer")=="1"){$str_where.=" AND EXISTS(SELECT pm.id FROM posts_masquer pm WHERE pm.post=p.id) ";}

				else{$str_where.=" AND NOT EXISTS(SELECT pm.id FROM posts_masquer pm WHERE pm.post=p.id) ";}

				$str_col.=", COALESCE((SELECT COUNT(pm.id) FROM posts_masquer pm WHERE pm.post=p.id), 0) AS NBRCACHER ";

			}

			else{$str_where.=" AND NOT EXISTS(SELECT pm.id FROM posts_masquer pm WHERE pm.post=p.id AND pm.user_id=".injsql($_SESSION["userpk"], $pdo).") ";}

		}

		$str_orderby=" p.date_ajout DESC ";

		if($str_orderpost==1)

		{

			$str_where.=" AND p.date_ajout>=DATE_SUB(NOW(), INTERVAL 3 DAY) ";

			$str_orderby=" (NBRVUE+(NBRJAIME*2)+(NBRCMNT*3)) DESC ";

		}

		$strlimit=($dt_page*$nbrperpag).", ".$nbrperpag;

		if($nbr>0){$strlimit=" 0, $nbr ";}

		$req = "SELECT p.id, p.detail, p.image AS IMGPOST, p.par, p.pour, p.date_ajout, p.youtube,p.trophy, u.id AS USERID, u.nom AS USERNOM, u.prenom AS USERPNOM, u.image AS IMGUSER

						, py.nom_".$_SESSION["lang"]." AS NOMPAYS, v.nom_".$_SESSION["lang"]." AS NOMVILLE, m.nom_".$_SESSION["lang"]." AS NOMMETIER, s.nom_".$_SESSION["lang"]." AS NOMSPECIAL

						$str_col

						, COALESCE((SELECT DATE_ADD(max(pv2.date_ajout), INTERVAL 1 HOUR) FROM posts_vue pv2 WHERE pv2.post=p.id AND pv2.user_id=".injsql($_SESSION["userpk"], $pdo)."), '') AS DTMAXVUE

						, COALESCE((SELECT COUNT(*) FROM posts_vue pv WHERE pv.post=p.id), 0) AS NBRVUE

						, COALESCE((SELECT COUNT(*) FROM posts_comment pc WHERE pc.post=p.id), 0) AS NBRCMNT

						, COALESCE((SELECT COUNT(*) FROM posts_jaime pj WHERE pj.post=p.id), 0) AS NBRJAIME

						, COALESCE((SELECT COUNT(*) FROM posts_jaime pj WHERE pj.post=p.id AND pj.user_id='".$_SESSION["userpk"]."'), 0) AS NBRUSRJIM

				FROM posts p

				JOIN user u ON u.id=p.par AND u.user_vld=1

				LEFT JOIN pays py ON py.id=u.pays

				LEFT JOIN ville v ON v.id=u.ville

				LEFT JOIN metier m ON m.id=u.metier

				LEFT JOIN metier_specialiste s ON s.id=u.specialite

				WHERE 1=1 AND p.date_ajout>=DATE_SUB(NOW(), INTERVAL 3 DAY)

				ORDER BY (NBRVUE+(NBRJAIME*2)+(NBRCMNT*3)) DESC

				LIMIT 0, 5";

		$dt_result=bddfetch($req, $pdo);
        $array_odd=array_filter($dt_result, function($k) {
                             return $k%2 != 0;
                  }, ARRAY_FILTER_USE_KEY);
        $array_even=array_filter($dt_result, function($k) {
                             return $k%2 == 0;
                  }, ARRAY_FILTER_USE_KEY);
		$i=0;

		if(rqstprm("txt_search")!="" && !$is_adminsrch){echo "<div class='company-title' style='padding:0px;' ><h3>".get_label('lbl_resultpour')." ".rqstprm("txt_search")."</h3></div>";}

		$str_html="";$str_descrpost=""; $str_imagepost="";?>
        <div class='col-md-6 no-padding-colmd posts-div no-padding-left'>
		<?php foreach($array_even as $key=>$line)

		{
            $is_addvisit=true;

			if($line["DTMAXVUE"]!="")

			{

				if(strtotime(date("Y-m-d H:i:s"))<strtotime($line["DTMAXVUE"])){$is_addvisit=false;}

			}

			if($is_addvisit)

			{

				$req = "INSERT INTO posts_vue(user_id, post) VALUES(".injsql(htmlspecialchars($_SESSION["userpk"]), $pdo).", ".$line["id"].");";

				bddmaj($req, $pdo);
				updatePosition($pdo);

			}

			$str_html.="";

			$str_profiluser="javascript:void(0)";

			if($line['USERID']!=$_SESSION["userpk"]){$str_profiluser=$strurlsite."mon-profil.php?s=post&user=".$line['USERID'];}

			else{$str_profiluser=$strurlsite."mon-profil.php?s=post";}

			?>

			<div class='col-md-12 ' >

				<div class='posty' id='dv_post_<?php echo $line['id'].'_'.$str_pour; ?>' style='<?php echo $str_styleglb; ?>' >

					<div class='post-bar no-margin'>

						<div class='post_topbar'>

							<div class='usy-dt'>

								<a href="<?php echo $str_profiluser; ?>" >

									<div class='usr-pic-profil' style="background-image: url(<?php echo img_userdef($line['IMGUSER']); ?>);" >

									    <img src='images/trone.png' height='70' width='70' style='float: right;position: relative;left: 10px;top:-5px;'>

									</div>                        

								</a>

								<div class='usy-name'>

									<h3 style='font-size:11pt;padding:0px;' >

										<a href="<?php echo $str_profiluser; ?>" >

										<?php

										echo $line['USERPNOM'].' '.$line['USERNOM'];

										if($line['NBRCACHER']>0)

										{

											$str_foi=get_label('lbl_foi'); if($line['NBRCACHER']>1){$str_foi=get_label('lbl_fois');}

											echo "<span style='color:red;' > (".get_label('lbl_masquer')." ".$line['NBRCACHER']." ".strtolower($str_foi).")</span>";

										}

										?>

										</a>

									</h3>

									<span><!--<img src='<?php echo $strurlsite; ?>images/clock.png' alt=''>--> <?php echo formatdate($line['date_ajout'], 'd/m/Y H:i'); ?></span>
									<div>
										<?php

											$str_vilapay="<b style='color:#A3A3A3;font-size: 14px;' >".$line["NOMVILLE"]."</b>";

											if($line["NOMPAYS"]!=""){if($str_vilapay!=""){$str_vilapay.=" - ";}$str_vilapay.="<b style='color:#A3A3A3;font-size: 14px;' >".$line["NOMPAYS"]."</b>";}

											if($str_vilapay!="")

											{

												echo /*"<img src='".$strurlsite."images/icon-map.png' style='height:13px;' class='mr-2' alt='' />*/ 

														"<span>".$str_vilapay."</span>";

											}

						                ?>
									</div>

								</div>

							</div>

							<?php if($is_connect){ ?>

							<div class='ed-opts'>

								
                             <?php if($line['par']==$_SESSION['userpk'] || $_SESSION['user_type']==0){ ?>
                             	<a href='javascript:void(0)' title='' class='ed-opts-open' onclick='show_pst(this);' ><i class='la la-ellipsis-v'></i></a>
								<ul class='ed-options'>

									

									<li>

										<input type='hidden' id='txt_youtube_<?php echo $line['id'].'_'.$str_pour; ?>' value='<?php echo $line['youtube']; ?>' />

										<b onclick="updatepost('<?php echo $line['id']."', '".$str_pour; ?>');" ><?php echo get_label("lbl_modifier"); ?></b>

									</li>

									<li><b style='color:red;' onclick="deletepost('<?php echo $line['id']."', '".$str_pour; ?>', 0);" ><?php echo get_label("lbl_supprimer"); ?></b></li>

									<?php if($line['par']!=$_SESSION['userpk']){ ?>

									<!--<li><b onclick="deletepost('<?php echo $line['id']."', '".$str_pour; ?>', 1);" ><?php echo get_label("lbl_masquer"); ?></b></li>-->

									<?php } ?>

								</ul>
                            <?php } ?>
							</div>

							<?php } ?>

							<?php
							/*if(isset($_GET['orderpst']))

										{

      										if($_GET['orderpst'] == 1)

												{*/

									if(($key == 0 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==1)){

		 								echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me1.png' width='35' height='45' style='float: right;'></a>";

									}

									if($str_pour == 6 && $line['trophy']==2){

										echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me2.png' width='32' height='40' style='float: right;'></a>";

									}

									if(($key == 2 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==3)){

										echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me3.png' width='32' height='40' style='float: right;'></a>";

									}

									if($str_pour == 6 && $line['trophy']==4){

										echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me4.jpg' width='32' height='40' style='float: right;'></a>";

									}

									if(($key == 4 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==5)){

										echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me5.jpg' width='32' height='40' style='float: right;'></a>";

									}
									/*}

										}*/

							?>

						</div>

						<div class='epi-sec' style='<?php if(isphone()){echo "display:none;";} ?>display:none;' >

							<ul class='descp'>

								<?php 

								$str_metspec=$line['NOMSPECIAL'];

								if($line["NOMMETIER"]!=""){if($str_metspec!=""){$str_metspec.=" - ";}$str_metspec.=$line["NOMMETIER"];}

								if($str_metspec!=""){echo "<li><img src='".$strurlsite."images/icon8.png' alt='' /><span>".$str_metspec."</span></li>";}

								

								/*

								$str_vilapay=$line["NOMVILLE"];

								if($line["NOMPAYS"]!=""){if($str_vilapay!=""){$str_vilapay.=" - ";}$str_vilapay.=$line["NOMPAYS"];}

								if($str_vilapay!=""){echo "<li><img src='".$strurlsite."images/icon9.png' alt='' /><span>".$str_vilapay."</span></li>";}

								*/

								if($str_pour==6)

								{

									$str_pourtxt=get_label("lbl_monde"); $str_class="globe";

									if($line["pour"]==1){$str_pourtxt=$str_pour_pay; $str_class="flag";}

									if($line["pour"]==2){$str_pourtxt=$str_pour_ville; $str_class="map-marker";}

									if($line["pour"]==3){$str_pourtxt=$str_pour_metier; $str_class="briefcase";}

									if($line["pour"]==4){$str_pourtxt=$str_pour_special; $str_class="tags";}

									if($line["pour"]==5){$str_pourtxt=$str_pour_famille; $str_class="group";}

									if($line["pour"]==6){$str_pourtxt=get_label("lbl_mon_profil"); $str_class="user";}

									echo "<li><span><i class='la la-$str_class' ></i> ".$str_pourtxt."</span></li>";

								}

								?>

							</ul>

						</div>

						<div class='job_descp'>

							<?php 

							$str_detail=htmlspecialchars($line["detail"]);

							if(strlen($str_detail)>250)

							{?>

								<p id='p_resumer_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>'><?php echo substr($str_detail, 0, indexof($str_detail, ' ', 300))?>... <span class='pl' style='color: #fd8222;'   onclick="hide('p_resumer_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>');show('p_detail_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>');show('cacher_share_<?php echo $line['id']; ?>');show('cacher_comment_<?php echo $line['id']; ?>');show('comments_label_<?php echo $line['id']; ?>');<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "set_vue('".$line['id']."', '".$str_pour."');";} ?>" ><?php echo get_label('plus') ?></span></p>
								<p id='p_detail_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>' style='display:none;' ><?php echo Replace($str_detail, "\n", "<br />"); ?></p>

							<?php

						    }

							else{echo "<p id='p_detail_".$line['id'].'_'.$str_pour."' >".Replace($str_detail, "\n", "<br />")."</p>";}

							$str_urlshare=$strurlsite."post.php?pid=".$line['id'];

							$str_descrpost=substr($str_detail, 0, 250)."...";

							/*

							$str_cntnt = preg_replace_callback('~\b(?:https?|ftp|file)://\S+~i', function($v){

										if(preg_match('~\.jpe?g|\.png|\.gif|\.bmp$~i', $v[0])){return '<img src="' . $v[0] . '" />';}

										else{return '<a href="' . $v[0] . '" target="_blank" >' . $v[0] . '</a>';}

									}, $line["detail"]);

							*/

							if($line["youtube"]!="" && (indexof($line["youtube"], "youtu.be")>0 || indexof($line["youtube"], "youtube")>0))

							{

								$str_urlyoutube=$line["youtube"];

								if(indexof($str_urlyoutube, "watch?v=")>0){$str_urlyoutube=Replace($str_urlyoutube, "watch?v=", "embed/");}

								elseif(indexof($str_urlyoutube, "youtu.be/")>0){$str_urlyoutube=Replace($str_urlyoutube, "youtu.be/", "youtube.com/embed/");}

								elseif(indexof($str_urlyoutube, "youtu.be")>0){$str_urlyoutube=Replace($str_urlyoutube, "youtu.be", "youtube.com/embed");}

								if(indexof($str_urlyoutube, "m.youtube")>0){$str_urlyoutube=Replace($str_urlyoutube, "m.youtube", "youtube");}

								elseif(indexof($str_urlyoutube, "m.youtu")>0){$str_urlyoutube=Replace($str_urlyoutube, "m.youtu", "youtube");}

								echo "<iframe style='width:100%;height:400px;border:none;' src='".$str_urlyoutube."' name='iframe1' frameborder='0'  allow='autoplay; encrypted-media' allowfullscreen></iframe>";

							}

							if($line["IMGPOST"]!=""){echo "<img src='".$strurlsite.$line["IMGPOST"]."' style='max-width:100%;margin-bottom:20px;' alt='' />";}

							echo "<div style='clear:both;' ></div>";

							$strliens="";$chrf=1;

							preg_match_all('/\b(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i', $line["detail"], $resulthrf, PREG_PATTERN_ORDER);

							foreach($resulthrf as $hrf)

							{

								if(isset($hrf[0])){$strliens.="<a href='".$hrf[0]."' class='btn_urlpost' target='_blank' >".substr($hrf[0], 0, 50)."... <i class='fa fa-external-link' ></i></a>";}

							}

							if($strliens!=""){echo "<p>".$strliens."</p>";}

							$str_imagepost=$line["IMGPOST"];

							?>

							<input type='hidden' id='txt_detail_<?php echo $line['id'].'_'.$str_pour; ?>' value='<?php echo $line['detail']; ?>'  />

						<div class="cacher" id="cacher_share_<?php echo $line['id'];?>">

							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $str_urlshare; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="btnShare btn_share btn_facebook" >

								<i class='fa fa-facebook' ></i> <?php echo get_label("lbl_partager"); ?>

							</a>

							<!--

							<a href="<?php echo $str_urlshare; ?>" data-image="<?php echo $str_imagepost; ?>" data-title="<?php echo get_sitename(); ?>" data-desc="<?php echo $str_descrpost; ?>" class="btnShare btn_share btn_facebook">

								<i class='fa fa-facebook' ></i> <?php echo get_label("lbl_partager"); ?>

							</a>

							<script>$('.btn_facebook').click(function(){ elem = $(this); postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image')); return false; });</script>

							<script src="https://apis.google.com/js/platform.js" async defer></script>

							<div class="g-plus" data-action="share" data-href="<?php echo $str_urlshare; ?>"></div>

							-->

							<a href="https://plus.google.com/share?url=<?php echo $str_urlshare; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="btnShare btn_share btn_google" >

								<i class='fa fa-google-plus' ></i> <?php echo get_label("lbl_partager"); ?>

							</a>

							<div id='dv_btnurlshare_<?php echo $line['id'].'_'.$str_pour; ?>' class="btn_share" onclick="showb('b_urlshare_<?php echo $line['id'].'_'.$str_pour; ?>');hide('dv_btnurlshare_<?php echo $line['id'].'_'.$str_pour; ?>');$('#b_urlshare_<?php echo $line['id'].'_'.$str_pour; ?>').focus().select();" >

								<i class='fa fa-url' ></i> <?php echo get_label("lbl_copylien"); ?>

							</div>

						</div>

							<input type='text' id='b_urlshare_<?php echo $line['id'].'_'.$str_pour; ?>' style='display:none;' value="<?php echo $str_urlshare; ?>" />

						</div>

						<div class='job-status-bar'>

							<ul class='like-com'>

								<li class='sp_cmntlik' onclick="<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "set_jaime('".$line['id']."', '".$str_pour."');";}else{echo "redirect('".$strurlsite."?pid=".$str_id."');";} ?>" >

									<i class='la la-heart' id='i_icojaime_<?php echo $line['id'].'_'.$str_pour; ?>' style='<?php if($line["NBRUSRJIM"]>0){echo 'color:orange;';} ?>cursor:pointer;' ></i>

									<?php

									echo "<b id='b_nbrjaime_".$line['id'].'_'.$str_pour."' >".$line["NBRJAIME"]."</b> ";

									if(!isphone() && 1==0){echo get_label("lbl_jaime");}

									?>

									<input type='hidden' id='txt_isuserjaime_<?php echo $line['id'].'_'.$str_pour; ?>' value='<?php echo $line["NBRUSRJIM"]; ?>' />

								</li> 

								<li class='sp_cmntlik comment-link' onclick="show('cacher_comment_<?php echo $line['id']; ?>');show('comments_label_<?php echo $line['id']; ?>');">

									<i class='la la-comment'></i>

									<?php

									echo "<b id='b_nbrcmntr_".$line['id'].'_'.$str_pour."' >".$line["NBRCMNT"]."</b>";

									if(!isphone() && 1==0){

										if($line["NBRCMNT"]>1){echo " ".get_label("lbl_commentaires");}

										else{echo " ".get_label("lbl_commentaire");}

									}

									?>

								</li>

								<li class='sp_cmntlik' >

									<i class='la la-eye'></i>

									<?php

									echo "<b id='b_nbrvue_".$line['id'].'_'.$str_pour."' >".$line["NBRVUE"]."</b>";

									if(!isphone() && 1==0){

										if($line["NBRVUE"]>1){echo " ".get_label("lbl_vues");}

										else{echo " ".get_label("lbl_vue");}

									}

									?>

								</li>

								<?php

								$req="SELECT COUNT(*) AS NBRTOT FROM user_abonne ub WHERE ub.user_id=".injsql($line["par"], $pdo)." AND abonne_del=0;";

								$dt_abonne=bddfetch($req, $pdo);

								$nbr_folow=$dt_abonne[0]["NBRTOT"];

								$nbrcrntabon=get_btn_suivi($line["par"], $pdo, '', true);

								$strstylabon="";

								if($nbrcrntabon>0){$strstylabon="color:orange;";}

								?>

								<li class='sp_cmntlik' style='<?php echo $strstylabon; ?>' id='li_abonne_<?php echo $line["id"]; ?>' onclick="<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "init_abonne('".$line["id"]."', ".$line["par"].", ".$_SESSION["userpk"].");";} ?>" >

									<?php

									if($nbr_folow<=0){echo "<i class='la la-hand-rock-o' id='i_icoabone_".$line["id"]."' ></i>";}

									else{echo "<i class='la la-hand-pointer-o' id='i_icoabone_".$line["id"]."' ></i>";}

									echo "<b id='sp_nbrabone_".$line["id"]."' >$nbr_folow</b>";

									//if(!isphone()){

										if($nbr_folow>1){echo " ".get_label("lbl_suivis");}

										else{echo " ".get_label("lbl_suivi");}

									//}

									?>

									<input type='hidden' id="txt_isabonne_<?php echo $line["id"]; ?>" value="<?php echo $nbrcrntabon; ?>" />

								</li>

							</ul>

						</div>

					</div><!--post-bar end-->
					<div class="job-status-bar comments-label" id="comments_label_<?php echo $line['id'];?>">

						<ul class="like-com">

							<li class="sp_cmntlik">

								<b id="com_title"><?php echo get_label("lbl_commentaires"); ?></b>

							</li> 

						</ul>

					</div>
					<div class='comment-section' id="cacher_comment_<?php echo $line['id'];?>">

						<?php

						$req = "SELECT pc.id, pc.post, pc.user_id, pc.detail, pc.date_ajout, u.image, u.prenom, u.nom

								FROM posts_comment pc

								JOIN user u ON u.id=pc.user_id

								WHERE pc.post=".injsql($line["id"], $pdo)."

								ORDER BY pc.date_ajout";

						$dt_cmnt=bddfetch($req, $pdo);

						?>
						

						<div class='comment-sec'>

							<ul id='ul_cmentaire_<?php echo $line['id'].'_'.$str_pour; ?>' >

								<?php

								if(count($dt_cmnt)>0)

								{

									foreach($dt_cmnt as $line_cmnt)

									{

										$str_profiluser="javascript:void(0)";

										if($line_cmnt['user_id']!=$_SESSION["userpk"]){$str_profiluser=$strurlsite."profil/".canlcaract($line_cmnt['prenom'].$line_cmnt['nom'])."/?s=post&user=".$line_cmnt['user_id'];}

										else{$str_profiluser=$strurlsite."profil/".canlcaract($line_cmnt['prenom'].$line_cmnt['nom'])."/?s=post";}

										?>

										<li id='li_cmentaire_<?php echo $line['id'].'_'.$line_cmnt['id'].'_'.$str_pour; ?>' >

											<div class='comment-list'>

												<div class='bg-img'>

													<a href="<?php echo $str_profiluser; ?>" >

														<div class='usr-pic-profil' style='background-image:url(<?php echo img_userdef($line_cmnt['image']); ?>);' ></div>

													</a>

												</div>

												<div class='comment'>

													<h3>

														<a href="<?php echo $str_profiluser; ?>" ><?php echo $line_cmnt['prenom'].' '.$line_cmnt['nom']; ?></a>

													</h3>

													<span><img src='<?php echo $strurlsite; ?>images/clock.png' alt=''> <?php echo formatdate($line_cmnt['date_ajout'], 'd/m/Y H:i'); ?></span>

													<p><?php echo Replace($line_cmnt['detail'], "<", "< "); ?></p>

													<?php if($is_connect && ($line_cmnt['user_id']==$_SESSION['userpk'] || $line['par']==$_SESSION['userpk'] || $_SESSION['user_type']==0)){ ?>

														<b class='btn_delcmnt' onclick="deletecmntr('<?php echo $line['id']."', '".$str_pour; ?>', '<?php echo $line_cmnt['id']; ?>');" ><?php echo get_label("lbl_supprimer"); ?></b>

													<?php } ?>

												</div>

											</div>

										</li>

										<?php 

									} 

								}?>

							</ul>

						</div>

						<div class='post-comment'>

							<div class='comment_box'>

								<?php if($is_connect){ ?>

								<input type='text' id='txt_comentaire_<?php echo $line['id'].'_'.$str_pour; ?>' placeholder='<?php echo get_label("lbl_yourcmnt"); ?>' required />

								<button class='btncmnt' onclick="set_comnt('<?php echo $line['id'].'_'.$str_pour; ?>');" ><?php echo get_label("lbl_commenter"); ?></button>

								<?php }else{ ?>

								<button class='btncmnt' onclick="redirect('<?php echo $strurlsite."?pid=".$str_id; ?>');" ><?php echo get_label("lbl_commenter"); ?></button>

								<?php } ?>

							</div>

						</div>

					</div>

				</div>

			</div>

			<?php

			$i++;

		} ?>
        </div>
        <div class='col-md-6 no-padding-colmd posts-div no-padding-right'>
		<?php foreach($array_odd as $key=>$line)

		{

			$is_addvisit=true;

			if($line["DTMAXVUE"]!="")

			{

				if(strtotime(date("Y-m-d H:i:s"))<strtotime($line["DTMAXVUE"])){$is_addvisit=false;}

			}

			if($is_addvisit)

			{

				$req = "INSERT INTO posts_vue(user_id, post) VALUES(".injsql(htmlspecialchars($_SESSION["userpk"]), $pdo).", ".htmlspecialchars($line["id"]).");";

				bddmaj($req, $pdo);
				updatePosition($pdo);

			}

			$str_html.="";

			$str_profiluser="javascript:void(0)";

			if($line['USERID']!=$_SESSION["userpk"]){$str_profiluser=$strurlsite."mon-profil.php?s=post&user=".$line['USERID'];}

			else{$str_profiluser=$strurlsite."mon-profil.php?s=post";}

			?>

			<div class='col-md-12' >

				<div class='posty' id='dv_post_<?php echo $line['id'].'_'.$str_pour; ?>' style='<?php echo $str_styleglb; ?>' >

					<div class='post-bar no-margin'>

						<div class='post_topbar'>

							<div class='usy-dt'>

								<a href="<?php echo $str_profiluser; ?>" >

									<div class='usr-pic-profil' style="background-image: url(<?php echo img_userdef($line['IMGUSER']); ?>);" >

									    <img src='images/trone.png' height='70' width='70' style='float: right;position: relative;left: 10px;top:-5px;'>

									</div>                        

								</a>

								<div class='usy-name'>

									<h3 style='font-size:11pt;padding:0px;' >

										<a href="<?php echo $str_profiluser; ?>" >

										<?php

										echo $line['USERPNOM'].' '.$line['USERNOM'];

										if($line['NBRCACHER']>0)

										{

											$str_foi=get_label('lbl_foi'); if($line['NBRCACHER']>1){$str_foi=get_label('lbl_fois');}

											echo "<span style='color:red;' > (".get_label('lbl_masquer')." ".$line['NBRCACHER']." ".strtolower($str_foi).")</span>";

										}

										?>

										</a>

									</h3>

									<span><!--<img src='<?php echo $strurlsite; ?>images/clock.png' alt=''>--> <?php echo formatdate($line['date_ajout'], 'd/m/Y H:i'); ?></span>
									<div>
										<?php

											$str_vilapay="<b style='color:#A3A3A3;font-size: 14px;' >".$line["NOMVILLE"]."</b>";

											if($line["NOMPAYS"]!=""){if($str_vilapay!=""){$str_vilapay.=" - ";}$str_vilapay.="<b style='color:#A3A3A3;font-size: 14px;' >".$line["NOMPAYS"]."</b>";}

											if($str_vilapay!="")

											{

												echo /*"<img src='".$strurlsite."images/icon-map.png' style='height:13px;' class='mr-2' alt='' />*/ 

														"<span>".$str_vilapay."</span>";

											}

						                ?>
									</div>

								</div>

							</div>

							<?php if($is_connect){ ?>

							<div class='ed-opts'>

								
                             <?php if($line['par']==$_SESSION['userpk'] || $_SESSION['user_type']==0){ ?>
                             	<a href='javascript:void(0)' title='' class='ed-opts-open' onclick='show_pst(this);' ><i class='la la-ellipsis-v'></i></a>
								<ul class='ed-options'>
									<li>

										<input type='hidden' id='txt_youtube_<?php echo $line['id'].'_'.$str_pour; ?>' value='<?php echo $line['youtube']; ?>' />

										<b onclick="updatepost('<?php echo $line['id']."', '".$str_pour; ?>');" ><?php echo get_label("lbl_modifier"); ?></b>

									</li>

									<li><b style='color:red;' onclick="deletepost('<?php echo $line['id']."', '".$str_pour; ?>', 0);" ><?php echo get_label("lbl_supprimer"); ?></b></li>

									

									<?php if($line['par']!=$_SESSION['userpk']){ ?>

									<!--<li><b onclick="deletepost('<?php echo $line['id']."', '".$str_pour; ?>', 1);" ><?php echo get_label("lbl_masquer"); ?></b></li>-->
                                   <?php } ?>
									

								</ul>
                             <?php } ?>
							</div>

							<?php } ?>

							<?php
							/*if(isset($_GET['orderpst']))

										{

      										if($_GET['orderpst'] == 1)

												{*/

									if($str_pour == 6 && $line['trophy']==1){

										echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me1.png' width='32' height='40' style='float: right;'></a>";

									}

									if(($key == 1 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==2)){

										echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me2.png' width='32' height='40' style='float: right;'></a>";

									}

									if($str_pour == 6 && $line['trophy']==3){

										echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me3.png' width='32' height='40' style='float: right;'></a>";

									}
									if(($key == 3 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==4)){

										echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me4.jpg' width='32' height='40' style='float: right;'></a>";

									}

									if($str_pour == 6 && $line['trophy']==5){

										echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me5.jpg' width='32' height='40' style='float: right;'></a>";

									}
								/*}

							}*/

							?>

						</div>

						<div class='epi-sec' style='<?php if(isphone()){echo "display:none;";} ?>display:none;' >

							<ul class='descp'>

								<?php 

								$str_metspec=$line['NOMSPECIAL'];

								if($line["NOMMETIER"]!=""){if($str_metspec!=""){$str_metspec.=" - ";}$str_metspec.=$line["NOMMETIER"];}

								if($str_metspec!=""){echo "<li><img src='".$strurlsite."images/icon8.png' alt='' /><span>".$str_metspec."</span></li>";}

								

								/*

								$str_vilapay=$line["NOMVILLE"];

								if($line["NOMPAYS"]!=""){if($str_vilapay!=""){$str_vilapay.=" - ";}$str_vilapay.=$line["NOMPAYS"];}

								if($str_vilapay!=""){echo "<li><img src='".$strurlsite."images/icon9.png' alt='' /><span>".$str_vilapay."</span></li>";}

								*/

								if($str_pour==6)

								{

									$str_pourtxt=get_label("lbl_monde"); $str_class="globe";

									if($line["pour"]==1){$str_pourtxt=$str_pour_pay; $str_class="flag";}

									if($line["pour"]==2){$str_pourtxt=$str_pour_ville; $str_class="map-marker";}

									if($line["pour"]==3){$str_pourtxt=$str_pour_metier; $str_class="briefcase";}

									if($line["pour"]==4){$str_pourtxt=$str_pour_special; $str_class="tags";}

									if($line["pour"]==5){$str_pourtxt=$str_pour_famille; $str_class="group";}

									if($line["pour"]==6){$str_pourtxt=get_label("lbl_mon_profil"); $str_class="user";}

									echo "<li><span><i class='la la-$str_class' ></i> ".$str_pourtxt."</span></li>";

								}

								?>

							</ul>

						</div>

						<div class='job_descp'>

							<?php 

							$str_detail=htmlspecialchars($line["detail"]);

							if(strlen($str_detail)>250)

							{?>

								<p id='p_resumer_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>'><?php echo substr($str_detail, 0, indexof($str_detail, ' ', 300))?>... <span class='pl' style='color: #fd8222;'   onclick="hide('p_resumer_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>');show('p_detail_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>');show('cacher_share_<?php echo $line['id']; ?>');show('cacher_comment_<?php echo $line['id']; ?>');show('comments_label_<?php echo $line['id']; ?>');<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "set_vue('".$line['id']."', '".$str_pour."');";} ?>" ><?php echo get_label('plus') ?></span></p>
								<p id='p_detail_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>' style='display:none;' ><?php echo Replace($str_detail, "\n", "<br />"); ?></p>

							<?php

						    }

							else{echo "<p id='p_detail_".$line['id'].'_'.$str_pour."' >".Replace($str_detail, "\n", "<br />")."</p>";}

							$str_urlshare=$strurlsite."post.php?pid=".$line['id'];

							$str_descrpost=substr($str_detail, 0, 250)."...";

							/*

							$str_cntnt = preg_replace_callback('~\b(?:https?|ftp|file)://\S+~i', function($v){

										if(preg_match('~\.jpe?g|\.png|\.gif|\.bmp$~i', $v[0])){return '<img src="' . $v[0] . '" />';}

										else{return '<a href="' . $v[0] . '" target="_blank" >' . $v[0] . '</a>';}

									}, $line["detail"]);

							*/

							if($line["youtube"]!="" && (indexof($line["youtube"], "youtu.be")>0 || indexof($line["youtube"], "youtube")>0))

							{

								$str_urlyoutube=$line["youtube"];

								if(indexof($str_urlyoutube, "watch?v=")>0){$str_urlyoutube=Replace($str_urlyoutube, "watch?v=", "embed/");}

								elseif(indexof($str_urlyoutube, "youtu.be/")>0){$str_urlyoutube=Replace($str_urlyoutube, "youtu.be/", "youtube.com/embed/");}

								elseif(indexof($str_urlyoutube, "youtu.be")>0){$str_urlyoutube=Replace($str_urlyoutube, "youtu.be", "youtube.com/embed");}

								if(indexof($str_urlyoutube, "m.youtube")>0){$str_urlyoutube=Replace($str_urlyoutube, "m.youtube", "youtube");}

								elseif(indexof($str_urlyoutube, "m.youtu")>0){$str_urlyoutube=Replace($str_urlyoutube, "m.youtu", "youtube");}

								echo "<iframe style='width:100%;height:400px;border:none;' src='".$str_urlyoutube."' name='iframe1' frameborder='0'  allow='autoplay; encrypted-media' allowfullscreen></iframe>";

							}

							if($line["IMGPOST"]!=""){echo "<img src='".$strurlsite.$line["IMGPOST"]."' style='max-width:100%;margin-bottom:20px;' alt='' />";}

							echo "<div style='clear:both;' ></div>";

							$strliens="";$chrf=1;

							preg_match_all('/\b(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i', $line["detail"], $resulthrf, PREG_PATTERN_ORDER);

							foreach($resulthrf as $hrf)

							{

								if(isset($hrf[0])){$strliens.="<a href='".$hrf[0]."' class='btn_urlpost' target='_blank' >".substr($hrf[0], 0, 50)."... <i class='fa fa-external-link' ></i></a>";}

							}

							if($strliens!=""){echo "<p>".$strliens."</p>";}

							$str_imagepost=$line["IMGPOST"];

							?>

							<input type='hidden' id='txt_detail_<?php echo $line['id'].'_'.$str_pour; ?>' value='<?php echo $line['detail']; ?>'  />

						<div class="cacher" id="cacher_share_<?php echo $line['id'];?>">

							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $str_urlshare; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="btnShare btn_share btn_facebook" >

								<i class='fa fa-facebook' ></i> <?php echo get_label("lbl_partager"); ?>

							</a>

							<!--

							<a href="<?php echo $str_urlshare; ?>" data-image="<?php echo $str_imagepost; ?>" data-title="<?php echo get_sitename(); ?>" data-desc="<?php echo $str_descrpost; ?>" class="btnShare btn_share btn_facebook">

								<i class='fa fa-facebook' ></i> <?php echo get_label("lbl_partager"); ?>

							</a>

							<script>$('.btn_facebook').click(function(){ elem = $(this); postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image')); return false; });</script>

							<script src="https://apis.google.com/js/platform.js" async defer></script>

							<div class="g-plus" data-action="share" data-href="<?php echo $str_urlshare; ?>"></div>

							-->

							<a href="https://plus.google.com/share?url=<?php echo $str_urlshare; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="btnShare btn_share btn_google" >

								<i class='fa fa-google-plus' ></i> <?php echo get_label("lbl_partager"); ?>

							</a>

							<div id='dv_btnurlshare_<?php echo $line['id'].'_'.$str_pour; ?>' class="btn_share" onclick="showb('b_urlshare_<?php echo $line['id'].'_'.$str_pour; ?>');hide('dv_btnurlshare_<?php echo $line['id'].'_'.$str_pour; ?>');$('#b_urlshare_<?php echo $line['id'].'_'.$str_pour; ?>').focus().select();" >

								<i class='fa fa-url' ></i> <?php echo get_label("lbl_copylien"); ?>

							</div>

						</div>

							<input type='text' id='b_urlshare_<?php echo $line['id'].'_'.$str_pour; ?>' style='display:none;' value="<?php echo $str_urlshare; ?>" />

						</div>

						<div class='job-status-bar'>

							<ul class='like-com'>

								<li class='sp_cmntlik' onclick="<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "set_jaime('".$line['id']."', '".$str_pour."');";}else{echo "redirect('".$strurlsite."?pid=".$str_id."');";} ?>" >

									<i class='la la-heart' id='i_icojaime_<?php echo $line['id'].'_'.$str_pour; ?>' style='<?php if($line["NBRUSRJIM"]>0){echo 'color:orange;';} ?>cursor:pointer;' ></i>

									<?php

									echo "<b id='b_nbrjaime_".$line['id'].'_'.$str_pour."' >".$line["NBRJAIME"]."</b> ";

									if(!isphone() && 1==0){echo get_label("lbl_jaime");}

									?>

									<input type='hidden' id='txt_isuserjaime_<?php echo $line['id'].'_'.$str_pour; ?>' value='<?php echo $line["NBRUSRJIM"]; ?>' />

								</li> 

								<li class='sp_cmntlik comment-link' onclick="show('cacher_comment_<?php echo $line['id']; ?>');show('comments_label_<?php echo $line['id']; ?>');">

									<i class='la la-comment'></i>

									<?php

									echo "<b id='b_nbrcmntr_".$line['id'].'_'.$str_pour."' >".$line["NBRCMNT"]."</b>";

									if(!isphone() && 1==0){

										if($line["NBRCMNT"]>1){echo " ".get_label("lbl_commentaires");}

										else{echo " ".get_label("lbl_commentaire");}

									}

									?>

								</li>

								<li class='sp_cmntlik' >

									<i class='la la-eye'></i>

									<?php

									echo "<b id='b_nbrvue_".$line['id'].'_'.$str_pour."' >".$line["NBRVUE"]."</b>";

									if(!isphone() && 1==0){

										if($line["NBRVUE"]>1){echo " ".get_label("lbl_vues");}

										else{echo " ".get_label("lbl_vue");}

									}

									?>

								</li>

								<?php

								$req="SELECT COUNT(*) AS NBRTOT FROM user_abonne ub WHERE ub.user_id=".injsql($line["par"], $pdo)." AND abonne_del=0;";

								$dt_abonne=bddfetch($req, $pdo);

								$nbr_folow=$dt_abonne[0]["NBRTOT"];

								$nbrcrntabon=get_btn_suivi($line["par"], $pdo, '', true);

								$strstylabon="";

								if($nbrcrntabon>0){$strstylabon="color:orange;";}

								?>

								<li class='sp_cmntlik' style='<?php echo $strstylabon; ?>' id='li_abonne_<?php echo $line["id"]; ?>' onclick="<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "init_abonne('".$line["id"]."', ".$line["par"].", ".$_SESSION["userpk"].");";} ?>" >

									<?php

									if($nbr_folow<=0){echo "<i class='la la-hand-rock-o' id='i_icoabone_".$line["id"]."' ></i>";}

									else{echo "<i class='la la-hand-pointer-o' id='i_icoabone_".$line["id"]."' ></i>";}

									echo "<b id='sp_nbrabone_".$line["id"]."' >$nbr_folow</b>";

									//if(!isphone()){

										if($nbr_folow>1){echo " ".get_label("lbl_suivis");}

										else{echo " ".get_label("lbl_suivi");}

									//}

									?>

									<input type='hidden' id="txt_isabonne_<?php echo $line["id"]; ?>" value="<?php echo $nbrcrntabon; ?>" />

								</li>

							</ul>

						</div>

					</div><!--post-bar end-->

					<div class="job-status-bar comments-label" id="comments_label_<?php echo $line['id'];?>">

						<ul class="like-com">

							<li class="sp_cmntlik">

								<b id="com_title"><?php echo get_label("lbl_commentaires"); ?></b>

							</li> 

						</ul>

					</div>

					<div class='comment-section' id="cacher_comment_<?php echo $line['id'];?>">

						<?php

						$req = "SELECT pc.id, pc.post, pc.user_id, pc.detail, pc.date_ajout, u.image, u.prenom, u.nom

								FROM posts_comment pc

								JOIN user u ON u.id=pc.user_id

								WHERE pc.post=".injsql($line["id"], $pdo)."

								ORDER BY pc.date_ajout";

						$dt_cmnt=bddfetch($req, $pdo);

						?>

						<div class='comment-sec'>

							<ul id='ul_cmentaire_<?php echo $line['id'].'_'.$str_pour; ?>' >

								<?php

								if(count($dt_cmnt)>0)

								{

									foreach($dt_cmnt as $line_cmnt)

									{

										$str_profiluser="javascript:void(0)";

										if($line_cmnt['user_id']!=$_SESSION["userpk"]){$str_profiluser=$strurlsite."profil/".canlcaract($line_cmnt['prenom'].$line_cmnt['nom'])."/?s=post&user=".$line_cmnt['user_id'];}

										else{$str_profiluser=$strurlsite."profil/".canlcaract($line_cmnt['prenom'].$line_cmnt['nom'])."/?s=post";}

										?>

										<li id='li_cmentaire_<?php echo $line['id'].'_'.$line_cmnt['id'].'_'.$str_pour; ?>' >

											<div class='comment-list'>

												<div class='bg-img'>

													<a href="<?php echo $str_profiluser; ?>" >

														<div class='usr-pic-profil' style='background-image:url(<?php echo img_userdef($line_cmnt['image']); ?>);' ></div>

													</a>

												</div>

												<div class='comment'>

													<h3>

														<a href="<?php echo $str_profiluser; ?>" ><?php echo $line_cmnt['prenom'].' '.$line_cmnt['nom']; ?></a>

													</h3>

													<span><img src='<?php echo $strurlsite; ?>images/clock.png' alt=''> <?php echo formatdate($line_cmnt['date_ajout'], 'd/m/Y H:i'); ?></span>

													<p><?php echo Replace($line_cmnt['detail'], "<", "< "); ?></p>

													<?php if($is_connect && ($line_cmnt['user_id']==$_SESSION['userpk'] || $line['par']==$_SESSION['userpk'] || $_SESSION['user_type']==0)){ ?>

														<b class='btn_delcmnt' onclick="deletecmntr('<?php echo $line['id']."', '".$str_pour; ?>', '<?php echo $line_cmnt['id']; ?>');" ><?php echo get_label("lbl_supprimer"); ?></b>

													<?php } ?>

												</div>

											</div>

										</li>

										<?php 

									} 

								}?>

							</ul>

						</div>

						<div class='post-comment'>

							<div class='comment_box'>

								<?php if($is_connect){ ?>

								<input type='text' id='txt_comentaire_<?php echo $line['id'].'_'.$str_pour; ?>' placeholder='<?php echo get_label("lbl_yourcmnt"); ?>' required />

								<button class='btncmnt' onclick="set_comnt('<?php echo $line['id'].'_'.$str_pour; ?>');" ><?php echo get_label("lbl_commenter"); ?></button>

								<?php }else{ ?>

								<button class='btncmnt' onclick="redirect('<?php echo $strurlsite."?pid=".$str_id; ?>');" ><?php echo get_label("lbl_commenter"); ?></button>

								<?php } ?>

							</div>

						</div>

					</div>

				</div>

			</div>

			<?php

			$i++;

		} ?>
        </div>
		<?php return $i;

	}





	function get_htmlpost($dt_page, $str_pour,$pdo, $str_id='', $nbr=-1)

	{

		global $strurlsite, $nbrperpag, $is_adminsrch, $str_pour_pay, $str_pour_ville, $str_pour_metier, $str_pour_special, $str_pour_famille, $str_orderpost;

		$is_connect=is_user_login();

		$str_where=""; $str_col=", 0 NBRCACHER "; $str_styleglb="";

		if($str_id!=""){$str_where.=" AND p.id=".$str_id." ";$str_styleglb="border-radius: 0px;border-left: 0px;border-right: 0px;";}

		else

		{

			if(rqstprm("txt_search")!="")

			{

				$str_mocle=trim(rqstprm("txt_search"));

				$str_where.=" AND (p.detail like '%".Replace($str_mocle, "'", "''")."%' OR u.nom like '".Replace($str_mocle, "'", "''")."%' OR u.prenom like '".Replace($str_mocle, "'", "''")."%' OR CONCAT(u.prenom, ' ', u.nom) like '".Replace($str_mocle, "'", "''")."%' OR CONCAT(u.nom, ' ', u.prenom) like '".Replace($str_mocle, "'", "''")."%')";

			}

			if($is_adminsrch)

			{

				if(rqstprm("txt_pays")!=""){$str_where.=" AND u.pays=".injsql(rqstprm("txt_pays"), $pdo)." ";}

				if(rqstprm("txt_ville")!=""){$str_where.=" AND u.ville=".injsql(rqstprm("txt_ville"), $pdo)." ";}

				if(rqstprm("txt_metier")!=""){$str_where.=" AND u.metier=".injsql(rqstprm("txt_metier"), $pdo)." ";}

				if(rqstprm("txt_specialite")!=""){$str_where.=" AND u.specialite=".injsql(rqstprm("txt_specialite"), $pdo)." ";}

			}

			else

			{

				//if($str_pour==0){$str_where.=" AND p.pour=$str_pour ";}

				

				if($str_pour==1){$str_where.=" AND (p.par=".injsql($_SESSION["userpk"], $pdo)." OR ((p.pour=$str_pour AND u.pays=".injsql($_SESSION["pays"], $pdo).") OR (p.pour=2 AND v.pays=".injsql($_SESSION["pays"], $pdo).") OR (p.pour=6 AND u.pays=".injsql($_SESSION["pays"], $pdo)."))) ";}

				if($str_pour==2){$str_where.=" AND (p.par=".injsql($_SESSION["userpk"], $pdo)." OR ((p.pour=$str_pour AND u.ville=".injsql($_SESSION["ville"], $pdo).") OR (p.pour=6 AND u.ville=".injsql($_SESSION["ville"], $pdo)."))) ";}

				/*

				if($str_pour==1){$str_where.=" AND p.pour=$str_pour AND u.pays=".injsql($_SESSION["pays"])." ";}

				if($str_pour==2){$str_where.=" AND p.pour=$str_pour AND u.ville=".injsql($_SESSION["ville"])." ";}

				*/

				if($str_pour==3){$str_where.=" AND (p.par=".injsql($_SESSION["userpk"], $pdo)." OR p.pour=$str_pour AND u.metier=".injsql($_SESSION["metier"], $pdo).") ";}

				if($str_pour==4){$str_where.=" AND (p.par=".injsql($_SESSION["userpk"], $pdo)." OR p.pour=$str_pour AND u.specialite=".injsql($_SESSION["specialite"], $pdo).") ";}

				if($str_pour==5){$str_where.=" AND (p.par=".injsql($_SESSION["userpk"], $pdo)." OR p.pour=$str_pour AND u.nom like ".injsql($_SESSION["nom"], $pdo).") ";}

				if($str_pour==6)

				{

					if(rqstprm("user")!=""){$str_where.=" AND p.par=".injsql(rqstprm("user"), $pdo)." ";}

					else{$str_where.=" AND p.par=".injsql($_SESSION["userpk"], $pdo)." ";}

				}

			}

			if($_SESSION["user_type"]==0)

			{

				if(rqstprm("txt_masquer")=="1"){$str_where.=" AND EXISTS(SELECT pm.id FROM posts_masquer pm WHERE pm.post=p.id) ";}

				else{$str_where.=" AND NOT EXISTS(SELECT pm.id FROM posts_masquer pm WHERE pm.post=p.id) ";}

				$str_col.=", COALESCE((SELECT COUNT(pm.id) FROM posts_masquer pm WHERE pm.post=p.id), 0) AS NBRCACHER ";

			}

			else{$str_where.=" AND NOT EXISTS(SELECT pm.id FROM posts_masquer pm WHERE pm.post=p.id AND pm.user_id=".injsql($_SESSION["userpk"], $pdo).") ";}

		}

		$str_orderby=" p.date_ajout DESC ";

		if($str_orderpost==1)

		{

			$str_where.=" AND p.date_ajout>=DATE_SUB(NOW(), INTERVAL 3 DAY) ";

			$str_orderby=" (NBRVUE+(NBRJAIME*2)+(NBRCMNT*3)) DESC ";

		}

		$strlimit=($dt_page*$nbrperpag).", ".$nbrperpag;

		if($nbr>0){$strlimit=" 0, $nbr ";}

		$req = "SELECT p.id, p.detail, p.image AS IMGPOST, p.par, p.pour, p.date_ajout, p.youtube, p.trophy as trophy, u.id AS USERID, u.nom AS USERNOM, u.prenom AS USERPNOM, u.image AS IMGUSER

						, py.nom_".$_SESSION["lang"]." AS NOMPAYS, v.nom_".$_SESSION["lang"]." AS NOMVILLE, m.nom_".$_SESSION["lang"]." AS NOMMETIER, s.nom_".$_SESSION["lang"]." AS NOMSPECIAL

						$str_col

						, COALESCE((SELECT DATE_ADD(max(pv2.date_ajout), INTERVAL 1 HOUR) FROM posts_vue pv2 WHERE pv2.post=p.id AND pv2.user_id=".injsql($_SESSION["userpk"], $pdo)."), '') AS DTMAXVUE

						, COALESCE((SELECT COUNT(*) FROM posts_vue pv WHERE pv.post=p.id), 0) AS NBRVUE

						, COALESCE((SELECT COUNT(*) FROM posts_comment pc WHERE pc.post=p.id), 0) AS NBRCMNT

						, COALESCE((SELECT COUNT(*) FROM posts_jaime pj WHERE pj.post=p.id), 0) AS NBRJAIME

						, COALESCE((SELECT COUNT(*) FROM posts_jaime pj WHERE pj.post=p.id AND pj.user_id='".$_SESSION["userpk"]."'), 0) AS NBRUSRJIM

				FROM posts p

				JOIN user u ON u.id=p.par AND u.user_vld=1

				LEFT JOIN pays py ON py.id=u.pays

				LEFT JOIN ville v ON v.id=u.ville

				LEFT JOIN metier m ON m.id=u.metier

				LEFT JOIN metier_specialiste s ON s.id=u.specialite

				WHERE 1=1 $str_where

				ORDER BY $str_orderby

				LIMIT $strlimit";

		$dt_result=bddfetch($req, $pdo); 
		$array_odd=array_filter($dt_result, function($k) {
                             return $k%2 != 0;
                  }, ARRAY_FILTER_USE_KEY);
		$array_even=array_filter($dt_result, function($k) {
                             return $k%2 == 0;
                  }, ARRAY_FILTER_USE_KEY);

		$i=0;

		if(rqstprm("txt_search")!="" && !$is_adminsrch){echo "<div class='company-title' style='padding:0px;' ><h3>".get_label('lbl_resultpour')." ".rqstprm("txt_search")."</h3></div>";}

		$str_html="";$str_descrpost=""; $str_imagepost="";?>
        <div class='col-md-6 no-padding-colmd posts-div no-padding-left'>
		<?php

		foreach($array_even as $key=>$line)

		{

			$is_addvisit=true;

			if($line["DTMAXVUE"]!="")

			{

				if(strtotime(date("Y-m-d H:i:s"))<strtotime($line["DTMAXVUE"])){$is_addvisit=false;}

			}

			if($is_addvisit)

			{

				$req = "INSERT INTO posts_vue(user_id, post) VALUES(".injsql(htmlspecialchars($_SESSION["userpk"]), $pdo).", ".htmlspecialchars($line["id"]).");";

				bddmaj($req, $pdo);
				updatePosition($pdo);

			}

			$str_html.="";

			$str_profiluser="javascript:void(0)";

			if($line['USERID']!=$_SESSION["userpk"]){$str_profiluser=$strurlsite."mon-profil.php?s=post&user=".$line['USERID'];}

			else{$str_profiluser=$strurlsite."mon-profil.php?s=post";}

			?>

			<div class='col-md-12' >

				<div class='posty' id='dv_post_<?php echo $line['id'].'_'.$str_pour; ?>' style='<?php echo $str_styleglb; ?>' >

					<div class='post-bar no-margin'>

						<div class='post_topbar'>

							<div class='usy-dt'>

								<a href="<?php echo $str_profiluser; ?>" >

									<div class='usr-pic-profil' style="background-image: url(<?php echo img_userdef($line['IMGUSER']); ?>);" >

										<?php
										if((isset($_GET['orderpst']) && $_GET['orderpst'] == 1) || $str_pour == 6)

										{
											if(($key == 0 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==1)){
				 								echo '<img src="images/trone.png" height="70" width="70" style="float: right;position: relative;left: 10px;top:-5px;">';

											}

											if($str_pour == 6 && $line['trophy']==2){

												echo '<img src="images/trone.png" height="70" width="70" style="float: right;position: relative;left: 10px;top:-5px;">';

											}

											if(($key == 2 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==3)){

												echo '<img src="images/trone.png" height="70" width="70" style="float: right;position: relative;left: 10px;top:-5px;">';

											}
											if($str_pour == 6 && $line['trophy']==4){

										        echo '<img src="images/trone.png" height="70" width="70" style="float: right;position: relative;left: 10px;top:-5px;">';

										    }

										    if(($key == 4 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==5)){

											   echo '<img src="images/trone.png" height="70" width="70" style="float: right;position: relative;left: 10px;top:-5px;">';

										    }

										}

										?> 

									</div>                        

								</a>

								<div class='usy-name'>

									<h3 style='font-size:11pt;padding:0px;' >

										<a href="<?php echo $str_profiluser; ?>" >

										<?php

										echo $line['USERPNOM'].' '.$line['USERNOM'];

										if($line['NBRCACHER']>0)

										{

											$str_foi=get_label('lbl_foi'); if($line['NBRCACHER']>1){$str_foi=get_label('lbl_fois');}

											echo "<span style='color:red;' > (".get_label('lbl_masquer')." ".$line['NBRCACHER']." ".strtolower($str_foi).")</span>";

										}

										?>

										</a>

									</h3>

									<span><!--<img src='<?php echo $strurlsite; ?>images/clock.png' alt=''>--> <?php echo formatdate($line['date_ajout'], 'd/m/Y H:i'); ?></span>
									<div>
										<?php

											$str_vilapay="<b style='color:#A3A3A3;font-size: 14px;' >".$line["NOMVILLE"]."</b>";

											if($line["NOMPAYS"]!=""){if($str_vilapay!=""){$str_vilapay.=" - ";}$str_vilapay.="<b style='color:#A3A3A3;font-size: 14px;' >".$line["NOMPAYS"]."</b>";}

											if($str_vilapay!="")

											{

												echo /*"<img src='".$strurlsite."images/icon-map.png' style='height:13px;' class='mr-2' alt='' /> */

														"<span>".$str_vilapay."</span>";

											}

						                ?>
									</div>

								</div>

							</div>

							<?php if($is_connect){ ?>

							<div class='ed-opts'>

								

								<?php if($line['par']==$_SESSION['userpk'] || $_SESSION['user_type']==0){ ?>
								<a href='javascript:void(0)' title='' class='ed-opts-open' onclick='show_pst(this);' ><i class='la la-ellipsis-v'></i></a>	
								<ul class='ed-options'>

									

									<li>

										<input type='hidden' id='txt_youtube_<?php echo $line['id'].'_'.$str_pour; ?>' value='<?php echo $line['youtube']; ?>' />

										<b onclick="updatepost('<?php echo $line['id']."', '".$str_pour; ?>');" ><?php echo get_label("lbl_modifier"); ?></b>

									</li>

									<li><b style='color:red;' onclick="deletepost('<?php echo $line['id']."', '".$str_pour; ?>', 0);" ><?php echo get_label("lbl_supprimer"); ?></b></li>

									

									<?php if($line['par']!=$_SESSION['userpk']){ ?>

									<!--<li><b onclick="deletepost('<?php echo $line['id']."', '".$str_pour; ?>', 1);" ><?php echo get_label("lbl_masquer"); ?></b></li>-->
                                   <?php } ?>
									

								</ul>
                             <?php } ?>

							</div>

							<?php } ?>

							<?php

						if((isset($_GET['orderpst']) && $_GET['orderpst'] == 1) || $str_pour == 6)

										{

													if(($key == 0 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==1)){

						 								echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me1.png' width='35' height='45' style='float: right;'></a>";

													}

													if($str_pour == 6 && $line['trophy']==2){

														echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me2.png' width='32' height='40' style='float: right;'></a>";

													}

													if(($key == 2 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==3)){

														echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me3.png' width='32' height='40' style='float: right;'></a>";

													}
													if($str_pour == 6 && $line['trophy']==4){

										                echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me4.jpg' width='32' height='40' style='float: right;'></a>";

									                }

										            if(($key == 4 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==5)){

											            echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me5.jpg' width='32' height='40' style='float: right;'></a>";

										             }

										}

							?>

						</div>

						<div class='epi-sec' style='<?php if(isphone()){echo "display:none;";} ?>display:none;' >

							<ul class='descp'>

								<?php 

								$str_metspec=$line['NOMSPECIAL'];

								if($line["NOMMETIER"]!=""){if($str_metspec!=""){$str_metspec.=" - ";}$str_metspec.=$line["NOMMETIER"];}

								if($str_metspec!=""){echo "<li><img src='".$strurlsite."images/icon8.png' alt='' /><span>".$str_metspec."</span></li>";}

								

								/*

								$str_vilapay=$line["NOMVILLE"];

								if($line["NOMPAYS"]!=""){if($str_vilapay!=""){$str_vilapay.=" - ";}$str_vilapay.=$line["NOMPAYS"];}

								if($str_vilapay!=""){echo "<li><img src='".$strurlsite."images/icon9.png' alt='' /><span>".$str_vilapay."</span></li>";}

								*/

								if($str_pour==6)

								{

									$str_pourtxt=get_label("lbl_monde"); $str_class="globe";

									if($line["pour"]==1){$str_pourtxt=$str_pour_pay; $str_class="flag";}

									if($line["pour"]==2){$str_pourtxt=$str_pour_ville; $str_class="map-marker";}

									if($line["pour"]==3){$str_pourtxt=$str_pour_metier; $str_class="briefcase";}

									if($line["pour"]==4){$str_pourtxt=$str_pour_special; $str_class="tags";}

									if($line["pour"]==5){$str_pourtxt=$str_pour_famille; $str_class="group";}

									if($line["pour"]==6){$str_pourtxt=get_label("lbl_mon_profil"); $str_class="user";}

									echo "<li><span><i class='la la-$str_class' ></i> ".$str_pourtxt."</span></li>";

								}

								?>

							</ul>

						</div>

						<div class='job_descp'>

							<?php 

							$str_detail=htmlspecialchars($line["detail"]);

							if(strlen($str_detail)>250)

							{?>

								<p id='p_resumer_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>'><?php echo substr($str_detail, 0, indexof($str_detail, ' ', 300))?>... <span class='pl' style='color: #fd8222;'   onclick="hide('p_resumer_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>');show('p_detail_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>');show('cacher_share_<?php echo $line['id']; ?>');show('cacher_comment_<?php echo $line['id']; ?>');show('comments_label_<?php echo $line['id']; ?>');<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "set_vue('".$line['id']."', '".$str_pour."');";} ?>" ><?php echo get_label('plus') ?></span></p>
								<p id='p_detail_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>' style='display:none;' ><?php echo Replace($str_detail, "\n", "<br />"); ?></p>

							<?php

						    }

							else{echo "<p id='p_detail_".$line['id'].'_'.$str_pour."' >".Replace($str_detail, "\n", "<br />")."</p>";}

							$str_urlshare=$strurlsite."post.php?pid=".$line['id'];

							$str_descrpost=substr($str_detail, 0, 250)."...";

							/*

							$str_cntnt = preg_replace_callback('~\b(?:https?|ftp|file)://\S+~i', function($v){

										if(preg_match('~\.jpe?g|\.png|\.gif|\.bmp$~i', $v[0])){return '<img src="' . $v[0] . '" />';}

										else{return '<a href="' . $v[0] . '" target="_blank" >' . $v[0] . '</a>';}

									}, $line["detail"]);

							*/

							if($line["youtube"]!="" && (indexof($line["youtube"], "youtu.be")>0 || indexof($line["youtube"], "youtube")>0))

							{

								$str_urlyoutube=$line["youtube"];

								if(indexof($str_urlyoutube, "watch?v=")>0){$str_urlyoutube=Replace($str_urlyoutube, "watch?v=", "embed/");}

								elseif(indexof($str_urlyoutube, "youtu.be/")>0){$str_urlyoutube=Replace($str_urlyoutube, "youtu.be/", "youtube.com/embed/");}

								elseif(indexof($str_urlyoutube, "youtu.be")>0){$str_urlyoutube=Replace($str_urlyoutube, "youtu.be", "youtube.com/embed");}

								if(indexof($str_urlyoutube, "m.youtube")>0){$str_urlyoutube=Replace($str_urlyoutube, "m.youtube", "youtube");}

								elseif(indexof($str_urlyoutube, "m.youtu")>0){$str_urlyoutube=Replace($str_urlyoutube, "m.youtu", "youtube");}

								echo "<iframe style='width:100%;height:400px;border:none;' src='".$str_urlyoutube."' name='iframe1' frameborder='0'  allow='autoplay; encrypted-media' allowfullscreen></iframe>";

							}

							if($line["IMGPOST"]!=""){echo "<img src='".$strurlsite.$line["IMGPOST"]."' style='max-width:100%;margin-bottom:20px;' alt='' />";}

							echo "<div style='clear:both;' ></div>";

							$strliens="";$chrf=1;

							preg_match_all('/\b(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i', $line["detail"], $resulthrf, PREG_PATTERN_ORDER);

							foreach($resulthrf as $hrf)

							{

								if(isset($hrf[0])){$strliens.="<a href='".$hrf[0]."' class='btn_urlpost' target='_blank' >".substr($hrf[0], 0, 50)."... <i class='fa fa-external-link' ></i></a>";}

							}

							if($strliens!=""){echo "<p>".$strliens."</p>";}

							$str_imagepost=$line["IMGPOST"];

							?>

							<input type='hidden' id='txt_detail_<?php echo $line['id'].'_'.$str_pour; ?>' value='<?php echo $line['detail']; ?>'  />

						<div class="cacher" id="cacher_share_<?php echo $line['id'];?>">

							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $str_urlshare; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="btnShare btn_share btn_facebook" >

								<i class='fa fa-facebook' ></i> <?php echo get_label("lbl_partager"); ?>

							</a>

							<!--

							<a href="<?php echo $str_urlshare; ?>" data-image="<?php echo $str_imagepost; ?>" data-title="<?php echo get_sitename(); ?>" data-desc="<?php echo $str_descrpost; ?>" class="btnShare btn_share btn_facebook">

								<i class='fa fa-facebook' ></i> <?php echo get_label("lbl_partager"); ?>

							</a>

							<script>$('.btn_facebook').click(function(){ elem = $(this); postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image')); return false; });</script>

							<script src="https://apis.google.com/js/platform.js" async defer></script>

							<div class="g-plus" data-action="share" data-href="<?php echo $str_urlshare; ?>"></div>

							-->

							<a href="https://plus.google.com/share?url=<?php echo $str_urlshare; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="btnShare btn_share btn_google" >

								<i class='fa fa-google-plus' ></i> <?php echo get_label("lbl_partager"); ?>

							</a>

							<div id='dv_btnurlshare_<?php echo $line['id'].'_'.$str_pour; ?>' class="btn_share" onclick="showb('b_urlshare_<?php echo $line['id'].'_'.$str_pour; ?>');hide('dv_btnurlshare_<?php echo $line['id'].'_'.$str_pour; ?>');$('#b_urlshare_<?php echo $line['id'].'_'.$str_pour; ?>').focus().select();" >

								<i class='fa fa-url' ></i> <?php echo get_label("lbl_copylien"); ?>

							</div>

						</div>

							<input type='text' id='b_urlshare_<?php echo $line['id'].'_'.$str_pour; ?>' style='display:none;' value="<?php echo $str_urlshare; ?>" />

						</div>

						<div class='job-status-bar'>

							<ul class='like-com'>

								<li class='sp_cmntlik' onclick="<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "set_jaime('".$line['id']."', '".$str_pour."');";}else{echo "redirect('".$strurlsite."?pid=".$str_id."');";} ?>" >

									<i class='la la-heart' id='i_icojaime_<?php echo $line['id'].'_'.$str_pour; ?>' style='<?php if($line["NBRUSRJIM"]>0){echo 'color:orange;';} ?>cursor:pointer;' ></i>

									<?php

									echo "<b id='b_nbrjaime_".$line['id'].'_'.$str_pour."' >".$line["NBRJAIME"]."</b> ";

									if(!isphone() && 1==0){echo get_label("lbl_jaime");}

									?>

									<input type='hidden' id='txt_isuserjaime_<?php echo $line['id'].'_'.$str_pour; ?>' value='<?php echo $line["NBRUSRJIM"]; ?>' />

								</li> 

								<li class='sp_cmntlik comment-link' onclick="show('cacher_comment_<?php echo $line['id']; ?>');show('comments_label_<?php echo $line['id']; ?>');">

									<i class='la la-comment'></i>

									<?php

									echo "<b id='b_nbrcmntr_".$line['id'].'_'.$str_pour."' >".$line["NBRCMNT"]."</b>";

									if(!isphone() && 1==0){

										if($line["NBRCMNT"]>1){echo " ".get_label("lbl_commentaires");}

										else{echo " ".get_label("lbl_commentaire");}

									}

									?>

								</li>

								<li class='sp_cmntlik' >

									<i class='la la-eye'></i>

									<?php

									echo "<b id='b_nbrvue_".$line['id'].'_'.$str_pour."' >".$line["NBRVUE"]."</b>";

									if(!isphone() && 1==0){

										if($line["NBRVUE"]>1){echo " ".get_label("lbl_vues");}

										else{echo " ".get_label("lbl_vue");}

									}

									?>

								</li>

								<?php

								$req="SELECT COUNT(*) AS NBRTOT FROM user_abonne ub WHERE ub.user_id=".injsql($line["par"], $pdo)." AND abonne_del=0;";

								$dt_abonne=bddfetch($req, $pdo);

								$nbr_folow=$dt_abonne[0]["NBRTOT"];

								$nbrcrntabon=get_btn_suivi($line["par"], $pdo, '', true);

								$strstylabon="";

								if($nbrcrntabon>0){$strstylabon="color:orange;";}

								?>

								<li class='sp_cmntlik' style='<?php echo $strstylabon; ?>' id='li_abonne_<?php echo $line["id"]; ?>' onclick="<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "init_abonne('".$line["id"]."', ".$line["par"].", ".$_SESSION["userpk"].");";} ?>" >

									<?php

									if($nbr_folow<=0){echo "<i class='la la-hand-rock-o' id='i_icoabone_".$line["id"]."' ></i>";}

									else{echo "<i class='la la-hand-pointer-o' id='i_icoabone_".$line["id"]."' ></i>";}

									echo "<b id='sp_nbrabone_".$line["id"]."' >$nbr_folow</b>";

									//if(!isphone()){

										if($nbr_folow>1){echo " ".get_label("lbl_suivis");}

										else{echo " ".get_label("lbl_suivi");}

									//}

									?>

									<input type='hidden' id="txt_isabonne_<?php echo $line["id"]; ?>" value="<?php echo $nbrcrntabon; ?>" />

								</li>

							</ul>

						</div>

					</div><!--post-bar end-->

					<div class="job-status-bar comments-label" id="comments_label_<?php echo $line['id'];?>">

						<ul class="like-com">

							<li class="sp_cmntlik">

								<b id="com_title"><?php echo get_label("lbl_commentaires"); ?></b>

							</li> 

						</ul>

					</div>

					<div class='comment-section' id="cacher_comment_<?php echo $line['id'];?>">

						<?php

						$req = "SELECT pc.id, pc.post, pc.user_id, pc.detail, pc.date_ajout, u.image, u.prenom, u.nom

								FROM posts_comment pc

								JOIN user u ON u.id=pc.user_id

								WHERE pc.post=".injsql($line["id"], $pdo)."

								ORDER BY pc.date_ajout";

						$dt_cmnt=bddfetch($req, $pdo);

						?>

						<div class='comment-sec'>

							<ul id='ul_cmentaire_<?php echo $line['id'].'_'.$str_pour; ?>' >

								<?php

								if(count($dt_cmnt)>0)

								{

									foreach($dt_cmnt as $line_cmnt)

									{

										$str_profiluser="javascript:void(0)";

										if($line_cmnt['user_id']!=$_SESSION["userpk"]){$str_profiluser=$strurlsite."profil/".canlcaract($line_cmnt['prenom'].$line_cmnt['nom'])."/?s=post&user=".$line_cmnt['user_id'];}

										else{$str_profiluser=$strurlsite."profil/".canlcaract($line_cmnt['prenom'].$line_cmnt['nom'])."/?s=post";}

										?>

										<li id='li_cmentaire_<?php echo $line['id'].'_'.$line_cmnt['id'].'_'.$str_pour; ?>' >

											<div class='comment-list'>

												<div class='bg-img'>

													<a href="<?php echo $str_profiluser; ?>" >

														<div class='usr-pic-profil' style='background-image:url(<?php echo img_userdef($line_cmnt['image']); ?>);' ></div>

													</a>

												</div>

												<div class='comment'>

													<h3>

														<a href="<?php echo $str_profiluser; ?>" ><?php echo $line_cmnt['prenom'].' '.$line_cmnt['nom']; ?></a>

													</h3>

													<span><img src='<?php echo $strurlsite; ?>images/clock.png' alt=''> <?php echo formatdate($line_cmnt['date_ajout'], 'd/m/Y H:i'); ?></span>

													<p><?php echo Replace($line_cmnt['detail'], "<", "< "); ?></p>

													<?php if($is_connect && ($line_cmnt['user_id']==$_SESSION['userpk'] || $line['par']==$_SESSION['userpk'] || $_SESSION['user_type']==0)){ ?>

														<b class='btn_delcmnt' onclick="deletecmntr('<?php echo $line['id']."', '".$str_pour; ?>', '<?php echo $line_cmnt['id']; ?>');" ><?php echo get_label("lbl_supprimer"); ?></b>

													<?php } ?>

												</div>

											</div>

										</li>

										<?php 

									} 

								}?>

							</ul>

						</div>

						<div class='post-comment'>

							<div class='comment_box'>

								<?php if($is_connect){ ?>

								<input type='text' id='txt_comentaire_<?php echo $line['id'].'_'.$str_pour; ?>' placeholder='<?php echo get_label("lbl_yourcmnt"); ?>' required />

								<button class='btncmnt' onclick="set_comnt('<?php echo $line['id'].'_'.$str_pour; ?>');" ><?php echo get_label("lbl_commenter"); ?></button>

								<?php }else{ ?>

								<button class='btncmnt' onclick="redirect('<?php echo $strurlsite."?pid=".$str_id; ?>');" ><?php echo get_label("lbl_commenter"); ?></button>

								<?php } ?>

							</div>

						</div>

					</div>

				</div>

			</div>

			<?php

			$i++;

		} ?>
		</div>
        <div class='col-md-6 no-padding-colmd posts-div no-padding-right'>
		<?php foreach($array_odd as $key=>$line)

		{

			$is_addvisit=true;

			if($line["DTMAXVUE"]!="")

			{

				if(strtotime(date("Y-m-d H:i:s"))<strtotime($line["DTMAXVUE"])){$is_addvisit=false;}

			}

			if($is_addvisit)

			{

				$req = "INSERT INTO posts_vue(user_id, post) VALUES(".injsql(htmlspecialchars($_SESSION["userpk"]), $pdo).", ".htmlspecialchars($line["id"]).");";

				bddmaj($req, $pdo);
				updatePosition($pdo);

			}

			$str_html.="";

			$str_profiluser="javascript:void(0)";

			if($line['USERID']!=$_SESSION["userpk"]){$str_profiluser=$strurlsite."mon-profil.php?s=post&user=".$line['USERID'];}

			else{$str_profiluser=$strurlsite."mon-profil.php?s=post";}

			?>

			<div class='col-md-12' >

				<div class='posty' id='dv_post_<?php echo $line['id'].'_'.$str_pour; ?>' style='<?php echo $str_styleglb; ?>' >

					<div class='post-bar no-margin'>

						<div class='post_topbar'>

							<div class='usy-dt'>

								<a href="<?php echo $str_profiluser; ?>" >

									<div class='usr-pic-profil' style="background-image: url(<?php echo img_userdef($line['IMGUSER']); ?>);" >

										<?php

										if((isset($_GET['orderpst']) && $_GET['orderpst'] == 1) || $str_pour == 6)

										{
                                                    
													if($str_pour == 6 && $line['trophy']==1){

														echo '<img src="images/trone.png" height="70" width="70" style="float: right;position: relative;left: 10px;top:-5px;">';

													}

													if(($key == 1 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==2)){

														echo '<img src="images/trone.png" height="70" width="70" style="float: right;position: relative;left: 10px;top:-5px;">';

													}

													if($str_pour == 6 && $line['trophy']==3){

														echo '<img src="images/trone.png" height="70" width="70" style="float: right;position: relative;left: 10px;top:-5px;">';

													}
													if(($key == 3 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==4)){

										                echo '<img src="images/trone.png" height="70" width="70" style="float: right;position: relative;left: 10px;top:-5px;">';

									                 }

									                 if($str_pour == 6 && $line['trophy']==5){

										               echo '<img src="images/trone.png" height="70" width="70" style="float: right;position: relative;left: 10px;top:-5px;">';

									                  }

										}

										?> 

									</div>                        

								</a>

								<div class='usy-name'>

									<h3 style='font-size:11pt;padding:0px;' >

										<a href="<?php echo $str_profiluser; ?>" >

										<?php

										echo $line['USERPNOM'].' '.$line['USERNOM'];

										if($line['NBRCACHER']>0)

										{

											$str_foi=get_label('lbl_foi'); if($line['NBRCACHER']>1){$str_foi=get_label('lbl_fois');}

											echo "<span style='color:red;' > (".get_label('lbl_masquer')." ".$line['NBRCACHER']." ".strtolower($str_foi).")</span>";

										}

										?>

										</a>

									</h3>

									<span><!--<img src='<?php echo $strurlsite; ?>images/clock.png' alt=''>--> <?php echo formatdate($line['date_ajout'], 'd/m/Y H:i'); ?></span>
									<div>
										<?php

											$str_vilapay="<b style='color:#A3A3A3;font-size: 14px;' >".$line["NOMVILLE"]."</b>";

											if($line["NOMPAYS"]!=""){if($str_vilapay!=""){$str_vilapay.=" - ";}$str_vilapay.="<b style='color:#A3A3A3;font-size: 14px;' >".$line["NOMPAYS"]."</b>";}

											if($str_vilapay!="")

											{

												echo /*"<img src='".$strurlsite."images/icon-map.png' style='height:13px;' class='mr-2' alt='' /> */

														"<span>".$str_vilapay."</span>";

											}

						                ?>
									</div>

								</div>

							</div>

							<?php if($is_connect){ ?>

							<div class='ed-opts'>

								

								<?php if($line['par']==$_SESSION['userpk'] || $_SESSION['user_type']==0){ ?>
								<a href='javascript:void(0)' title='' class='ed-opts-open' onclick='show_pst(this);' ><i class='la la-ellipsis-v'></i></a>	
								<ul class='ed-options'>

									

									<li>

										<input type='hidden' id='txt_youtube_<?php echo $line['id'].'_'.$str_pour; ?>' value='<?php echo $line['youtube']; ?>' />

										<b onclick="updatepost('<?php echo $line['id']."', '".$str_pour; ?>');" ><?php echo get_label("lbl_modifier"); ?></b>

									</li>

									<li><b style='color:red;' onclick="deletepost('<?php echo $line['id']."', '".$str_pour; ?>', 0);" ><?php echo get_label("lbl_supprimer"); ?></b></li>

									

									<?php if($line['par']!=$_SESSION['userpk']){ ?>

									<!--<li><b onclick="deletepost('<?php echo $line['id']."', '".$str_pour; ?>', 1);" ><?php echo get_label("lbl_masquer"); ?></b></li>-->
                                   <?php } ?>
									

								</ul>
                             <?php } ?>

							</div>

							<?php } ?>

							<?php

						if((isset($_GET['orderpst']) && $_GET['orderpst'] == 1) || $str_pour == 6)

										{
											
													if($str_pour == 6 && $line['trophy']==1){

														echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me1.png' width='32' height='40' style='float: right;'></a>";

													}

													if(($key == 1 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==2)){

														echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me2.png' width='32' height='40' style='float: right;'></a>";

													}

													if($str_pour == 6 && $line['trophy']==3){

														echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me3.png' width='32' height='40' style='float: right;'></a>";

													}
													if(($key == 3 && $str_pour == 0) || ($str_pour == 6 && $line['trophy']==4)){

										                echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me4.jpg' width='32' height='40' style='float: right;'></a>";

									                }

									               if($str_pour == 6 && $line['trophy']==5){

										                echo "<a href='https://www.ixiir.com/post.php?pid=2302'><img src='images/me5.jpg' width='32' height='40' style='float: right;'></a>";

									               }

										}

							?>

						</div>

						<div class='epi-sec' style='<?php if(isphone()){echo "display:none;";} ?>display:none;' >

							<ul class='descp'>

								<?php 

								$str_metspec=$line['NOMSPECIAL'];

								if($line["NOMMETIER"]!=""){if($str_metspec!=""){$str_metspec.=" - ";}$str_metspec.=$line["NOMMETIER"];}

								if($str_metspec!=""){echo "<li><img src='".$strurlsite."images/icon8.png' alt='' /><span>".$str_metspec."</span></li>";}

								

								/*

								$str_vilapay=$line["NOMVILLE"];

								if($line["NOMPAYS"]!=""){if($str_vilapay!=""){$str_vilapay.=" - ";}$str_vilapay.=$line["NOMPAYS"];}

								if($str_vilapay!=""){echo "<li><img src='".$strurlsite."images/icon9.png' alt='' /><span>".$str_vilapay."</span></li>";}

								*/

								if($str_pour==6)

								{

									$str_pourtxt=get_label("lbl_monde"); $str_class="globe";

									if($line["pour"]==1){$str_pourtxt=$str_pour_pay; $str_class="flag";}

									if($line["pour"]==2){$str_pourtxt=$str_pour_ville; $str_class="map-marker";}

									if($line["pour"]==3){$str_pourtxt=$str_pour_metier; $str_class="briefcase";}

									if($line["pour"]==4){$str_pourtxt=$str_pour_special; $str_class="tags";}

									if($line["pour"]==5){$str_pourtxt=$str_pour_famille; $str_class="group";}

									if($line["pour"]==6){$str_pourtxt=get_label("lbl_mon_profil"); $str_class="user";}

									echo "<li><span><i class='la la-$str_class' ></i> ".$str_pourtxt."</span></li>";

								}

								?>

							</ul>

						</div>

						<div class='job_descp'>

							<?php 

							$str_detail=htmlspecialchars($line["detail"]);

							if(strlen($str_detail)>250)

							{?>

								<p id='p_resumer_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>'><?php echo substr($str_detail, 0, indexof($str_detail, ' ', 300))?>... <span class='pl' style='color: #fd8222;'   onclick="hide('p_resumer_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>');show('p_detail_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>');show('cacher_share_<?php echo $line['id']; ?>');show('cacher_comment_<?php echo $line['id']; ?>');show('comments_label_<?php echo $line['id']; ?>');<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "set_vue('".$line['id']."', '".$str_pour."');";} ?>" ><?php echo get_label('plus') ?></span></p>
								<p id='p_detail_<?php echo $line['id']; ?>_<?php echo $str_pour; ?>' style='display:none;' ><?php echo Replace($str_detail, "\n", "<br />"); ?></p>

							<?php

						    }

							else{echo "<p id='p_detail_".$line['id'].'_'.$str_pour."' >".Replace($str_detail, "\n", "<br />")."</p>";}

							$str_urlshare=$strurlsite."post.php?pid=".$line['id'];

							$str_descrpost=substr($str_detail, 0, 250)."...";

							/*

							$str_cntnt = preg_replace_callback('~\b(?:https?|ftp|file)://\S+~i', function($v){

										if(preg_match('~\.jpe?g|\.png|\.gif|\.bmp$~i', $v[0])){return '<img src="' . $v[0] . '" />';}

										else{return '<a href="' . $v[0] . '" target="_blank" >' . $v[0] . '</a>';}

									}, $line["detail"]);

							*/

							if($line["youtube"]!="" && (indexof($line["youtube"], "youtu.be")>0 || indexof($line["youtube"], "youtube")>0))

							{

								$str_urlyoutube=$line["youtube"];

								if(indexof($str_urlyoutube, "watch?v=")>0){$str_urlyoutube=Replace($str_urlyoutube, "watch?v=", "embed/");}

								elseif(indexof($str_urlyoutube, "youtu.be/")>0){$str_urlyoutube=Replace($str_urlyoutube, "youtu.be/", "youtube.com/embed/");}

								elseif(indexof($str_urlyoutube, "youtu.be")>0){$str_urlyoutube=Replace($str_urlyoutube, "youtu.be", "youtube.com/embed");}

								if(indexof($str_urlyoutube, "m.youtube")>0){$str_urlyoutube=Replace($str_urlyoutube, "m.youtube", "youtube");}

								elseif(indexof($str_urlyoutube, "m.youtu")>0){$str_urlyoutube=Replace($str_urlyoutube, "m.youtu", "youtube");}

								echo "<iframe style='width:100%;height:400px;border:none;' src='".$str_urlyoutube."' name='iframe1' frameborder='0'  allow='autoplay; encrypted-media' allowfullscreen></iframe>";

							}

							if($line["IMGPOST"]!=""){echo "<img src='".$strurlsite.$line["IMGPOST"]."' style='max-width:100%;margin-bottom:20px;' alt='' />";}

							echo "<div style='clear:both;' ></div>";

							$strliens="";$chrf=1;

							preg_match_all('/\b(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i', $line["detail"], $resulthrf, PREG_PATTERN_ORDER);

							foreach($resulthrf as $hrf)

							{

								if(isset($hrf[0])){$strliens.="<a href='".$hrf[0]."' class='btn_urlpost' target='_blank' >".substr($hrf[0], 0, 50)."... <i class='fa fa-external-link' ></i></a>";}

							}

							if($strliens!=""){echo "<p>".$strliens."</p>";}

							$str_imagepost=$line["IMGPOST"];

							?>

							<input type='hidden' id='txt_detail_<?php echo $line['id'].'_'.$str_pour; ?>' value='<?php echo $line['detail']; ?>'  />

						<div class="cacher" id="cacher_share_<?php echo $line['id'];?>">

							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $str_urlshare; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="btnShare btn_share btn_facebook" >

								<i class='fa fa-facebook' ></i> <?php echo get_label("lbl_partager"); ?>

							</a>

							<!--

							<a href="<?php echo $str_urlshare; ?>" data-image="<?php echo $str_imagepost; ?>" data-title="<?php echo get_sitename(); ?>" data-desc="<?php echo $str_descrpost; ?>" class="btnShare btn_share btn_facebook">

								<i class='fa fa-facebook' ></i> <?php echo get_label("lbl_partager"); ?>

							</a>

							<script>$('.btn_facebook').click(function(){ elem = $(this); postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image')); return false; });</script>

							<script src="https://apis.google.com/js/platform.js" async defer></script>

							<div class="g-plus" data-action="share" data-href="<?php echo $str_urlshare; ?>"></div>

							-->

							<a href="https://plus.google.com/share?url=<?php echo $str_urlshare; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="btnShare btn_share btn_google" >

								<i class='fa fa-google-plus' ></i> <?php echo get_label("lbl_partager"); ?>

							</a>

							<div id='dv_btnurlshare_<?php echo $line['id'].'_'.$str_pour; ?>' class="btn_share" onclick="showb('b_urlshare_<?php echo $line['id'].'_'.$str_pour; ?>');hide('dv_btnurlshare_<?php echo $line['id'].'_'.$str_pour; ?>');$('#b_urlshare_<?php echo $line['id'].'_'.$str_pour; ?>').focus().select();" >

								<i class='fa fa-url' ></i> <?php echo get_label("lbl_copylien"); ?>

							</div>

						</div>

							<input type='text' id='b_urlshare_<?php echo $line['id'].'_'.$str_pour; ?>' style='display:none;' value="<?php echo $str_urlshare; ?>" />

						</div>

						<div class='job-status-bar'>

							<ul class='like-com'>

								<li class='sp_cmntlik' onclick="<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "set_jaime('".$line['id']."', '".$str_pour."');";}else{echo "redirect('".$strurlsite."?pid=".$str_id."');";} ?>" >

									<i class='la la-heart' id='i_icojaime_<?php echo $line['id'].'_'.$str_pour; ?>' style='<?php if($line["NBRUSRJIM"]>0){echo 'color:orange;';} ?>cursor:pointer;' ></i>

									<?php

									echo "<b id='b_nbrjaime_".$line['id'].'_'.$str_pour."' >".$line["NBRJAIME"]."</b> ";

									if(!isphone() && 1==0){echo get_label("lbl_jaime");}

									?>

									<input type='hidden' id='txt_isuserjaime_<?php echo $line['id'].'_'.$str_pour; ?>' value='<?php echo $line["NBRUSRJIM"]; ?>' />

								</li> 

								<li class='sp_cmntlik comment-link' onclick="show('cacher_comment_<?php echo $line['id']; ?>');show('comments_label_<?php echo $line['id']; ?>');">

									<i class='la la-comment'></i>

									<?php

									echo "<b id='b_nbrcmntr_".$line['id'].'_'.$str_pour."' >".$line["NBRCMNT"]."</b>";

									if(!isphone() && 1==0){

										if($line["NBRCMNT"]>1){echo " ".get_label("lbl_commentaires");}

										else{echo " ".get_label("lbl_commentaire");}

									}

									?>

								</li>

								<li class='sp_cmntlik'  onclick="<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "set_vue('".$line['id']."', '".$str_pour."');";}else{echo "redirect('".$strurlsite."?pid=".$str_id."');";} ?>">

									<i class='la la-eye'></i>

									<?php

									echo "<b id='b_nbrvue_".$line['id'].'_'.$str_pour."' >".$line["NBRVUE"]."</b>";

									if(!isphone() && 1==0){

										if($line["NBRVUE"]>1){echo " ".get_label("lbl_vues");}

										else{echo " ".get_label("lbl_vue");}

									}

									?>

								</li>

								<?php

								$req="SELECT COUNT(*) AS NBRTOT FROM user_abonne ub WHERE ub.user_id=".injsql($line["par"], $pdo)." AND abonne_del=0;";

								$dt_abonne=bddfetch($req, $pdo);

								$nbr_folow=$dt_abonne[0]["NBRTOT"];

								$nbrcrntabon=get_btn_suivi($line["par"], $pdo, '', true);

								$strstylabon="";

								if($nbrcrntabon>0){$strstylabon="color:orange;";}

								?>

								<li class='sp_cmntlik' style='<?php echo $strstylabon; ?>' id='li_abonne_<?php echo $line["id"]; ?>' onclick="<?php if($is_connect && $line['USERID']!=$_SESSION["userpk"]){echo "init_abonne('".$line["id"]."', ".$line["par"].", ".$_SESSION["userpk"].");";} ?>" >

									<?php

									if($nbr_folow<=0){echo "<i class='la la-hand-rock-o' id='i_icoabone_".$line["id"]."' ></i>";}

									else{echo "<i class='la la-hand-pointer-o' id='i_icoabone_".$line["id"]."' ></i>";}

									echo "<b id='sp_nbrabone_".$line["id"]."' >$nbr_folow</b>";

									//if(!isphone()){

										if($nbr_folow>1){echo " ".get_label("lbl_suivis");}

										else{echo " ".get_label("lbl_suivi");}

									//}

									?>

									<input type='hidden' id="txt_isabonne_<?php echo $line["id"]; ?>" value="<?php echo $nbrcrntabon; ?>" />

								</li>

							</ul>

						</div>

					</div><!--post-bar end-->

					<div class="job-status-bar comments-label" id="comments_label_<?php echo $line['id'];?>">

						<ul class="like-com">

							<li class="sp_cmntlik">

								<b id="com_title"><?php echo get_label("lbl_commentaires"); ?></b>

							</li> 

						</ul>

					</div>

					<div class='comment-section' id="cacher_comment_<?php echo $line['id'];?>">

						<?php

						$req = "SELECT pc.id, pc.post, pc.user_id, pc.detail, pc.date_ajout, u.image, u.prenom, u.nom

								FROM posts_comment pc

								JOIN user u ON u.id=pc.user_id

								WHERE pc.post=".injsql($line["id"], $pdo)."

								ORDER BY pc.date_ajout";

						$dt_cmnt=bddfetch($req, $pdo);

						?>

						<div class='comment-sec'>

							<ul id='ul_cmentaire_<?php echo $line['id'].'_'.$str_pour; ?>' >

								<?php

								if(count($dt_cmnt)>0)

								{

									foreach($dt_cmnt as $line_cmnt)

									{

										$str_profiluser="javascript:void(0)";

										if($line_cmnt['user_id']!=$_SESSION["userpk"]){$str_profiluser=$strurlsite."profil/".canlcaract($line_cmnt['prenom'].$line_cmnt['nom'])."/?s=post&user=".$line_cmnt['user_id'];}

										else{$str_profiluser=$strurlsite."profil/".canlcaract($line_cmnt['prenom'].$line_cmnt['nom'])."/?s=post";}

										?>

										<li id='li_cmentaire_<?php echo $line['id'].'_'.$line_cmnt['id'].'_'.$str_pour; ?>' >

											<div class='comment-list'>

												<div class='bg-img'>

													<a href="<?php echo $str_profiluser; ?>" >

														<div class='usr-pic-profil' style='background-image:url(<?php echo img_userdef($line_cmnt['image']); ?>);' ></div>

													</a>

												</div>

												<div class='comment'>

													<h3>

														<a href="<?php echo $str_profiluser; ?>" ><?php echo $line_cmnt['prenom'].' '.$line_cmnt['nom']; ?></a>

													</h3>

													<span><img src='<?php echo $strurlsite; ?>images/clock.png' alt=''> <?php echo formatdate($line_cmnt['date_ajout'], 'd/m/Y H:i'); ?></span>

													<p><?php echo Replace($line_cmnt['detail'], "<", "< "); ?></p>

													<?php if($is_connect && ($line_cmnt['user_id']==$_SESSION['userpk'] || $line['par']==$_SESSION['userpk'] || $_SESSION['user_type']==0)){ ?>

														<b class='btn_delcmnt' onclick="deletecmntr('<?php echo $line['id']."', '".$str_pour; ?>', '<?php echo $line_cmnt['id']; ?>');" ><?php echo get_label("lbl_supprimer"); ?></b>

													<?php } ?>

												</div>

											</div>

										</li>

										<?php 

									} 

								}?>

							</ul>

						</div>

						<div class='post-comment'>

							<div class='comment_box'>

								<?php if($is_connect){ ?>

								<input type='text' id='txt_comentaire_<?php echo $line['id'].'_'.$str_pour; ?>' placeholder='<?php echo get_label("lbl_yourcmnt"); ?>' required />

								<button class='btncmnt' onclick="set_comnt('<?php echo $line['id'].'_'.$str_pour; ?>');" ><?php echo get_label("lbl_commenter"); ?></button>

								<?php }else{ ?>

								<button class='btncmnt' onclick="redirect('<?php echo $strurlsite."?pid=".$str_id; ?>');" ><?php echo get_label("lbl_commenter"); ?></button>

								<?php } ?>

							</div>

						</div>

					</div>

				</div>

			</div>

			<?php

			$i++;

		} ?>
		</div>
		<?php return $i;

	}

?>