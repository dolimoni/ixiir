<?php $str_page=""; require("header-meta.php"); 

function sumTrophy($pdo,$user){
	$income=0.0;
	//get sum trophy
	$reqTrophy="SELECT trophy,count(*) as numb from posts where trophy is not null and par=".injsql($user,$pdo)." group by trophy";
	$dt_resultTrophy=bddfetch($reqTrophy,$pdo);
	$prices=array(0.5,0.3,0.1,0.09,0.07);
	foreach($dt_resultTrophy as $trophy){
		$income+=$trophy['numb']*$prices[$trophy['trophy']-1];
	}
	return $income;
}
?>
	<div class="wrapper">
		<?php
		$isreload=false; $str_msg_err="";
		
		if(rqstprm("txt_nom")!="" && rqstprm("txt_email")!="" && rqstprm("user")=="")
		{
			if(rqstprm("txt_password")!=rqstprm("txt_repeat_password")){$str_msg_err=get_label('lbl_passconfwrng');}
			else
			{
				$req= "SELECT * FROM user u WHERE u.login=".injsql(rqstprm("txt_email"),$pdo)." AND u.id<>".injsql($_SESSION["userpk"],$pdo);
				$result = bddfetch($req,$pdo);
				if(isset($result[0]["id"]) && $result[0]["id"]!=""){$str_msg_err=get_label('lbl_emailexist');}
				else
				{
					$str_image="";
					$chemin="/upload/user/";
					$str_nomimg=Replace(strtolower(get_sitename()), " ", "-")."-user-".$_SESSION["userpk"]."-".time();
					if(isset($_FILES["txt_image"]) && $_FILES["txt_image"]["name"] != "")
					{$str_image=$chemin.filetoserver("txt_image", $chemin, $str_nomimg);}
					$str_updt="";
					if($str_image!=""){$str_updt.=", image=".injsql($str_image,$pdo);}
					/*
					$req = "UPDATE user SET nom=".injsql(rqstprm("txt_nom")).", prenom=".injsql(rqstprm("txt_prenom")).", login=".injsql(rqstprm("txt_email"))."
								, pass=".injsql(rqstprm("txt_password")).", pays=".injsql(rqstprm("txt_pays")).", ville=".injsql(rqstprm("txt_ville"))."
								, metier=".injsql(rqstprm("txt_metier")).", specialite=".injsql(rqstprm("txt_specialite")).", lang=".injsql(rqstprm("txt_langue"))."
								$str_updt
							WHERE id=".injsql($_SESSION["userpk"]);
					*/
					$req = "UPDATE user SET nom=".injsql(rqstprm("txt_nom"),$pdo).", prenom=".injsql(rqstprm("txt_prenom"),$pdo).", login=".injsql(rqstprm("txt_email"),$pdo)."
								, pass=".injsql(rqstprm("txt_password"),$pdo).", pays=".injsql(rqstprm("txt_pays"),$pdo).", ville=".injsql(rqstprm("txt_ville"),$pdo)."
								, lang=".injsql(rqstprm("txt_langue"),$pdo)."
								, specialite=".injsql(rqstprm("txt_specialite"),$pdo)."
								$str_updt
							WHERE id=".injsql($_SESSION["userpk"],$pdo);
					$nbr=bddmaj($req,$pdo);
					$_SESSION["login"] = rqstprm("txt_email");
					$_SESSION["pass"] = rqstprm("txt_password");
					$_SESSION["nom"] = rqstprm("txt_nom");
					$_SESSION["prenom"] = rqstprm("txt_prenom");
					$_SESSION["pays"] = rqstprm("txt_pays");
					$_SESSION["ville"] = rqstprm("txt_ville");
					$_SESSION["metier"] = rqstprm("txt_metier");
					$_SESSION["specialite"] = rqstprm("txt_specialite");
					$_SESSION["lang"] = rqstprm("txt_langue");
					if($str_image!=""){$_SESSION["user_image"] = $str_image;}
				}
			}
			$isreload=true;
		}
		require("header-menu.php"); 
		$str_partactive=0;
		if(rqstprm("s")=="message"){$str_partactive=1;}
		if(rqstprm("s")=="newmsg"){$str_partactive=3;}
		if(rqstprm("s")=="messagesend"){$str_partactive=4;}
		if(rqstprm("s")=="post"){$str_partactive=5;}
		if(rqstprm("txt_isdesactive")!="" && (rqstprm("user")=="" || ($_SESSION["user_type"]==0 && rqstprm("user")!="")))
		{
			if(rqstprm("txt_pass_out")==$_SESSION["pass"] || ($_SESSION["user_type"]==0 && rqstprm("user")!=""))
			{
				$str_userid=$_SESSION["userpk"];
				$str_byadmin=0;
				if($_SESSION["user_type"]==0 && rqstprm("user")!=""){$str_userid=rqstprm("user"); $str_byadmin=1;}
				$req = "UPDATE user SET detail_desactive=".injsql(rqstprm("txt_desc_out"),$pdo).", user_vld=0, bloqbyadmin=$str_byadmin, date_out=CURRENT_TIMESTAMP
						WHERE id=".injsql($str_userid,$pdo);
				$nbr=bddmaj($req,$pdo);
				redirect($strurlsite."sign-in.php?acttion=logout&oper=desactive");
			}
			else{$str_msg_err=get_label('lbl_passincorect');$str_partactive=2;}
			$isreload=true;
		}
		
		$str_pk=$_SESSION["userpk"];
		$str_img=$_SESSION["user_image"];
		$str_nompr=$_SESSION["prenom"] . " " . $_SESSION["nom"];
		$str_metier=$_SESSION["metier"];
		$str_specialite=$_SESSION["specialite"];
		$user=null;
		$req = "UPDATE user_abonne SET abonne_del=1
				WHERE user_vue=".injsql($_SESSION["userpk"],$pdo)." AND add_auto=1
					AND user_id NOT IN (SELECT uv.user_id FROM user_vue uv WHERE uv.user_vue=".injsql($_SESSION["userpk"],$pdo)." AND uv.date_ajout>=DATE_SUB(NOW(), INTERVAL 7 DAY))";
		bddmaj($req,$pdo);
		if(rqstprm("user")!="")
		{
			$req = "SELECT * FROM user u WHERE u.id=".injsql(rqstprm("user"),$pdo);
			$dt_result=bddfetch($req,$pdo);
			
			if(isset($dt_result[0]))
			{
				$nbr_vue=0;
				$user=$dt_result[0];
				$req="SELECT DATE_ADD(max(uv.date_ajout), INTERVAL 1 HOUR) AS DTMAX, COUNT(*) AS NBRTOT FROM user_vue uv 
						WHERE uv.user_id=".injsql(rqstprm("user"),$pdo)." AND uv.user_vue=".injsql($_SESSION["userpk"],$pdo)." AND uv.date_ajout>=DATE_SUB(NOW(), INTERVAL 7 DAY)";
				$dt_nbrvue=bddfetch($req,$pdo);
				if(isset($dt_nbrvue[0]["NBRTOT"])){$nbr_vue=$dt_nbrvue[0]["NBRTOT"];}
				$is_addvisit=true;
				if($nbr_vue>0){
					if(strtotime(date("Y-m-d H:i:s"))<strtotime($dt_nbrvue[0]["DTMAX"])){$is_addvisit=false;}
				}
				if(isset($dt_nbrvue[0]["DTMAX"])){$nbr_vue=$dt_nbrvue[0]["DTMAX"];}
				if($is_addvisit)
				{
					$req = "INSERT INTO user_vue(user_id, user_vue) VALUES(".injsql(htmlspecialchars(rqstprm("user")),$pdo).", ".injsql(htmlspecialchars($_SESSION["userpk"]),$pdo).");";
					bddmaj($req,$pdo);
				}
				if((intval($nbr_vue)+1)>7)
				{
					$req="SELECT COUNT(*) AS NBRTOT FROM user_abonne ub WHERE ub.user_vue=".injsql($_SESSION["userpk"],$pdo);
					$dt_abonne=bddfetch($req,$pdo);
					if($dt_abonne[0]["NBRTOT"]<=0)
					{
						$req="INSERT INTO user_abonne(user_id, user_vue, abonne_del, add_auto) VALUES(".injsql(htmlspecialchars(rqstprm("user")),$pdo).", ".injsql(htmlspecialchars($_SESSION["userpk"]),$pdo).", 0, 1);";
						bddmaj($req,$pdo);
					}
				}
			}
			for($i=0; $i<count($dt_result); $i++)
			{
				$str_pk=$dt_result[$i]["id"];
				$str_img=$dt_result[$i]["image"];
				$str_nompr=$dt_result[$i]["prenom"] . " " . $dt_result[$i]["nom"];
				$str_metier=$dt_result[$i]["metier"];
				$str_specialite=$dt_result[$i]["specialite"];
			}
			//get sum trophy
			$income=sumTrophy($pdo,rqstprm("user"));
		}
		else
		{
			$req = "SELECT * FROM user u WHERE u.id=".injsql($_SESSION["userpk"],$pdo);
			$dt_result=bddfetch($req,$pdo);
			if(isset($dt_result[0])){$user=$dt_result[0];}
			$income=sumTrophy($pdo,$_SESSION["userpk"]);
		}
		if(rqstprm("txt_message")!="")
		{
			$isreload=true;
			$str_partactive=3;
			if(rqstprm("idajax_userid")!="")
			{
				$req = "INSERT INTO message(msg_du, msg_au, message) VALUES(".injsql(htmlspecialchars($_SESSION["userpk"]),$pdo).", ".injsql(htmlspecialchars(rqstprm("idajax_userid")),$pdo).", ".injsql(htmlspecialchars(rqstprm("txt_message")),$pdo).")";
				$nbr=bddmaj($req,$pdo);
				echo alert(get_label('lbl_msgoksendmsg'), "", "", 1);
			}
			else{$str_msg_err=get_label("lbl_nomobligatoire");}
		}
		if(!isset($user["id"])){redirect($strurlsite);}
		else
		{
		?>

		<section class="profile-account-setting">
			<div class="container">
				<div class="account-tabs-setting">
					<div class="row">
						<div class="col-lg-3">
							<div class="main-left-sidebar no-margin">
								<div class="user-data full-width">
									<div class="user-profile">
										<div class="username-dt">
											<div class="usr-pic" style="background-image:url(<?php echo img_userdef($str_img); ?>);" ></div>
										</div><!--username-dt end-->
										<div class="user-specs">
											<h3><?php echo $str_nompr; ?></h3>
											<span>
												<?php
													$metier=get_metier($str_metier, $pdo);
													$specialite=get_specialite($user["specialite"], $pdo);
													echo /*$metier["NOMLBL"]." - ".*/$specialite["NOMLBL"];
													get_btn_suivi($user["id"], $pdo);
													get_user_statique($user["id"],$pdo, $user["pays"],$income);
												?>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="acc-leftbar full-width">
								<div class="nav nav-tabs" id="nav-tab" role="tablist">
									<a class="nav-item nav-link <?php if($str_partactive==5){echo "active";} ?>" id="nav-mespst-tab" data-toggle="tab" href="#nav-mespst" role="tab" aria-controls="nav-mespst" aria-selected="true"><i class="la la-file"></i><?php if(rqstprm("user")!=""){echo get_label('lbl_les_posts');}else{echo get_label('lbl_maPage');} ?></a>
									<a class="nav-item nav-link <?php if($str_partactive==0){echo "active";} ?>" id="nav-acc-tab" data-toggle="tab" href="#nav-acc" role="tab" aria-controls="nav-acc" aria-selected="true"><i class="la la-cogs"></i><?php echo get_label('lbl_profil'); ?></a>
									<?php if(rqstprm("user")!=""){ ?>
									<a class="nav-item nav-link <?php if($str_partactive==3){echo "active";} ?>" id="nav-newmsg-tab" data-toggle="tab" href="#nav-newmsg" role="tab" aria-controls="nav-newmsg" aria-selected="true"><i class="la la-envelope"></i><?php echo get_label('lbl_envoyermessage'); ?></a>
									<?php }else{ ?>
								    <a class="nav-item nav-link <?php if($str_partactive==1){echo "active";} ?>" href="<?php echo $strurlsite."mon-profil.php?s=message" ?>" ><i class="fa fa-envelope"></i><?php echo get_label('lbl_mes_messages'); ?></a>
									<?php }
									if($_SESSION["user_type"]==0){?>
									<a class="nav-item nav-link <?php if($str_partactive==2){echo "active";} ?>" id="nav-deactivate-tab" data-toggle="tab" href="#nav-deactivate" role="tab" aria-controls="nav-deactivate" aria-selected="false"><i class="fa fa-random"></i><?php echo get_label('lbl_desactivacount'); ?></a>
								   <?php }?>
								</div>
							</div>
						</div>
						<div class="col-lg-9">
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade <?php if($str_partactive==0){echo "active show";} ?>" id="nav-acc" role="tabpanel" aria-labelledby="nav-acc-tab">
									<?php
									$str_atrib=""; $str_style="";
									if(rqstprm("user")!=""){$str_atrib="readonly"; $str_style="border:0px;";}
									?>
									<div class="acc-setting">
										<h3><?php echo get_label('lbl_profil'); ?></h3>
										<form action="" method="POST" name="frm_inscr" enctype="multipart/form-data" onsubmit="show_loading();" >
											<?php if($str_msg_err!=""){echo "<p class='p_msg_erreur' >$str_msg_err</p>";} ?>
											<div class="cp-field">
												<h5><?php echo get_label("lbl_nom"); ?></h5>
												<div class="cpp-fiel">
													<input type="text" name="txt_nom" placeholder="<?php echo get_label("lbl_nom"); ?>" value="<?php echo $user["nom"]; ?>" required <?php echo $str_atrib; ?> style="<?php echo $str_style; ?>" />
													<i class="la la-user"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5><?php echo get_label("lbl_prenom"); ?></h5>
												<div class="cpp-fiel">
													<input type="text" name="txt_prenom" placeholder="<?php echo get_label("lbl_prenom"); ?>" value="<?php echo $user["prenom"]; ?>" required <?php echo $str_atrib; ?> style="<?php echo $str_style; ?>" />
													<i class="la la-user"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5><?php echo get_label("lbl_pays"); ?></h5>
												<div class="cpp-fiel">
													<select name="txt_pays" onchange="get_option(this.value, '', 'ville');" required <?php echo $str_atrib; ?> style="<?php echo $str_style; ?>" >
														<option value='' ><?php echo get_label("lbl_pays"); ?></option>
														<?php
														$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMPAY FROM pays p ORDER BY `order`, NOMPAY";
														$result = bddfetch($req,$pdo);
														foreach($result as $line)
														{
															$str_sel="";if(($line["id"]==$user["pays"])){$str_sel="selected";}
															echo "<option value='".$line["id"]."' $str_sel >".$line["NOMPAY"]."</option>";
														}
														?>
													</select>
													<i class="la la-globe"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5><?php echo get_label("lbl_ville"); ?></h5>
												<div class="cpp-fiel">
													<select name="txt_ville" required <?php echo $str_atrib; ?> style="<?php echo $str_style; ?>" >
														<option value='' ><?php echo get_label("lbl_ville"); ?></option>
														<?php
														$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMVILLE FROM ville WHERE pays='".$user["pays"]."' ORDER BY `order`, NOMVILLE";
														$result = bddfetch($req,$pdo);
														foreach($result as $line)
														{
															$str_sel="";if($line["id"]==$user["ville"]){$str_sel="selected";}
															echo "<option value='".$line["id"]."' $str_sel >".$line["NOMVILLE"]."</option>";
														}
														?>
													</select>
													<i class="la la-map-marker"></i>
												</div>
											</div>
											<div class="cp-field" style='display:none;' >
												<h5><?php echo get_label('lbl_domaine'); ?></h5>
												<div class="cpp-fiel">
													<select name="txt_metier" onchange="get_option(this.value, '', 'specialite');" <?php echo $str_atrib; ?> style="<?php echo $str_style; ?>" >
														<option value='' ><?php echo get_label('lbl_domaine'); ?></option>
														<?php
														$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMPAY FROM metier p ORDER BY NOMPAY";
														$result = bddfetch($req,$pdo);
														foreach($result as $line)
														{
															$str_sel="";if($line["id"]==$user["metier"]){$str_sel="selected";}
															echo "<option value='".$line["id"]."' $str_sel >".$line["NOMPAY"]."</option>";
														}
														?>
													</select>
													<i class="la la-briefcase"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5><?php echo get_label('lbl_specialite'); ?></h5>
												<div class="cpp-fiel">
													<select name="txt_specialite" <?php echo $str_atrib; ?> style="<?php echo $str_style; ?>" >
														<option value='' ><?php echo get_label('lbl_specialite'); ?></option>
														<?php
														$req= "SELECT id, nom_".$_SESSION["lang"]." AS NOMLINE FROM metier_specialiste WHERE metier IS NULL OR metier='".$user["metier"]."' ORDER BY NOMLINE";
														$result = bddfetch($req,$pdo);
														foreach($result as $line)
														{
															$str_sel="";if($line["id"]==$user["specialite"]){$str_sel="selected";}
															echo "<option value='".$line["id"]."' $str_sel >".$line["NOMLINE"]."</option>";
														}
														?>
													</select>
													<i class="la la-tags"></i>
												</div>
											</div>
											<?php if(rqstprm("user")==""){ ?>
											<div class="cp-field">
												<h5><?php echo get_label("lbl_email"); ?></h5>
												<div class="cpp-fiel">
													<input type="email" name="txt_email" placeholder="<?php echo get_label("lbl_email"); ?>" value="<?php echo $user["login"]; ?>" required />
													<i class="la la-envelope"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5><?php echo get_label("lbl_password"); ?></h5>
												<div class="cpp-fiel">
													<input type="password" name="txt_password" placeholder="<?php echo get_label("lbl_password"); ?>" value="<?php echo $user["pass"]; ?>" required />
													<i class="la la-lock"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5><?php echo get_label("lbl_repeter_mot_passe"); ?></h5>
												<div class="cpp-fiel">
													<input type="password" name="txt_repeat_password" placeholder="<?php echo get_label("lbl_repeter_mot_passe"); ?>" value="<?php echo $user["pass"]; ?>" required />
													<i class="la la-lock"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5><?php echo get_label('lbl_updatpictrprofil'); ?></h5>
												<div class="cpp-fiel">
													<input type='file' name='txt_image' />
													<i class="la la-picture-o"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5><?php echo get_label('lbl_langue'); ?></h5>
												<div class="cpp-fiel">
													<select name="txt_langue" required >
														<option value='fr' <?php if($user["lang"]=="fr"){echo "selected";} ?> >Français</option>
														<option value='ar' <?php if($user["lang"]=="ar"){echo "selected";} ?> >العربية</option>
														<option value='en' <?php if($user["lang"]=="en"){echo "selected";} ?> >English</option>
													</select>
													<i class="la la-flag"></i>
												</div>
											</div>
											<div class="save-stngs pd3">
												<ul>
													<li><button type="submit"><?php echo get_label('lbl_savegard'); ?></button></li>
												</ul>
											</div><!--save-stngs end-->
											<?php } ?>
										</form>
									</div><!--acc-setting end-->
								</div>
							  	<div class="tab-pane fade <?php if($str_partactive==1){echo "active show";} ?>" id="nav-messages" role="tabpanel" aria-labelledby="nav-messages-tab">
							  		<div class="acc-setting">
							  			<h3>
											<?php echo get_label('lbl_mes_messages'); ?>
											<a href="<?php echo $strurlsite."mon-profil.php?s=newmsg"; ?>" class='dv_btn dv_btn_new_msg' ><i class='fa fa-envelope' ></i> <?php echo get_label('lbl_envoyermessage'); ?></a>
										</h3>
							  			<div class="notifications-list row">
											<?php
											$req = "SELECT DISTINCT m.msg_du AS IDLINE, u.nom, u.prenom, u.image AS IMGUSER, u.id AS USERID
													FROM message m
													LEFT JOIN user u ON u.id=m.msg_du
													WHERE m.msg_au=".injsql($_SESSION["userpk"],$pdo)."
													ORDER BY m.lu, m.date_ajout DESC";
											$dt_usrdu=bddfetch($req,$pdo);
											$req = "SELECT DISTINCT m.msg_au AS IDLINE, u.nom, u.prenom, u.image AS IMGUSER, u.id AS USERID
													FROM message m
													LEFT JOIN user u ON u.id=m.msg_au
													WHERE m.msg_du=".injsql($_SESSION["userpk"],$pdo)."
													ORDER BY m.lu, m.date_ajout DESC";
											$dt_usrau=bddfetch($req,$pdo);
											for($ma=0; $ma<count($dt_usrau); $ma++)
											{
												$isfinde=false;
												for($md=0; $md<count($dt_usrdu); $md++)
												{
													if($dt_usrdu[$md]["IDLINE"] == $dt_usrau[$ma]["IDLINE"]){$isfinde=true; break;}
												}
												if(!$isfinde){$dt_usrdu[]=$dt_usrau[$ma];}
											}
											$i=0; $str_profiles=""; $lst_msgprof="";
											foreach($dt_usrdu as $line)
											{
												$str_profiluser=$strurlsite."mon-profil.php?s=post&user=".$line['USERID'];
												$str_clasmsgpro=""; $str_styldtmsg="display:none;";
												if($i==0){$str_clasmsgpro="dv_selmsgprof"; $str_styldtmsg="";}
												$lst_msgprof.="<div id='dv_msgdetail_".$i."' style='padding:20px;background:#f5f5f5;min-height:100%;".$str_styldtmsg."' >";
												$req = "SELECT m.id, m.message, m.date_ajout, m.lu, m.msg_du, m.msg_au
														FROM message m
														WHERE (m.msg_du=".injsql($_SESSION["userpk"],$pdo)." AND m.msg_au=".injsql($line["USERID"],$pdo).")
															OR (m.msg_au=".injsql($_SESSION["userpk"],$pdo)." AND m.msg_du=".injsql($line["USERID"],$pdo).")
														ORDER BY m.date_ajout";
												$dt_result=bddfetch($req,$pdo);
												$c=0;
												$nbrnovue=0;
												foreach($dt_result as $line_m)
												{
													if($line_m["lu"]==0 && $line_m["msg_au"]==$_SESSION["userpk"])
													{
														$req="UPDATE message SET lu=1 WHERE id=".injsql($line_m["id"],$pdo);
														bddmaj($req,$pdo);
														$nbrnovue++;
													}
													$str_stylmsg="background:#ff7f27;float:left;";
													if($line_m["msg_du"]==$_SESSION["userpk"]){$str_stylmsg="background:#a349a4;float:right;";}
													$lst_msgprof.="<div style='color:#fff;max-width:80%;border-radius:3px;margin-bottom:10px;padding:10px;".$str_stylmsg."' >
																		<span style='font-size:8pt;' >".formatdate($line_m["date_ajout"], "d/m/Y H:i")."</span>
																		<br />
																		<b>".$line_m["message"]."</b>
																	</div>
																	<div class='clearfix' ></div>";
													$c++;
												}
												$str_txtrep=get_label('lbl_repondere');
												if($c==0){$lst_msgprof.="<div>".get_label("lbl_nomsg")."</div>";$str_txtrep=get_label('lbl_envoyermessage');}
												$lst_msgprof.="<div style='padding:20px;text-align:center;background:#eee;' >
																<a href='".$strurlsite."mon-profil.php?s=newmsg&user=".$line["USERID"]."' class='dv_btn dv_btn_new_msg' ><i class='fa fa-envelope' ></i> ".$str_txtrep."</a></div>";
												$lst_msgprof.="</div>";
												$str_infonbr="";
												if($nbrnovue>0)
												{
													if($nbrnovue<=9){$nbrnovue="0$nbrnovue";}
													$str_infonbr="<div class='dv_infonum' style='position:relative;top:0px;right:0px;' >$nbrnovue</div>";
												}
												$str_profiles.="<div id='dv_msgprofile_".$i."' class='notfication-details ".$str_clasmsgpro."' style='cursor:pointer;' onclick='select_lstmsg(".$i.");' >
																	<div class='usr-pic-profil' style='background-image:url(".img_userdef($line['IMGUSER']).");' ></div>
																	<div class='notification-info' style='position:relative;' >
																		<h3>".$line['prenom'].' '.$line['nom']."</h3>
																		<a href='".$str_profiluser."' class='dv_btn dv_btn_profil_msg' ><i class='fa fa-user' ></i> ".get_label('lbl_profil')."</a>
																		$str_infonbr
																	</div>
																</div>
																<div class='clearfix' ></div>";
												$i++;
											}
											if($i>0)
											{
												?>
												<div class='col-md-3' style="padding:0px;" ><?php echo $str_profiles; ?></div>
												<div class='col-md-9' style="padding:0px;" ><?php echo $lst_msgprof; ?></div>
												<div class='clearfix' ></div>
												<?php
											}
											else
											{
											?>
											<div class="notfication-details">
												<div style="text-align:center;padding:20px;" >
													<?php echo get_label("lbl_nomsg"); ?>
												</div>
											</div>
											<?php } ?>
							  			</div><!--notifications-list end-->
							  		</div><!--acc-setting end-->
							  	</div>
							  	<div class="tab-pane fade <?php if($str_partactive==2){echo "active show";} ?>" id="nav-deactivate" role="tabpanel" aria-labelledby="nav-deactivate-tab">
							  		<div class="acc-setting">
										<h3><?php echo get_label('lbl_desactivacount'); ?></h3>
										<form action="" method="POST" >
											<?php if($str_msg_err!=""){echo "<p class='p_msg_erreur' >$str_msg_err</p>";} ?>
											<?php if(rqstprm("user")==""){ ?>
												<div class="cp-field">
													<h5><?php echo get_label('lbl_password'); ?></h5>
													<div class="cpp-fiel">
														<input type="password" name="txt_pass_out" placeholder="Password" required />
														<i class="fa fa-lock"></i>
													</div>
												</div>
											<?php } ?>
											<div class="cp-field">
												<h5><?php echo get_label('lbl_aprfexplicvoplai'); ?></h5>
												<textarea name="txt_desc_out" ></textarea>
												<input type='hidden' name="txt_isdesactive" value="1" />
											</div>
											<div class="save-stngs pd3">
												<ul>
													<li><button type="submit"><?php echo get_label('lbl_desactivacount'); ?></button></li>
												</ul>
											</div><!--save-stngs end-->
										</form>
									</div><!--acc-setting end-->
							  	</div>
								<div class="tab-pane fade <?php if($str_partactive==3){echo "active show";} ?>" id="nav-newmsg" role="tabpanel" aria-labelledby="nav-newmsg-tab">
							  		<div class="acc-setting">
										<h3><?php echo get_label('lbl_envoyermessage'); ?></h3>
										<form action="" method="POST" >
											<?php if($str_msg_err!=""){echo "<p class='p_msg_erreur' >$str_msg_err</p>";} ?>
											<div class="cp-field" style="<?php if(rqstprm("user")!=""){echo "display:none;";} ?>" >
												<h5><?php echo get_label("lbl_a"); ?></h5>
												<div class="cpp-fiel">
													<input type="text" id="txtajax_userid" onkeyup="search_ajax(this.value, 'userid', '');" value="<?php if(rqstprm("user")!=""){echo $user["nom"];} ?>" required <?php echo $str_atrib; ?> style="<?php echo $str_style; ?>" autocomplete="off" />
													<i class="la la-user"></i>
													<input type='hidden' id="idajax_userid" name="idajax_userid" value="<?php if(rqstprm("user")!=""){echo $user["id"];} ?>" />
													<input type='hidden' id="infajax_userid" name="infajax_userid" />
													<div id="dv_cntnt_userid" class="dv_autocmplt hide-out"></div>
												</div>
											</div>
											<div class="cp-field">
												<h5><?php echo get_label('lbl_message'); ?></h5>
												<textarea name="txt_message" ></textarea>
											</div>
											<div class="save-stngs pd3">
												<ul>
													<li><button type="submit"><?php echo get_label('lbl_envoyermessage'); ?></button></li>
												</ul>
											</div><!--save-stngs end-->
										</form>
									</div><!--acc-setting end-->
							  	</div>
								<div class="tab-pane fade <?php if($str_partactive==5){echo "active show";} ?>" id="nav-mespst" role="tabpanel" aria-labelledby="nav-mespst-tab">
							  		<div class="acc-setting">
										<h3><?php if(rqstprm("user")!=""){echo get_label('lbl_les_posts');}else{echo get_label('lbl_maPage');} ?></h3>
										<?php get_postnew(6,$pdo); ?>
										<?php get_loadpost(6,$pdo); ?>
									</div><!--acc-setting end-->
							  	</div>
							</div>
						</div>
					</div>
				</div><!--account-tabs-setting end-->
			</div>
		</section>
		<?php 
		}
		if(rqstprm("e")=="info" && !$isreload){echo alert(get_label('lbl_msgerrnoselectprof'), "", "", 1);} ?>
		<!--<script>
			setInterval(function(){
				$.post('/ajax/post.php?operation=trophy', function(response){
					console.log(response);
					if(response==1){
            	     location.reload();
					}
                });
			}, 10000);
		</script>-->
<?php require("footer.php"); ?>