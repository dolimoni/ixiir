<?php

    
    function setTrophy($post,$pdo){
    	$trophy=0;
    	$time = new DateTime($post['debut_position']);
    	$current=new DateTime();
		$diff = $time->diff($current);
		
		$hours = (($diff->days * 24 * 60) + ($diff->h * 60))/60;
       if(is_null($post['fin_position']) && $hours>=12 && (is_null($post['trophy']) || $post['trophy']>$post['position'])){
            $reqTroph = "UPDATE posts SET trophy=".$post['position']." where id=".$post['id'].";";
            bddmaj($reqTroph,$pdo);
            $trophy=1;
		}else if($post['pred_position']>$post['position']) {
            $time = new DateTime($post['pred_debut_position']);
            $diff = $time->diff($current);
            $hours = (($diff->days * 24 * 60) + ($diff->h * 60))/60;
	        if(is_null($post['fin_position']) && $hours>=12 && (is_null($post['trophy']) || $post['trophy']>$post['pred_position'])){
	            $reqTroph = "UPDATE posts SET trophy=".$post['pred_position']." where id=".$post['id'].";";
	            bddmaj($reqTroph,$pdo);
	            $trophy=1;
			}
		}
		return $trophy;
	}

	function updatePosition($pdo) {
		    $req = "SELECT p.*
			            , COALESCE((SELECT COUNT(*) FROM posts_vue pv WHERE pv.post=p.id), 0) AS NBRVUE

						, COALESCE((SELECT COUNT(*) FROM posts_comment pc WHERE pc.post=p.id), 0) AS NBRCMNT

						, COALESCE((SELECT COUNT(*) FROM posts_jaime pj WHERE pj.post=p.id), 0) AS NBRJAIME

				FROM posts p

				WHERE 1=1 AND p.date_ajout>=DATE_SUB(NOW(), INTERVAL 3 DAY)

				ORDER BY (NBRVUE+(NBRJAIME*2)+(NBRCMNT*3)) DESC
				LIMIT 0, 5";
			$dt_result=bddfetch($req,$pdo);	
			$reqAutres = "SELECT p.id,p.position, p.debut_position, p.fin_position, p.trophy

			FROM posts p

			WHERE p.position is not null AND p.id NOT IN (".$dt_result[0]['id'].",".$dt_result[1]['id'].",".$dt_result[2]['id'].",".$dt_result[3]['id'].",".$dt_result[4]['id'].")";
			$dt_resultAutres=bddfetch($reqAutres,$pdo);
            foreach($dt_resultAutres as $autre) {
            	$req = "UPDATE posts SET fin_position='".date('Y-m-d H:i:s')."' where id=".$autre['id'].";";
		    	bddmaj($req,$pdo);
            }
		    $trophy=0;
		    if($dt_result[0]['position']==1){
		    	$trophy=setTrophy($dt_result[0],$pdo);
		    }else {
		    	$req = "UPDATE posts SET position=1,debut_position='".date('Y-m-d H:i:s')."',fin_position=null,pred_position='".$dt_result[0]['position']."',pred_debut_position='".$dt_result[0]['debut_position']."',pred_fin_position='".$dt_result[0]['fin_position']."' where id=".$dt_result[0]['id'].";";
		    	bddmaj($req,$pdo);
		    }
		    
		    if($dt_result[1]['position']==2){
		    	$t=setTrophy($dt_result[1],$pdo);
		    	if($trophy==0){
                  $trophy=$t;
		    	}
		    }else {

		    	$req = "UPDATE posts SET position=2,debut_position='".date('Y-m-d H:i:s')."',fin_position=null,pred_position='".$dt_result[1]['position']."',pred_debut_position='".$dt_result[1]['debut_position']."',pred_fin_position='".$dt_result[1]['fin_position']."' where id=".$dt_result[1]['id'].";";
		    	bddmaj($req,$pdo);
		    }
		    if($dt_result[2]['position']==3){
		    	$t=setTrophy($dt_result[2],$pdo);
		    	if($trophy==0){
                  $trophy=$t;
		    	}
		    }else {
		    	$req = "UPDATE posts SET position=3,debut_position='".date('Y-m-d H:i:s')."',fin_position=null,pred_position='".$dt_result[2]['position']."',pred_debut_position='".$dt_result[2]['debut_position']."',pred_fin_position='".$dt_result[2]['fin_position']."' where id=".$dt_result[2]['id'].";";
		    	bddmaj($req,$pdo);
		    }
		    if($dt_result[3]['position']==4){
		    	$t=setTrophy($dt_result[3],$pdo);
		    	if($trophy==0){
                  $trophy=$t;
		    	}
		    }else {
		    	$req = "UPDATE posts SET position=4,debut_position='".date('Y-m-d H:i:s')."',fin_position=null,pred_position='".$dt_result[3]['position']."',pred_debut_position='".$dt_result[3]['debut_position']."',pred_fin_position='".$dt_result[3]['fin_position']."' where id=".$dt_result[3]['id'].";";
		    	bddmaj($req,$pdo);
		    }
		    if($dt_result[4]['position']==5){
		    	$t=setTrophy($dt_result[4],$pdo);
		    	if($trophy==0){
                  $trophy=$t;
		    	}
		    }else {
		    	$req = "UPDATE posts SET position=5,debut_position='".date('Y-m-d H:i:s')."',fin_position=null,pred_position='".$dt_result[4]['position']."',pred_debut_position='".$dt_result[4]['debut_position']."',pred_fin_position='".$dt_result[4]['fin_position']."' where id=".$dt_result[4]['id'].";";
		    	bddmaj($req,$pdo);
		    }
		    return $trophy;
	}	

	function tborder($aray, $col, $asc=0)

	{

		if(count($aray) > 0)

		{

			foreach($aray as $cle => $valeur) {$avis[$cle] = $valeur[$col];}

			if($asc==0){array_multisort($avis, SORT_ASC, $aray);}

			elseif($asc==1){array_multisort($avis, SORT_DESC, $aray);}

		}

		return $aray;

	}

	function indexof($txt, $serch, $start=0)

	{

		$pos = strpos($txt, $serch, $start);

		if ($pos === false){$pos = -1;}

		return $pos;

	}

	function upperfirst($str_toupper){return strtoupper(substr($str_toupper, 0, 1)) . strtolower(substr($str_toupper, 1, strlen($str_toupper)));}

	function Redirect($url){echo "<script>/*show('dv_redirectdiv');hide('cellForm');document.write='';*/document.location='$url';</script>";exit;}

    function canlcaract($str_toanulcar)

	{

		$str_toanulcar = strtolower($str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("ô"), "o", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("ö"), "o", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("é"), "e", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("è"), "e", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("ê"), "e", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("î"), "i", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("ï"), "i", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("à"), "a", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("â"), "a", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("ä"), "a", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("ç"), "c", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("ù"), "u", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("û"), "u", $str_toanulcar);

		$str_toanulcar = str_replace(utf8_decode("ü"), "u", $str_toanulcar);

		$str_toanulcar = preg_replace('/[^A-Za-z0-9:\/\_\|\- .]/', '', $str_toanulcar); // Removes special chars.

		$str_toanulcar = str_replace(" ", "-", $str_toanulcar);

		$str_toanulcar = str_replace(". ", "-", $str_toanulcar);

		$str_toanulcar = str_replace(",", "-", $str_toanulcar);

		$str_toanulcar = str_replace(":", "-", $str_toanulcar);

		$str_toanulcar = str_replace("|", "-", $str_toanulcar);

		$str_toanulcar = str_replace("--------", "-", $str_toanulcar);

		$str_toanulcar = str_replace("-------", "-", $str_toanulcar);

		$str_toanulcar = str_replace("------", "-", $str_toanulcar);

		$str_toanulcar = str_replace("-----", "-", $str_toanulcar);

		$str_toanulcar = str_replace("----", "-", $str_toanulcar);

		$str_toanulcar = str_replace("---", "-", $str_toanulcar);

		$str_toanulcar = str_replace("--", "-", $str_toanulcar);

		$str_toanulcar = str_replace("http-", "http:", $str_toanulcar);

		$str_toanulcar = substr($str_toanulcar, 0, strlen($str_toanulcar));

		$str_toanulcar = Replace(Replace($str_toanulcar, "http-", "http:"), "https-", "https:");

		return $str_toanulcar;

	}

	function randchaine($nbrltr)

    {

        $str_retrn = "";

        $arraytxt = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9" );

        for ($i = 0; $i < $nbrltr; $i++)

		{

			$str_retrn .= $arraytxt[rand(0, (count($arraytxt)-1))];

		}

        return $str_retrn;

    }

	

	function ispermet($droit="")

    {

		if($droit!="" && $_SESSION["user_type"]=="1")

		{

			$idx=indexof($_SESSION["droits"], "*".$droit."*");

			if($idx>=0){return true;}

			else{return false;}

		}

		elseif($_SESSION["user_type"]=="0"){return true;}

		else{return false;}

    }

	function isphone()

	{

		//$isMobile = (bool)preg_match('#\b(ip(hone|od|ad)|android|opera m(ob|in)i|windows (phone|ce)|blackberry|tablet'.                    '|s(ymbian|eries60|amsung)|p(laybook|alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.                    '|mobile|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );

		//return $isMobile;

		$tablet_browser = 0;$mobile_browser = 0;

		if(preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {$tablet_browser++;}

		if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {$mobile_browser++;}

		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {$mobile_browser++;}

		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));

		$mobile_agents = array(

			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',

			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',

			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',

			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',

			'newt','noki','palm','pana','pant','phil','play','port','prox',

			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',

			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',

			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',

			'wapr','webc','winw','winw','xda ','xda-');

		if (in_array($mobile_ua,$mobile_agents)){$mobile_browser++;}

		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {

			$mobile_browser++;

			//Check for tablets on opera mini alternative headers

			$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));

			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)){$tablet_browser++;}

		}

		if($tablet_browser > 0){return true;}

		else if ($mobile_browser > 0){return true;}

		else{return false;}

	}

    function curPageURL() 	{

		$pageURL = 'http';

		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}

		$pageURL .= "://";

		if ($_SERVER["SERVER_PORT"] != "80") {$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];}

 		else {$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];}

		return $pageURL;

	}

	function formadc($number){return number_format($number, 2, ',', ' ');}

	function getresurl($url, $param, $method)

	{//return "";

		$postdata=null;

		if($param){$postdata = http_build_query($param);}

		$opts = array('http' =>

			array('method'  => $method,				

					'header'  => 'Content-type: application/x-www-form-urlencoded',				

					'content' => $postdata,

					'timeout' => 10)		

					);

		$context  = stream_context_create($opts);

		$result="";

		if($result = file_get_contents($url, false, $context)){}

		

		return $result;

	}

	function rqstprm($prm)

	{

		$retrn=null;

		if(isset($_POST[$prm])){$retrn=$_POST[$prm];}

		elseif(isset($_GET[$prm])){$retrn=$_GET[$prm];}

		elseif(isset($_REQUEST[$prm])){$retrn=$_REQUEST[$prm];}

		return $retrn;

	}

	function Replace($txt, $obj, $repl){return str_replace($obj, $repl, $txt);}

	function splite($txt, $par)

	{

		if($txt != ""){return explode($par, $txt);}

		else{return null;}

	}

	function formatdate($arg, $strformat="d/m/Y H:i:s")

	{

		$dat = new DateTime($arg);

		return $dat->format($strformat);

	}

	function filetoserver($file, $to, $nom="")

	{

		$str_retrn = "";

		if(isset($_FILES[$file]) && $_FILES[$file]["name"] != "")

		{

			$strtypeimg = trim(strtolower(Replace(Replace($_FILES[$file]['type'], "image/", ""), "text/", "")));

			if($strtypeimg == "jpg" || $strtypeimg == "jpeg" || $strtypeimg == "png" || $strtypeimg == "gif")

			{

				$nomimg = get_sitename().date("YmdHis");

				if($nom != ""){$nomimg = $nom;}

				$nomimg .= "." . $strtypeimg;

				$str_retrn = $nomimg;

				if(substr($to, 0,1) != "/"){$to = "/" . $to;}

				if(substr($to, strlen($to)-1,1) != "/"){$to .= "/";}

				$to = Replace($to, "\\", "/");

				move_uploaded_file($_FILES[$file]["tmp_name"], $_SESSION["DIRNAME"] . $to . $nomimg);

			}

			else{echo alert("Veuillez choisir un fichier qui a l'extension .jpg ou .jpeg ou .png", "", "", 1);}

		}

		else{echo alert("Veuillez choisir un fichier qui a l'extension .jpg ou .jpeg ou .png", "", "", 1);}

		return $str_retrn;

	}

	function exceltoserver($file, $to, $nom="")

	{

		$str_retrn = "";

		if(isset($_FILES[$file]) && $_FILES[$file]["name"] != "")

		{

			$strnomfichier=$_FILES[$file]["name"];

			$expl = explode(".", $strnomfichier);

			$strtypeimg = strtolower($expl[count($expl)-1]);

			if($strtypeimg == "xls" || $strtypeimg == "xlsx")

			{

				$nomimg = get_sitename().date("YmdHis");

				if($nom != ""){$nomimg = $nom;}

				$nomimg .= "." . $strtypeimg;

				$str_retrn = $nomimg;

				if(substr($to, 0,1) != "/"){$to = "/" . $to;}

				if(substr($to, strlen($to)-1,1) != "/"){$to .= "/";}

				$to = Replace($to, "\\", "/");

				move_uploaded_file($_FILES[$file]["tmp_name"], $_SESSION["DIRNAME"] . $to . $nomimg);

			}

			else{echo alert("Veuillez choisir un fichier qui a l'extension .xls ou .xlsx", "", "", 1);}

		}

		else{echo alert("Veuillez choisir un fichier qui a l'extension .xls ou .xlsx", "", "", 1);}

		return $str_retrn;

	}

	

	function deleteDir($dirPath)

	{

		if (is_dir($dirPath))

		{

			$objects = scandir($dirPath);

			foreach ($objects as $object) {

				if ($object != "." && $object !="..") {

					if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {deleteDir($dirPath . DIRECTORY_SEPARATOR . $object);}

					else {unlink($dirPath . DIRECTORY_SEPARATOR . $object);}

				}

			}

			reset($objects);

			rmdir($dirPath);

		}

	}

	function getexcel($excelFile)

	{

		$pathInfo = pathinfo($excelFile);

		$type = $pathInfo['extension'] == 'xlsx' ? 'Excel2007' : 'Excel5';



		$objReader = PHPExcel_IOFactory::createReader($type);

		$objPHPExcel = $objReader->load($excelFile);



		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

			$worksheets[$worksheet->getTitle()] = $worksheet->toArray();

		}



		return $worksheets;

	}

	function setloguser($det)

	{

		if($_SESSION["userpk"]!="" && $det!="")

		{

			/*

			$req="INSERT INTO user_log(user, details) VALUES('".$_SESSION["userpk"]."', ".injsql($det).");";

			bddmaj($req, true);

			*/

		}

	}

	function sendmsg($to, $suje, $msg)

	{

		$headers = "From: \"".get_sitename()."\"<".get_mailadmin().">\r\n";

		$headers .= "Reply-To: " . $to . "\r\n";

		$headers .= "Content-type: text/html; charset=utf-8" . "\r\n";

		$headers .= "MIME-Version: 1.0" . "\r\n";

		return mail($to, $suje, $msg, $headers, '');

	}

	

	function alert($txt, $strclor="", $aff="", $num, $str_otherscrpt="")

	{

		$strbtnstyl="";$striconap="<i class='fa fa-exclamation-triangle' ></i>";

		if(strtolower($strclor)=="ok"){$strclor="#5bbc85";}

		elseif(strtolower($strclor)=="warning"){$strclor="orange";$striconap="<i class='fa fa-exclamation-triangle' style='color:$strclor;' ></i>";}

		if($strclor!= ""){$strbtnstyl="background:$strclor;";$striconap="<i class='fa fa-check' style='color:$strclor;' ></i>";}

		$strstylpls="";if($aff=="1"){$strstylpls="display:none;";}

		return "<div class='dvalerte' id='dvalerte".$num."' style='$strstylpls' >

			<div class='dv_contentpop' >

				<h2>$striconap</h2>

				<div class='dvalertecnt' id='dvalertecnt".$num."' >$txt</div>

				<div class='dvalertebtn' >

					<div class='i_close' onclick=\"hide('dvalerte".$num."');$str_otherscrpt\" ><i class='fa fa-times' ></i> Fermer</div>

				</div>

			</div>

		</div>";

	}

	function get_numid($str_prfx="")

	{

		$req="SELECT valeur FROM param_glob WHERE nom='ref_tbl'";

		$tblval=bddfetch($req);

		$str_id=100000;

		if(isset($tblval[0]["valeur"])){$str_id=intval($tblval[0]["valeur"]);}

		$str_id++;

		$req="UPDATE param_glob SET valeur='$str_id' WHERE nom='ref_tbl'";

		bddmaj($req, true);

		return $str_id;

	}

	function getresultperpage($resultperpage)

	{

		?>

		<select onchange="document.cellForm.strpage.value=0;document.cellForm.submit();" name="resultperpage" class="form-control input-sm" style="float:none;" >

			<option value="10" <?php if($resultperpage==10){echo "selected";} ?> >10</option>

			<option value="25" <?php if($resultperpage==25){echo "selected";} ?> >25</option>

			<option value="50" <?php if($resultperpage==50){echo "selected";} ?> >50</option>

			<option value="100" <?php if($resultperpage==100){echo "selected";} ?> >100</option>

		</select>

		<?php

	}

	function getinputsearchopen($strmoserch)

	{

		?>

		<label>Chercher:<input type="search" name="strmoserch" class="form-control input-sm" placeholder="" value="<?php echo $strmoserch; ?>" onkeyup="serchopen(event);" ></label>

		<?php

	}

	function getpagination($page, $total, $perpage)

	{

		$toblok=($page*$perpage)+$perpage;

		if($toblok>$total){$toblok = $total;}

		$strnbrpg=(int)($total/$perpage);if($total%$perpage>0){$strnbrpg++;}

		if($total>0)

		{

		?>

		<div class="row dv_pagination">

			<div class="col-xs-6">

				<div class="dataTables_info" id="dynamic-table-example-1_info" role="status" aria-live="polite">Affichage de <?php echo ($page*$perpage)+1; ?> à <?php echo $toblok; ?> de <?php echo $total; ?> entrées</div>

			</div>

			<div class="col-xs-6">

				<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table-example-1_paginate">

					<ul class="pagination">

						<?php

						if($strnbrpg>1)

						{

						if($page>0){ ?>

						<li class="paginate_button previous" onclick="objnbrl=document.cellForm.strpage;objnbrl.value=Number(objnbrl.value)-1;document.cellForm.submit();" >

							<a href="#">Previous</a>

						</li>

						<?php 

						}

						$c=0;

						for($i=0; $i<$strnbrpg; $i++)

						{

							if($i<=2 || $i>=$strnbrpg-2 || $i==$page-1 || $i==$page || $i==$page+1)

							{

								?>

								<li class="paginate_button <?php if($i==$page){echo "active";} ?>" aria-controls="dynamic-table-example-1" tabindex="0">

									<a href="#" onclick="document.cellForm.strpage.value=<?php echo $i; ?>;document.cellForm.submit();" ><?php echo ($i+1); ?></a>

								</li>

								<?php 

							}

							else

							{

								if($i==$page+2){$c=0;}

								if($c==0)

								{

								?>

								<li class="paginate_button" >

									<a href="#" >...</a>

								</li>

								<?php 

								}

								$c++;

							}

						}

						if($page<($strnbrpg-1)){ ?>

						<li class="paginate_button next" onclick="objnbrl=document.cellForm.strpage;objnbrl.value=Number(objnbrl.value)+1;document.cellForm.submit();" >

							<a href="#">Next</a>

						</li>

						<?php 

							}

						}?>

					</ul>

				</div>

			</div>

		</div>

		<?php

		}

	}

	function getbtnmaj($isadd=true)

	{

		?>

		<div class="example-box-wrapper">

			<div class="content-box remove-border dashboard-buttons clearfix">

				<?php if($isadd){ ?>

				<a href="maj.php" class="btn vertical-button remove-border btn-success" title="">

					<span class="glyph-icon icon-separator-vertical">

						<i class="glyph-icon icon-plus"></i>

					</span>

					<span class="button-content">Créer</span>

				</a>

				<?php } ?>

				<a href="#" id="btn_supprimer" class="btn vertical-button remove-border btn-warning black-dialog dv_btndisable" title="" onclick="btnsupclick();" >

					<span class="glyph-icon icon-separator-vertical">

						<i class="glyph-icon icon-trash-o"></i>

					</span>

					<span class="button-content">Supprimer</span>

				</a>

			</div>

		</div>

		<?php

	}

	function get_post_pop($str_id,$pdo)

	{

		get_htmlpost(0, 100,$pdo, $str_id);

		return;

		?>

		<!--<script>

			function hode_popost(){hide('dv_popostid');getobj('body_glob').style.overflow='auto';}

		</script>

		<div class='dvalerte' id='dv_popostid' >

			<div class='dv_contentpop' style='width:90%;' >

				<div class='dvalertecnt' style='text-align:left;padding:0px;' >

					<?php get_htmlpost(0, 100,$pdo, $str_id); ?>

				</div>

				<div class='dvalertebtn' >

					<div class='i_close' onclick="hode_popost();" ><i class='fa fa-times' ></i> Fermer</div>

				</div>

			</div>

		</div>-->

		<?php

	}

	function get_postnew($str_postpour,$pdo)

	{

		//if($str_postpour==0){return false;}

		global $str_pour_pay, $str_pour_ville, $str_pour_metier, $str_pour_special, $str_pour_famille;

		if(rqstprm("txt_post")!="")

		{

			$str_image="";

			$chemin="/upload/posts/";

			$str_nomimg=Replace(strtolower(get_sitename()), " ", "-")."-post-".$_SESSION["userpk"]."-".time();

			if(isset($_FILES["txt_image"]) && $_FILES["txt_image"]["name"] != "")

			{$str_image=$chemin.filetoserver("txt_image", $chemin, $str_nomimg);}
		    $reqUser = "SELECT date_ajout FROM posts WHERE par=".injsql($_SESSION["userpk"],$pdo)." order by date_ajout DESC LIMIT 1";
		    $date_ajout=bddfetch($reqUser,$pdo);
		    if(empty($date_ajout[0])) {
              $hours = 12;
		    } else {
			    $time = new DateTime($date_ajout[0]['date_ajout']);
	    	    $current=new DateTime();
			    $diff = $time->diff($current);
	            $hours = (($diff->days * 24 * 60) + ($diff->h * 60))/60;
		    }
		    if(rqstprm("txt_updpost_id")!="")

			{
				$str_updt="";

				if($str_image!=""){$str_updt=", image=".injsql($str_image,$pdo)." ";}

				$strwhere="";

				if($_SESSION["user_type"]!=0){$strwhere=" AND par=".injsql($_SESSION["userpk"],$pdo)." ";}

				$req = "UPDATE posts SET detail=".injsql(htmlspecialchars(rqstprm("txt_post")),$pdo).", youtube=".injsql(htmlspecialchars(rqstprm("txt_youtube")),$pdo)." $str_updt WHERE id=".injsql(htmlspecialchars(rqstprm("txt_updpost_id")),$pdo)." $strwhere;";
                bddmaj($req,$pdo);
			}else if($hours>=12){
				$req = "INSERT INTO posts(detail, image, par, pour, youtube)

				VALUES(".injsql(htmlspecialchars(rqstprm("txt_post")),$pdo).", ".injsql($str_image,$pdo).", ".injsql($_SESSION["userpk"],$pdo).", ".injsql($str_postpour,$pdo).", ".injsql(htmlspecialchars(rqstprm("txt_youtube")),$pdo).");";
				bddmaj($req,$pdo);
			}
		}

		if(in_array($str_postpour, array(-1,0,1,2,3,4,5,6)) && rqstprm("txt_search")=="" && rqstprm("user")=="")

		{

		?>

		<form action="" method="POST" name="frm_post" id="frm_post" enctype="multipart/form-data" onsubmit="show_loading();" style="<?php if($str_postpour==99){echo "display:none;";} ?>" >
			<div class="post-topbar">

				<textarea name="txt_post" id="txt_post" class='put_post' placeholder="<?php echo get_label("lbl_exprimez_vous"); ?> " required ></textarea>

				<input type='hidden' name="txt_updpost_id" id="txt_updpost_id" />

				<div class="user-picy" >

					<i class='la la-picture-o i_btnpicture' id='i_pictpost' onclick="frm_post.txt_image.click();" ></i>

					<i class='la la-youtube i_btnpicture' id='i_btnyoutube' onclick="showb('dv_txtyoutube');hide('i_btnyoutube');" ></i>

					<i class="fas fa-hashtag i_btnhashtag" id='i_btnhashtag'></i>

					<div id='dv_hashtag'>

						<select class="js-example-disabled-results" id="items" multiple>
							<?php
							$reqTags = "SELECT * FROM tags";
		                    $tags=bddfetch($reqTags,$pdo);
		                    foreach ($tags as $t) {?>
		                    	<option><?php echo $t['tag'];?></option>
		                    <?php

		                    }
		                    ?>

					    </select>

						<i class='la la-times i_btnpicture i_btncancelpost'style='background:red;' onclick="hide('dv_hashtag');showb('i_btnhashtag');" ></i>

					</div>

					<div id='dv_txtyoutube' >

						<input type='text' name='txt_youtube' id='txt_youtube' class='filed_put' placeholder="https://www.youtube.com/embed/xxxxx" />

						<i class='la la-times i_btnpicture i_btncancelpost'style='background:red;' onclick="hide('dv_txtyoutube');showb('i_btnyoutube');" ></i>

					</div>

					<input type='file' name='txt_image' style='display:none;' onchange="selpictpost(this);" />

				</div>

				<div class="post-st">

					<ul>

						<li>

							<button type="button" class='dv_btn btn_annuler' onclick="cancel_post(this);" style='display:none;' >

								<?php echo get_label("lbl_annuler"); ?>

							</button>

						</li>

						<li>

							<button type="submit" class='dv_btn active submitPost' >

								<i class='fa fa-paper-plane' ></i>

								<!--

								<?php echo get_label("lbl_publier"); ?> 

								<?php

								if($str_postpour==0){echo "(".strtolower(get_label("lbl_monde")).")";}

								elseif($str_postpour==1){echo "(".strtolower($str_pour_pay).")";}

								elseif($str_postpour==2){echo "(".strtolower($str_pour_ville).")";}

								elseif($str_postpour==3){echo "(".strtolower($str_pour_metier).")";}

								elseif($str_postpour==4){echo "(".strtolower($str_pour_special).")";}

								elseif($str_postpour==5){echo "(".strtolower($str_pour_famille).")";}

								elseif($str_postpour==6){echo "(".strtolower(get_label("lbl_mon_profil")).")";}

								?>

								-->

							</button>

						</li>

					</ul>

				</div>

			</div>

		</form>

		<?php

		}

	}



	function get_loadpost2($str_postpour,$pdo, $nbr=-1)

	{

		global $is_adminsrch, $nbrperpag;

		?>

		<div class='company-title row p-0' >

		<?php

		if($nbr<=0){$i=get_htmlpost2(0, $str_postpour,$pdo);}

		else{$i=get_htmlpost2(0, $str_postpour,$pdo, '', $nbr);}

		?>

		</div>

		<?php

		if($i>=$nbrperpag)

		{

			$str_param="";

			if(rqstprm("txt_search")!=""){$str_param.="&txt_search=".rqstprm("txt_search");}

			if($is_adminsrch)

			{

				if(rqstprm("txt_masquer")!=""){$str_param.="&txt_masquer=".rqstprm("txt_masquer");}

				if(rqstprm("txt_pays")!=""){$str_param.="&txt_pays=".rqstprm("txt_pays");}

				if(rqstprm("txt_ville")!=""){$str_param.="&txt_ville=".rqstprm("txt_ville");}

				if(rqstprm("txt_metier")!=""){$str_param.="&txt_metier=".rqstprm("txt_metier");}

				if(rqstprm("txt_specialite")!=""){$str_param.="&txt_specialite=".rqstprm("txt_specialite");}

				$str_param.="&isadminsearch=1";

			}

			if($nbr<0)

			{

				?>

				<script>

					str_page=0; str_pour='<?php echo $str_postpour; ?>';

				</script>

				<div id='dv_post_ajax' ></div>

                <div id="btn_loadplus" > 

					<div class='dv_cntnbtnplus' onclick="load_ajax_post('<?php echo Replace($str_param, "'", "\\'"); ?>');" ><?php echo get_label('lbl_chargerplus'); ?></div>

				</div>

				<div class="process-comm" id='dv_loadingpost' style='display:none;' >

					<div class="spinner">

						<div class="bounce1"></div>

						<div class="bounce2"></div>

						<div class="bounce3"></div>

					</div>

				</div>

				<?php

			}

		}

		if($i<=0 && !$is_adminsrch && rqstprm("txt_search")=="")

		{

			if($str_postpour==6){echo "<div class='dv_noresult' >".get_label('lbl_aucunresultat')."</div>";}

			else{echo "<div class='dv_noresult' >".get_label('lbl_befirstposthere')."</div>";}

		}

	}



	function get_loadpost($str_postpour,$pdo, $nbr=-1)

	{

		global $is_adminsrch, $nbrperpag;

		?>

		<div class='company-title row p-0' >

		<?php

		if($nbr<=0){$i=get_htmlpost(0, $str_postpour,$pdo);}

		else{$i=get_htmlpost(0, $str_postpour,$pdo, '', $nbr);}

		?>

		</div>

		<?php

		if($i>=$nbrperpag)

		{

			$str_param="";

			if(rqstprm("txt_search")!=""){$str_param.="&txt_search=".rqstprm("txt_search");}

			if($is_adminsrch)

			{

				if(rqstprm("txt_masquer")!=""){$str_param.="&txt_masquer=".rqstprm("txt_masquer");}

				if(rqstprm("txt_pays")!=""){$str_param.="&txt_pays=".rqstprm("txt_pays");}

				if(rqstprm("txt_ville")!=""){$str_param.="&txt_ville=".rqstprm("txt_ville");}

				if(rqstprm("txt_metier")!=""){$str_param.="&txt_metier=".rqstprm("txt_metier");}

				if(rqstprm("txt_specialite")!=""){$str_param.="&txt_specialite=".rqstprm("txt_specialite");}

				$str_param.="&isadminsearch=1";

			}

			if($nbr<0)

			{

				?>

				<script>

					str_page=0; str_pour='<?php echo $str_postpour; ?>';

				</script>

				<div id='dv_post_ajax' ></div>

                <div id="btn_loadplus" > 

					<div class='dv_cntnbtnplus' onclick="load_ajax_post('<?php echo Replace($str_param, "'", "\\'"); ?>');" ><?php echo get_label('lbl_chargerplus'); ?></div>

				</div>

				<div class="process-comm" id='dv_loadingpost' style='display:none;' >

					<div class="spinner">

						<div class="bounce1"></div>

						<div class="bounce2"></div>

						<div class="bounce3"></div>

					</div>

				</div>

				<?php

			}

		}

		if($i<=0 && !$is_adminsrch && rqstprm("txt_search")=="")

		{

			if($str_postpour==6){echo "<div class='dv_noresult' >".get_label('lbl_aucunresultat')."</div>";}

			else{echo "<div class='dv_noresult' >".get_label('lbl_befirstposthere')."</div>";}

		}

	}





	function clear_param($param = "", $isset = false)

    {

        if ($isset) { return Replace(Replace(Replace($param, "#", "--DYIZ--"), "&", "--ANDCOM--"), "?", "--APOSTRO--"); }

        else { return Replace(Replace(Replace($param, "--DYIZ--", "#"), "--ANDCOM--", "&"), "--APOSTRO--", "?"); }

    }

	function is_arabic($str)

	{

		return (preg_match('/[اأإء-ي]/ui', $str));

	}

?>
