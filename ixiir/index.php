<?php $str_page="accueil"; require("header-meta2.php"); var_dump("tfou");?>     

	<div class="wrapper">

		<?php

			$str_autrparam="";

			if(rqstprm("pstusr")!=""){$str_autrparam.="&pstusr=".rqstprm("pstusr");}

			require("header-menu.php");

			if(($str_postpour==1 && $str_pour_pay=="") || ($str_postpour==2 && $str_pour_ville=="") || ($str_postpour==3 && $str_pour_metier=="") || ($str_postpour==4 && $str_pour_special=="") || ($str_postpour==5 && $str_pour_famille==""))

			{Redirect(get_url("profil")."?e=info");}

		?>
        
       
		<main>

			<div class="main-section" id="dv_mainlistpost" >

				<div class="container">

					<div class="main-section-data">

						<div class="row">

							<div class="col-lg-3 col-md-8 no-pd" id="dv_leftpartpost" >

								<div class="main-left-sidebar no-margin">

									<div class="user-data full-width">

										<div class="user-profile">

											<div class="username-dt">

												<div class="usr-pic" style="background-image:url(<?php echo img_userdef($_SESSION["user_image"]); ?>);" ></div>

											</div><!--username-dt end-->

											<div class="user-specs">

												<h3><?php echo $_SESSION["prenom"]." ".$_SESSION["nom"]; ?></h3>

												<span>

													<?php

														$metier=get_metier($_SESSION["metier"],$pdo);

														$specialite=get_specialite($_SESSION["specialite"],$pdo);

														echo /*$metier["NOMLBL"]." - ".*/$specialite["NOMLBL"];

														get_user_statique($_SESSION["userpk"],$pdo, $_SESSION["pays"]);

													?>

												</span>

											</div>

										</div><!--user-profile end-->

										<ul class="user-fw-status">

											<li>

												<a href="<?php echo get_url("profil"); ?>" title=""><?php echo get_label("lbl_viewprofil"); ?></a>

											</li>

										</ul>

									</div>

								</div>

								<div class="right-sidebar">

									<div class="widget widget-about">

										<img src="<?php echo $strurlsite; ?>images/cm-logo.png" alt="" style='margin:20px 0px;' />

										<h3><?php echo get_label("lbl_comutilefficace"); ?></h3>

										<span style="padding:10px 20px;" ><?php echo get_label("lbl_restconnectenvr"); ?></span>

									</div>

									<div class="tags-sec full-width">

										<?php get_lienfooter(); ?>

										<div class="cp-sec">

											<!--<img src="<?php echo $strurlsite; ?>images/logo2.png" alt="">-->

											<?php get_copieright(); ?>

										</div>

									</div>

								</div>

							</div>

							<div class="col-lg-9 pd-right-none no-pd">

								<div class="main-ws-sec">

									<?php get_postnew($str_postpour,$pdo); ?>

									<?php get_loadpost2($str_postpour,$pdo); ?>

									<div class="posts-section">

										<?php

										if($_SESSION["user_type"]==0 && !isphone())

										{

											?>

											<div class='company-title' style='padding:0px;' >

												<h3><?php echo get_label('lbl_searchpost'); ?> <i class='la la-plus-square-o' onclick="show('dv_searchpostadm');$(this).hide();" style="cursor:pointer;" ></i></h3>

												<div id='dv_searchpostadm' >

													<form action="" method="POST" name="frm_inscr" enctype="multipart/form-data" onsubmit="show_loading();" >

														<input type='hidden' name='isadminsearch' value='1' />

														<input type='text' name='txt_search' value='<?php echo rqstprm("txt_search"); ?>' placeholder='<?php echo get_label("lbl_mot_cle"); ?>' class='filed_put' />

														<select name="txt_masquer" class='filed_put' >

															<option value='0' <?php if(rqstprm("txt_masquer")=="0"){echo "selected";} ?> ><?php echo get_label("lbl_non_masquer"); ?></option>

															<option value='1' <?php if(rqstprm("txt_masquer")=="1"){echo "selected";} ?> ><?php echo get_label("lbl_masquer"); ?></option>

														</select>

														<select name="txt_pays" onchange="get_option(this.value, '', 'ville');" class='filed_put' >

															<option value='' ><?php echo get_label("lbl_pays"); ?></option>

															<?php

															$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMPAY FROM pays p ORDER BY NOMPAY";

															$result = bddfetch($req,$pdo);

															foreach($result as $line)

															{

																$str_sel="";if(($line["id"]==rqstprm("txt_pays"))){$str_sel="selected";}

																echo "<option value='".$line["id"]."' $str_sel >".$line["NOMPAY"]."</option>";

															}

															?>

														</select>

														<select name="txt_ville" class='filed_put' >

															<option value='' ><?php echo get_label("lbl_ville"); ?></option>

															<?php

															$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMVILLE FROM ville WHERE pays='".rqstprm("txt_pays")."' ORDER BY NOMVILLE";

															$result = bddfetch($req,$pdo);

															foreach($result as $line)

															{

																$str_sel="";if($line["id"]==rqstprm("txt_ville")){$str_sel="selected";}

																echo "<option value='".$line["id"]."' $str_sel >".$line["NOMVILLE"]."</option>";

															}

															?>

														</select>

														<select name="txt_metier" onchange="get_option(this.value, '', 'specialite');" class='filed_put' >

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

														<select name="txt_specialite" class='filed_put' >

															<option value='' ><?php echo get_label("lbl_specialite"); ?></option>

															<?php

															$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMLINE FROM metier_specialiste WHERE metier IS NULL OR metier='".rqstprm("txt_metier")."' ORDER BY NOMLINE";

															$result = bddfetch($req,$pdo);

															foreach($result as $line)

															{

																$str_sel="";if($line["id"]==rqstprm("txt_specialite")){$str_sel="selected";}

																echo "<option value='".$line["id"]."' $str_sel >".$line["NOMLINE"]."</option>";

															}

															?>

														</select>

														<input type="submit" class="dv_btn active" value="<?php echo get_label('lbl_rechercher'); ?>" style='margin:5px;' />

													</form>

												</div>

											</div>

											<?php

										}

										?>

										<div class='company-title row' style='background:#fff;padding:0px;' >

											<a href="<?php echo $strurlsite."?f=".rqstprm("f")."&orderpst=0".$str_autrparam; ?>" class='col-md-6 dv_btnfilter <?php if($str_orderpost==0){echo "dv_filteractive";} ?>' ><i class="la la-clock-o"></i> <?php echo get_label('lbl_lastpost'); ?></a>

											<a href="<?php echo $strurlsite."?f=".rqstprm("f")."&orderpst=1".$str_autrparam; ?>" class='col-md-6 dv_btnfilter <?php if($str_orderpost==1){echo "dv_filteractive";} ?>' ><i class="fa fa-fire"></i> <?php echo get_label('lbl_mostineractive'); ?></a>

											<div class='clearfix' ></div>

										</div>

										<?php get_loadpost($str_postpour,$pdo); ?>

									</div>

								</div><!--main-ws-sec end-->

							</div>

						</div>

					</div>

				</div> 

			</div>

		</main>



	</div><!--theme-layout end-->



<?php require("footer.php"); ?>