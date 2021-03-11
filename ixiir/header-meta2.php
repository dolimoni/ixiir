<?php

	include("global2.php");

	$str_postpour=0;

	if(!isset($str_title)){$str_title=get_sitename();}

	else{$str_title.=" - ".get_sitename();}

	if(!isset($str_page)){$str_page="";}

	if(rqstprm("acttion")=="logout"){set_logout();}

	if(!is_user_login() && $str_page!="login" && $str_page!="conditions")

	{

		$str_param="";

		if(rqstprm("pid")!=""){$str_param.="&pid=".rqstprm("pid");}

		if(rqstprm("from")!=""){$str_param.="&from=".rqstprm("from");}

		header("Location:".$strurlsite."sign-in.php?p=0".$str_param);exit;

	}

	elseif(is_user_login() && $str_page=="login" && $str_page!="conditions"){header("Location:".$strurlsite);exit;}

	elseif(is_user_login())

	{

		$str_pour_pay=""; $str_pour_ville=""; $str_pour_metier=""; $str_pour_special=""; $str_pour_famille="";

		if($_SESSION["userpk"]!="")

		{

			$req = "SELECT u.nom, u.prenom, p.nom_".$_SESSION["lang"]." AS NOMPAYS, v.nom_".$_SESSION["lang"]." AS NOMVILLE, m.nom_".$_SESSION["lang"]." AS NOMMETIER, s.nom_".$_SESSION["lang"]." AS NOMSPECIAL

					FROM user u

					LEFT JOIN pays p ON p.id=u.pays

					LEFT JOIN ville v ON v.id=u.ville

					LEFT JOIN metier m ON m.id=u.metier

					LEFT JOIN metier_specialiste s ON s.id=u.specialite

					WHERE u.id=".injsql($_SESSION["userpk"],$pdo);

			$dt_result=bddfetch($req,$pdo);

			foreach($dt_result as $line)

			{

				$str_pour_pay=$line["NOMPAYS"];

				$str_pour_ville=$line["NOMVILLE"];

				$str_pour_metier=$line["NOMMETIER"];

				$str_pour_special=$line["NOMSPECIAL"];

				$str_pour_famille=$line["nom"];

			}

		}

		if(rqstprm("f")=="i"){$str_postpour=0; $str_title.=" - ".get_label('lbl_monde');}

		if(rqstprm("f")=="p"){$str_postpour=1; $str_title.=" - ".$str_pour_pay;}

		if(rqstprm("f")=="v"){$str_postpour=2; $str_title.=" - ".$str_pour_ville;}

		if(rqstprm("f")=="m"){$str_postpour=3; $str_title.=" - ".$str_pour_metier;}

		if(rqstprm("f")=="d"){$str_postpour=4; $str_title.=" - ".$str_pour_special;}

		if(rqstprm("f")=="f"){$str_postpour=5; $str_title.=" - ".$str_pour_famille;}

		if(rqstprm("f")=="me"){$str_postpour=6; $str_title.=" - ".get_label('lbl_les_posts');}

		if($is_adminsrch){$str_postpour=-1;}

	}

	if(rqstprm("pid")==""){$str_title.=" - ".get_label("lbl_plusprochvous");}

	$str_idver=date("YmdHis");

?>

<!DOCTYPE html>

<html>



<!-- Mirrored from gambolthemes.net/html/workwise/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 13 Sep 2018 11:47:37 GMT -->

<head>

	<meta charset="UTF-8" />

	<title><?php echo $str_title; ?></title>

	<meta name="description" content="" />

	<meta name="keywords" content="" />

	<script>

		url_of_site='<?php echo $strurlsite; ?>';

		str_msgconf="<?php echo Replace(get_label('lbl_volezcontinue'), '"', "'"); ?>";

		if(window.history.replaceState){window.history.replaceState(null, null, window.location.href);}

	</script>



	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<link rel="shortcut icon" href="<?php echo $strurlsite; ?>images/icon.png">

	

	<link rel="stylesheet" type="text/css" href="<?php echo $strurlsite; ?>css/animate.css?v=<?php echo $str_idver; ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $strurlsite; ?>css/bootstrap.min.css?v=<?php echo $str_idver; ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $strurlsite; ?>css/line-awesome.css?v=<?php echo $str_idver; ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $strurlsite; ?>css/line-awesome-font-awesome.min.css?v=<?php echo $str_idver; ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $strurlsite; ?>css/font-awesome.min.css?v=<?php echo $str_idver; ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $strurlsite; ?>lib/slick/slick.css?v=<?php echo $str_idver; ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $strurlsite; ?>lib/slick/slick-theme.css?v=<?php echo $str_idver; ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $strurlsite; ?>css/style.css?v=<?php echo $str_idver; ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $strurlsite; ?>css/responsive.css?v=<?php echo $str_idver; ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $strurlsite; ?>css/flatpickr.min.css?v=<?php echo $str_idver; ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $strurlsite; ?>css/jquery.range.css?v=<?php echo $str_idver; ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $strurlsite; ?>css/jquery.mCustomScrollbar.min.css?v=<?php echo $str_idver; ?>">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

	<link href="https://fonts.googleapis.com/css?family=Tajawal" rel="stylesheet"> 

	

	<script type="text/javascript" src="<?php echo $strurlsite; ?>js/jquery.min.js?v=<?php echo $str_idver; ?>"></script>

	<script type="text/javascript" src="<?php echo $strurlsite; ?>js/popper.js?v=<?php echo $str_idver; ?>"></script>

	<script type="text/javascript" src="<?php echo $strurlsite; ?>js/bootstrap.min.js?v=<?php echo $str_idver; ?>"></script>

	<script type="text/javascript" src="<?php echo $strurlsite; ?>js/flatpickr.min.js?v=<?php echo $str_idver; ?>"></script>

	<script type="text/javascript" src="<?php echo $strurlsite; ?>js/jquery.mCustomScrollbar.js?v=<?php echo $str_idver; ?>"></script>

	<script type="text/javascript" src="<?php echo $strurlsite; ?>lib/slick/slick.min.js?v=<?php echo $str_idver; ?>"></script>

	<script type="text/javascript" src="<?php echo $strurlsite; ?>js/scrollbar.js?v=<?php echo $str_idver; ?>"></script>

	<script type="text/javascript" src="<?php echo $strurlsite; ?>js/script.js?v=<?php echo $str_idver; ?>"></script>

	<!--<script type="text/javascript" src="<?php echo $strurlsite; ?>js/disabled.js"></script>-->

	

	<!-- Global site tag (gtag.js) - Google Analytics -->

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-135770010-1"></script>

	<script>

	  window.dataLayer = window.dataLayer || [];

	  function gtag(){dataLayer.push(arguments);}

	  gtag('js', new Date());



	  gtag('config', 'UA-135770010-1');

	</script>



	<script>

		window.fbAsyncInit = function(){

		FB.init({

			appId: '<?php echo $str_facebook_appid; ?>', status: true, cookie: true, xfbml: true }); 

		};

		(function(d, debug){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];

			if(d.getElementById(id)) {return;}

			js = d.createElement('script'); js.id = id; 

			js.async = true;js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";

			ref.parentNode.insertBefore(js, ref);}(document, /*debug*/ false));

		function postToFeed(title, desc, url, image){

			var obj = {method: 'feed',link: url, picture: '<?php echo $strurlsite; ?>'+image,name: title,description: desc};

			function callback(response){}

			FB.ui(obj, callback);

		}

	</script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<?php

		if(rqstprm("pid")!="")

		{

			$str_image=""; $str_descr="";

			$dt_post=bddfetch("SELECT * FROM posts p WHERE id=".injsql(rqstprm("pid")),$pdo);

			if(isset($dt_post[0]["id"]))

			{

				$str_descr=$dt_post[0]["detail"];

				$str_image=$dt_post[0]["image"];

				?>

				<meta property="og:url" content="<?php echo curPageURL(); ?>" />

				<meta property="og:type" content="website" />

				<meta property="og:title" content="<?php echo $str_title; ?>" />

				<meta property="og:description" content="<?php echo $str_descr; ?>" />

				<meta property="og:image" content="<?php echo $strurlsite.$str_image; ?>" />

				<?php

			}

		}

	?>

</head>

<body class="sign-in" id="body_glob" style='' <?php if($_SESSION["lang"]=="ar"){echo "dir='rtl'";} ?> >

	<div id='dv_loading_glob' ><i class='fa fa-spinner fa fa-spin'></i></div>

	<?php if(rqstprm("from")=="ixiir" && 1==0){ ?>

	<div id='dv_poupexir' style="position:absolute;bottom:10px;right:10px;color:#fff;background:#f86309;padding:20px;text-align:center;z-index: 9999;" >

		<a href="http://ixiir.com/?go=back" style='background:rgba(255,255,255,0.6);padding:5px 20px;display:inline-block;border-radius:3px;color: #fff;' >النسخة القديمة</a>

		<div onclick="hide('dv_poupexir');" style='background:rgba(80,80,80,0.6);padding:5px 20px;display:inline-block;border-radius:3px;cursor:pointer;' >إغلاق</div>

	</div>

	<?php } ?>

	