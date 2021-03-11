<?php 

    include('inclus/googlelogin/gconfig.php');

	$str_page="login";

	$str_title="Authentification";

	require("header-meta.php");

	require_once 'inclus/facebook/src/Facebook/autoload.php';

	$fb = new \Facebook\Facebook([

		'app_id' => $str_facebook_appid,

		'app_secret' => $str_facebook_secret,

		'default_graph_version' => 'v2.2',

	]);

	$helper = $fb->getRedirectLoginHelper();

	$permissions = ['email'];

	$loginUrl = $helper->getLoginUrl($strurlsite.'inclus/facebook/call-back.php', $permissions);

	$str_urlface=htmlspecialchars($loginUrl);

	$str_urlgoogle='https://accounts.google.com/o/oauth2/v2/auth?scope='.urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me').'&redirect_uri='.urlencode($str_returnurlgoogle).'&response_type=code&client_id='.$str_google_appid.'&access_type=online';

	$str_param="";

	if(rqstprm("pid")!=""){$str_param.="post.php?pid=".rqstprm("pid");}

	$str_msg_err="";

	if(rqstprm("nameform")=="sinscrire")

	{

		if(rqstprm("txt_password")!=rqstprm("txt_repeat_password")){$str_msg_err="Le mot de passe et la confirmation du mot de passe sont différents";}

		elseif(rqstprm("chk_cvg")==""){$str_msg_err="Merci d'accepte les conditions.";}

		elseif(rqstprm("txt_nom")=="" || rqstprm("txt_prenom")=="" || rqstprm("txt_pays")=="" || rqstprm("txt_ville")=="")

		{$str_msg_err="Tous les champs sont obligatoire.";}

		else

		{

			$req= "SELECT * FROM user u WHERE u.login=".injsql(rqstprm("txt_email"),$pdo);

			$result = bddfetch($req,$pdo);

			if(isset($result[0]["id"]) && $result[0]["id"]!=""){$str_msg_err="E-mail existe déja.";}

			else

			{

				/*

				$req = "INSERT INTO user(nom, prenom, login, pass, pays, ville, metier, specialite) 

						VALUES(".injsql(rqstprm("txt_nom")).", ".injsql(rqstprm("txt_prenom")).", ".injsql(rqstprm("txt_email")).", ".injsql(rqstprm("txt_password"))."

								, ".injsql(rqstprm("txt_pays")).", ".injsql(rqstprm("txt_ville")).", ".injsql(rqstprm("txt_metier")).", ".injsql(rqstprm("txt_specialite")).")";

				*/

				$req = "INSERT INTO user(nom, prenom, login, pass, pays, ville, specialite) 

						VALUES(".injsql(rqstprm("txt_nom"),$pdo).", ".injsql(rqstprm("txt_prenom"),$pdo).", ".injsql(rqstprm("txt_email"),$pdo).", ".injsql(rqstprm("txt_password"),$pdo)."

								, ".injsql(rqstprm("txt_pays"),$pdo).", ".injsql(rqstprm("txt_ville"),$pdo).", ".injsql(rqstprm("txt_specialite"),$pdo).")";

				$str_idinsr=bddadgetid($req,$pdo);

				if($str_idinsr>0)

				{

					$_SESSION["userpk"] = $str_idinsr;

					$_SESSION["login"] = rqstprm("txt_email");

					$_SESSION["pass"] = rqstprm("txt_password");

					$_SESSION["nom"] = rqstprm("txt_nom");

					$_SESSION["prenom"] = rqstprm("txt_prenom");

					$_SESSION["pays"] = rqstprm("txt_pays");

					$_SESSION["ville"] = rqstprm("txt_ville");

					$_SESSION["metier"] = rqstprm("txt_metier");

					$_SESSION["specialite"] = rqstprm("txt_specialite");

					redirect($strurlsite.$str_param);

				}

				else{$str_msg_err=get_label("lbl_errservressay");}

			}

		}

	}

	elseif(rqstprm("nameform")=="login" && rqstprm("username")!="" && rqstprm("password")!="")

	{

		$str_msg_err=set_login(rqstprm("username"), rqstprm("password"), $pdo);

		if($str_msg_err=="OK"){$str_msg_err=""; redirect($strurlsite.$str_param);}

	}

?>

	<script>

		var n=0;

		function menuloginset()

		{

			//$('#dv_formlogin').removeClass('col-lg-4');

			$('#dv_formlogin').removeClass('bg-white');

			$('#dv_formlogin').addClass('bg-warning');

			//$('#dv_formlogin').addClass('col-lg-5');

			

			//$('#dv_postlogin').removeClass('col-lg-8');

			//$('#dv_postlogin').addClass('col-lg-7');

			try{clearTimeout(t2);}catch(ex){}

			t1=setTimeout(function(){ clin(); }, 500);

			//if(n==0)

			{

				 $('html, body').animate({

                    scrollTop: $("#dv_formlogin").offset().top

                }, 2000);

			}

		}

		function clin()

		{

			n++;

			try{clearTimeout(t1);}catch(ex){}

			$('#dv_formlogin').addClass('bg-white'); $('#dv_formlogin').removeClass('bg-warning');

			if(n<3){t2=setTimeout(function(){ menuloginset(); }, 500);}

			

		}

		

		

	</script>

	<div class="wrapper">

		<div class="sign-in-page" style="padding:0px;" >

			<div class="signin-popup" style="width:100%;" >

				<div class="signin-pop">

					<div class="row">

						<div class="col-lg-8 bg-light" id="dv_postlogin" >

							<div class="pt-3">

								<div class="<?php if($_SESSION["lang"]!="ar"){echo "text-left";}else{echo "text-right";} ?>" style='margin-bottom:0px;' >

									<div class='<?php if(isphone()){echo "col-md-6";} ?>' >

										

										<?php  if($_SESSION["lang"] == "fr") { ?>

										

											<img src="<?php echo $strurlsite; ?>images/cm-logo.png" alt="" style='margin-bottom:20px;max-height:64px;' />

										

										<?php } else if($_SESSION["lang"] == "ar") { ?>

										

											<img src="<?php echo $strurlsite; ?>images/logo_ar.png" alt="" style='margin-bottom:20px;max-height:64px;' />

										

										<?php } else { ?>

										

											<img src="<?php echo $strurlsite; ?>images/cm-logo.png" alt="" style='margin-bottom:20px;max-height:64px;' />

										

										<?php } ?>

										

									</div>

									<?php if(isphone()){ ?>

									<div class='col-md-6 text-right' >

										<button type="button" class="btn text-white btn-warning register-publish" onclick="menuloginset();" ><?php echo get_label("lbl_msgForPostMstCnct"); ?></button>

									</div>

									<?php } ?>

									<!--<p><?php echo get_label("lbl_descr_login"); ?></p>-->

									<?php if(rqstprm("from")=="ixiir"){ ?>

									<p style="padding:20px;text-align:center;" >

										<a href="http://ixiir.com/?go=back" target="_blank" style='background:#f86309;padding:10px 20px;display:inline-block;border-radius:3px;color: #fff;' ><?php echo get_label("lbl_oldversion"); ?></a>

										<!--<div onclick="hide('dv_poupexir');" style='background:rgba(80,80,80,0.6);padding:5px 20px;display:inline-block;border-radius:3px;cursor:pointer;' >إغلاق</div>-->

									</p>

									<?php } ?>

								</div><!--cm-logo end-->	

								<!--<img src="<?php echo $strurlsite; ?>images/cm-main-img.png" alt="" />-->

							</div><!--cmp-info end-->

							<div class='clearfix' ></div>

							<div class='mb-4 text-center' style='background:#a349a4;' onclick="menuloginset();" >

								<!--

								<div class='text-white p-3 dv_menusignin' ><i class="la la-group"></i> 

								<?php echo get_label('lbl_ma_famille'); ?></div>

								<div class='text-white p-3 dv_menusignin' ><i class="la la-briefcase"></i> 

								<?php echo get_label('lbl_mon_metier'); ?></div>

								<div class='text-white p-3 dv_menusignin' ><i class="la la-tags"></i> 

								<?php echo get_label('lbl_mon_domaine'); ?></div>

								-->

								<?php

								?>

								<div class='text-white p-3 dv_menusignin' ><i class="la la-map-marker"></i> <?php echo get_label('lbl_ma_ville'); ?></div>

								<div class='text-white p-3 dv_menusignin' ><i class="la la-flag"></i> <?php echo get_label('lbl_mon_pays'); ?></div>

								<div class='text-white p-3 dv_menusignin bg-warning' ><i class="la la-home"></i> <?php echo get_label('lbl_monde'); ?></div>

							</div>
							<?php get_loadpost2($str_postpour,$pdo); ?>
							<div class="clearfix"></div>
							<div class='mb-4 p-2' style='font-size:18pt;background:#eee;' ><i class="la la-clock-o"></i> <?php echo get_label('lbl_lastpost'); ?></div>

							<div class="pd-right-none no-pd"><div class="main-ws-sec">
                                
								<div class="posts-section">

									<?php get_loadpost(0,$pdo, 20); ?>

								</div>

								</div></div> 

							<div class='clearfix' ></div>

							<div class='mb-4 p-2 text-center' style='font-size:15pt;background:#fd8222;color:#fff;' ><?php echo get_label('lbl_connectToView'); ?></div>

						</div>

						<div class="col-lg-4" id="dv_formlogin" >

							<div class="login-sec">

								<ul class="sign-control">

									<li data-tab="tab-1" class="<?php if(rqstprm("nameform")=="" || rqstprm("nameform")=="login"){echo "current";} ?>"><a href="#" title=""><?php echo get_label("lbl_login"); ?></a></li>				

									<li data-tab="tab-2" class="<?php if(rqstprm("nameform")=="sinscrire"){echo "current";} ?>"><a href="#" title=""><?php echo get_label("lbl_sinscrit"); ?></a></li>				

								</ul>			

								<div class="sign_in_sec <?php if(rqstprm("nameform")=="" || rqstprm("nameform")=="login"){echo "current";} ?>" id="tab-1">

									

									<h3><?php echo get_label("lbl_login"); ?></h3>

									<?php if($str_msg_err!=""){echo "<p class='p_msg_erreur' >$str_msg_err</p>";} ?>

									<form action="" method="POST" >

										<div class="row">

											<div class="col-lg-12 no-pdd">

												<div class="sn-field">

													<input type="text" name="username" placeholder="<?php echo get_label("lbl_email"); ?>" />

													<i class="la la-envelope"></i>

												</div><!--sn-field end-->

											</div>

											<div class="col-lg-12 no-pdd">

												<div class="sn-field">

													<input type="password" name="password" placeholder="<?php echo get_label("lbl_password"); ?>" />

													<i class="la la-lock"></i>

												</div>

											</div>

											<div class="col-lg-12 no-pdd">

												<div class="checky-sec">

													<div class="fgt-sec">

														<a href="#" title=""><?php echo get_label("lbl_mot_passe_oublie"); ?></a>

													</div>

												</div>

											</div>

											<div class="col-lg-12 no-pdd">

												<input type="hidden" name="nameform" value="login" />

												<button type="submit" value="submit"><?php echo get_label("lbl_login"); ?></button>

											</div>

										</div>

									</form>

									<div class="login-resources">

										<h3 style="text-align:left;" ><?php echo get_label("lbl_connexion_via_reseau_soc"); ?></h3>

										<ul>

											<li><a href="<?php echo $str_urlface; ?>" title="" class="fb"><i class="fa fa-facebook"></i><?php echo  get_label("lbl_connexion_facebook"); ?></a></li>

										

											<li><a href="<?php echo $google_client->createAuthUrl(); ?>" title="" class="gp"><i class="fa fa-google-plus"></i><?php echo get_label("lbl_connexion_googleplus"); ?></a></li> 

											

										</ul>

									</div><!--login-resources end-->

								</div><!--sign_in_sec end-->

								<div class="sign_in_sec <?php if(rqstprm("nameform")=="sinscrire"){echo "current";} ?>" id="tab-2">

									<h3 style="text-align:left;" ><?php echo get_label("lbl_sinscrit"); ?></h3>

									<div class="dff-tab current" id="tab-3">

										<?php if($str_msg_err!=""){echo "<p class='p_msg_erreur' >$str_msg_err</p>";} ?>

										<form action="" method="POST" name="frm_inscr" >

											<div class="row">

												<div class="col-lg-12 no-pdd">

													<div class="sn-field">

														<input type="text" name="txt_nom" placeholder="<?php echo get_label("lbl_nom"); ?>" value="<?php echo rqstprm("txt_nom"); ?>" required />

														<i class="la la-user"></i>

													</div>

												</div>

												<div class="col-lg-12 no-pdd">

													<div class="sn-field">

														<input type="text" name="txt_prenom" placeholder="<?php echo get_label("lbl_prenom"); ?>" value="<?php echo rqstprm("txt_prenom"); ?>" required />

														<i class="la la-user"></i>

													</div>

												</div>

												<div class="col-lg-12 no-pdd">

													<div class="sn-field">

														<select name="txt_pays" onchange="get_option(this.value, '', 'ville');" required >

															<option value='' ><?php echo get_label("lbl_pays"); ?></option>

															<?php

															$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMPAY FROM pays p ORDER BY `order`, NOMPAY";

															$result = bddfetch($req,$pdo);

															foreach($result as $line)

															{

																$str_sel="";if($line["id"]==rqstprm("txt_pays")){$str_sel="selected";}

																echo "<option value='".$line["id"]."' $str_sel >".$line["NOMPAY"]."</option>";

															}

															?>

														</select>

														<i class="la la-globe"></i>

														<span><i class="fa fa-ellipsis-h"></i></span>

													</div>

												</div>

												<div class="col-lg-12 no-pdd">

													<div class="sn-field">

														<select name="txt_ville" required >

															<option value='' ><?php echo get_label("lbl_ville"); ?></option>

															<?php

															$str_pay="1";if(rqstprm("txt_pays")!=""){$str_pay=rqstprm("txt_pays");}

															$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMVILLE FROM ville WHERE pays='$str_pay' ORDER BY `order`, NOMVILLE";

															$result = bddfetch($req,$pdo);

															foreach($result as $line)

															{

																$str_sel="";if($line["id"]==rqstprm("txt_ville")){$str_sel="selected";}

																echo "<option value='".$line["id"]."' $str_sel >".$line["NOMVILLE"]."</option>";

															}

															?>

														</select>

														<i class="la la-map-marker"></i>

														<span><i class="fa fa-ellipsis-h"></i></span>

													</div>

												</div>

												<div class="col-lg-12 no-pdd" style='display:none;' >

													<div class="sn-field">

														<select name="txt_metier" onchange="get_option(this.value, '', 'specialite');" >

															<option value='' ><?php echo get_label("lbl_domaine"); ?></option>

															<?php

															$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMPAY FROM metier p ORDER BY NOMPAY";

															$result = bddfetch($req,$pdo);

															foreach($result as $line)

															{

																$str_sel="";if($line["id"]==rqstprm("txt_metier")){$str_sel="selected";}

																echo "<option value='".$line["id"]."' $str_sel >".$line["NOMPAY"]."</option>";

															}

															?>

														</select>

														<i class="la la-briefcase"></i>

														<span><i class="fa fa-ellipsis-h"></i></span>

													</div>

												</div>

												<div class="col-lg-12 no-pdd">

													<div class="sn-field">

														<select name="txt_specialite" >

															<option value='' ><?php echo get_label("lbl_specialite"); ?></option>

															<?php

															$str_metier="";if(rqstprm("txt_metier")!=""){$str_metier=rqstprm("txt_metier");}

															$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMLINE FROM metier_specialiste WHERE metier IS NULL OR metier='$str_metier' ORDER BY NOMLINE";

															$result = bddfetch($req,$pdo);

															foreach($result as $line)

															{

																$str_sel="";if($line["id"]==rqstprm("txt_specialite")){$str_sel="selected";}

																echo "<option value='".$line["id"]."' $str_sel >".$line["NOMLINE"]."</option>";

															}

															?>

														</select>

														<i class="la la-tags"></i>

														<span><i class="fa fa-ellipsis-h"></i></span>

													</div>

												</div>

												<div class="col-lg-12 no-pdd">

													<div class="sn-field">

														<input type="email" name="txt_email" placeholder="<?php echo get_label("lbl_email"); ?>" value="<?php echo rqstprm("txt_email"); ?>" required />

														<i class="la la-envelope"></i>

													</div>

												</div>

												<div class="col-lg-12 no-pdd">

													<div class="sn-field">

														<input type="password" name="txt_password" placeholder="<?php echo get_label("lbl_password"); ?>" value="<?php echo rqstprm("txt_password"); ?>" required />

														<i class="la la-lock"></i>

													</div>

												</div>

												<div class="col-lg-12 no-pdd">

													<div class="sn-field">

														<input type="password" name="txt_repeat_password" placeholder="<?php echo get_label("lbl_repeter_mot_passe"); ?>" value="<?php echo rqstprm("txt_repeat_password"); ?>" required />

														<i class="la la-lock"></i>

													</div>

												</div>

												<div class="col-lg-12 no-pdd">

													<div class="checky-sec st2">

														<div class="fgt-sec">

															<input type="checkbox" name="chk_cvg" id="c2" value="yes" />

															<label for="c2">

																<span></span>

															</label>

															<small><?php echo Replace(get_label("lbl_yes_acepcondi"), "[[PARAM]]", $strurlsite."conditions.php"); ?></small>

														</div><!--fgt-sec end-->

													</div>

												</div>

												<div class="col-lg-12 no-pdd">

													<input type="hidden" name="nameform" value="sinscrire" />

													<button type="submit" ><?php echo get_label("lbl_sinscrit"); ?></button>

												</div>

											</div>

										</form>

									</div><!--dff-tab end-->

								</div>		

							</div><!--login-sec end-->

						</div>

					</div>		

				</div><!--signin-pop end-->

			</div><!--signin-popup end-->

			

		</div><!--sign-in-page end-->





	</div><!--theme-layout end-->

	<?php

	if(rqstprm("oper")=="desactive"){echo alert(get_label("lbl_cmptinactive"), "", "", 1);}

	if(rqstprm("e")=="notconnect"){echo alert(get_label("lbl_errorlorathent"), "", "", 1);}

	?>
<?php require("footer.php"); ?>