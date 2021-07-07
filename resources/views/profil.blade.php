@extends('header-meta2')
@section('body')
<div class="wrapper">
       @include('header-menu')
		<?php
		/*$isreload=false; $str_msg_err="";

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
		{*/
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

                            				<div class="usr-pic" style="background-image:url({{asset(!empty($user['image'])?$user['image']:'/images/deaultuser.jpg')}});" ></div>

                            			</div><!--username-dt end-->

                            			<div class="user-specs">

                            				<h3 title="{{$user->prenom}} {{$user->nom}}"> {{\Illuminate\Support\Str::limit($user->prenom.' '. $user->nom , $limit = 250, $end = '..')}}</h3>

                            				<span>
                                              <hr>
                                              {{config('lang.lbl_nbrvisit_page')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ $user->userVue()->count() }}</b>
                                              <br>{{config('lang.lbl_abonne_fidele')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ App\Models\User::countAbonnes($user->id) }}</b>
                                              <br>{{config('lang.lbl_les_posts')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ App\Models\User::posts($user->id)->count() }}</b>
                                              <br>{{config('lang.lbl_nbrvueposts')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ App\Models\User::posts($user->id)->sum('postsVue')}}</b>
                                              <hr style="margin-top: 5px;margin-bottom: 5px;">
 											  {{config('lang.lbl_best_word')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ $user['best_word_wins']}}</b>
                                              <br>{{config('lang.lbl_writer_of_month')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ $user['best_author_wins']}}</b>
											  <hr style="margin-top: 5px;margin-bottom: 5px;">
                                              {{config('lang.lbl_ratepagecity')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{$user['cityRanking']}}</b>
											  <br>{{config('lang.lbl_ratepagepays')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{$user['countryRanking']}}</b>
											  <br>{{config('lang.lbl_ratepageworld')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{$user['wordRanking']}}</b>
                                              <br>{{config('lang.lbl_income')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ App\Models\Post::sumTrophy($user) + $user['income']}} $</b>
                            				</span>

                            			</div>

                            		</div><!--user-profile end-->

                            		<ul class="user-fw-status">

                            			<li>

                            				<a href="{{route('getProfil',['user_id'=>$user->id])}}" title="">{{config('lang.lbl_mon_profil')[empty(session('lang'))?0:session('lang')]}}</a>

                            			</li>

                            		</ul>

                            	</div>

                            </div>
							<div class="acc-leftbar full-width">
								<div class="nav nav-tabs" id="nav-tab" role="tablist">
									<a class="nav-item nav-link active" id="nav-mespst-tab" data-toggle="tab" href="#nav-mespst" role="tab" aria-controls="nav-mespst" aria-selected="true"><i class="la la-file"></i>
                                    @if(Auth::user()->id!=$user['id'])
                                    {{config('lang.lbl_les_posts')[empty(session('lang'))?0:session('lang')]}}
                                    @else
                                    {{config('lang.lbl_maPage')[empty(session('lang'))?0:session('lang')]}}
                                    @endif
                                    </a>
									<a class="nav-item nav-link" id="nav-acc-tab" data-toggle="tab" href="#nav-acc" role="tab" aria-controls="nav-acc" aria-selected="true"><i class="la la-cogs"></i>{{config('lang.lbl_profil')[empty(session('lang'))?0:session('lang')]}}</a>
									@if(Auth::user()->id!=$user['id'])
									<a class="nav-item nav-link" id="nav-newmsg-tab" data-toggle="tab" href="#nav-newmsg" role="tab" aria-controls="nav-newmsg" aria-selected="true"><i class="la la-envelope"></i>{{config('lang.lbl_envoyermessage')[empty(session('lang'))?0:session('lang')]}}</a>
									@else
								    <a class="nav-item nav-link nav-messages-action" id="nav-messages-tab" data-toggle="tab" href="#nav-messages" role="tab" aria-controls="nav-messages" aria-selected="true"><i class="fa fa-envelope"></i>{{config('lang.lbl_mes_messages')[empty(session('lang'))?0:session('lang')]}}</a>
									@endif
									@if(Auth::user()->user_type==0)
									<a class="nav-item nav-link" id="nav-deactivate-tab" data-toggle="tab" href="#nav-deactivate" role="tab" aria-controls="nav-deactivate" aria-selected="false"><i class="fa fa-random"></i>
    									@if(Auth::user()->id!=$user['id'])
    									{{config('lang.lbl_desactivacount')[empty(session('lang'))?0:session('lang')]}}
    									@else
    									{{config('lang.lbl_desactivmonacount')[empty(session('lang'))?0:session('lang')]}}
    									@endif
									</a>
								    @endif
								</div>
							</div>
						</div>
						<div class="col-lg-9" id="lef-side">
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade" id="nav-acc" role="tabpanel" aria-labelledby="nav-acc-tab">
									<?php
									/*$str_atrib=""; $str_style="";
									if(rqstprm("user")!=""){$str_atrib="readonly"; $str_style="border:0px;";}*/
									?>
									<div class="acc-setting">
										<h3>{{config('lang.lbl_profil')[empty(session('lang'))?0:session('lang')]}}</h3>
										<form name="frm_inscr" id="updateProfilForm" enctype="multipart/form-data">
											<?php //if($str_msg_err!=""){echo "<p class='p_msg_erreur' >$str_msg_err</p>";} ?>
											@csrf
											<input type="hidden" name="user_id" id="userProfil" value="{{$user['id']}}" required />
											<div class="cp-field">
												<h5>{{config('lang.lbl_nom')[empty(session('lang'))?0:session('lang')]}}</h5>
												<div class="cpp-fiel">
													<input type="text" name="nom" id="nomProfil" placeholder="{{config('lang.lbl_nom')[empty(session('lang'))?0:session('lang')]}}" value="{{$user['nom']}}" required />
													<i class="la la-user"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5>{{config('lang.lbl_prenom')[empty(session('lang'))?0:session('lang')]}}</h5>
												<div class="cpp-fiel">
													<input type="text" name="prenom" id="prenomProfil" placeholder="{{config('lang.lbl_prenom')[empty(session('lang'))?0:session('lang')]}}" value="{{$user['prenom']}}" required  />
													<i class="la la-user"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5>{{config('lang.lbl_pays')[empty(session('lang'))?0:session('lang')]}}</h5>
												<div class="cpp-fiel">
													<select name="pays" onchange="getVilles('-profil');" id="country-profil" required>
                                                    <option value='' >{{config('lang.lbl_pays')[empty(session('lang'))?0:session('lang')]}}</option>
                                                    @foreach($pays as $p)
                                                    <option value="{{$p->id}}" {{$p->id==$user['country']['id']?'selected':''}}>{{$p->nom_en}}</option>
                                                    @endforeach
													</select>
													<i class="la la-globe"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5>{{config('lang.lbl_ville')[empty(session('lang'))?0:session('lang')]}}</h5>
												<div class="cpp-fiel">
													<select name="ville" id="city-profil" required>
                                                    <option value='' >{{config('lang.lbl_ville')[empty(session('lang'))?0:session('lang')]}}</option>
                                                    @foreach($villes as $ville)
                                                        <option value="{{$ville->id}}" {{$ville->id==$user['city']['id']?'selected':''}}>{{$ville->nom_en}}</option>
                                                    @endforeach
													</select>
													<i class="la la-map-marker"></i>
												</div>
											</div>
											<div class="cp-field specialite">
												<h5>{{config('lang.lbl_specialite')[empty(session('lang'))?0:session('lang')]}}</h5>
												<div class="cpp-fiel">
													<select name="specialite" id="specialiteProfil" required>
														<option value='' >{{config('lang.lbl_specialite')[empty(session('lang'))?0:session('lang')]}}</option>
															@foreach($specialites as $specialite)
																<option value="{{$specialite->id}}" {{$specialite->id==$user['metierSpecialite']['id']?'selected':''}}>{{$specialite->nom_en}}</option>
															@endforeach
													</select>
													<i class="la la-tags"></i>
												</div>
											</div>
											@if(Auth::user()->id==$user['id'])
											<div class="cp-field">
												<h5>{{config('lang.lbl_email')[empty(session('lang'))?0:session('lang')]}}</h5>
												<div class="cpp-fiel">
													<input type="email" id="loginProfil" name="login" placeholder="{{config('lang.lbl_email')[empty(session('lang'))?0:session('lang')]}}" value="{{$user['login']}}" required />
													<i class="la la-envelope"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5>{{config('lang.lbl_password')[empty(session('lang'))?0:session('lang')]}}</h5>
												<div class="cpp-fiel">
													<input type="password" id="passProfil" name="password" placeholder="{{config('lang.lbl_password')[empty(session('lang'))?0:session('lang')]}}" required />
													<i class="la la-lock"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5>{{config('lang.lbl_repeter_mot_passe')[empty(session('lang'))?0:session('lang')]}}</h5>
												<div class="cpp-fiel">
													<input type="password" id="passRepeatProfil" name="txt_repeat_password" placeholder="{{config('lang.lbl_repeter_mot_passe')[empty(session('lang'))?0:session('lang')]}}" required />
													<i class="la la-lock"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5>{{config('lang.lbl_updatpictrprofil')[empty(session('lang'))?0:session('lang')]}}</h5>
												<div class="cpp-fiel">
													<input type='file' name='image'  id="imageUserFile"/>
													<i class="la la-picture-o"></i>
												</div>
											</div>
											<div class="cp-field">
												<h5>{{config('lang.lbl_langue')[empty(session('lang'))?0:session('lang')]}}</h5>
												<div class="cpp-fiel">
													<select name="lang" required >
														<option value='fr' {{$user['lang']=='fr'?'selected':''}}>Français</option>
														<option value='ar' {{$user['lang']=='ar'?'selected':''}}>العربية</option>
														<option value='en' {{$user['lang']=='en'?'selected':''}}>English</option>
													</select>
													<i class="la la-flag"></i>
												</div>
											</div>
											<div class="save-stngs pd3">
												<ul>
													<li><button type="submit">{{config('lang.lbl_savegard')[empty(session('lang'))?0:session('lang')]}}</button></li>
												</ul>
											</div><!--save-stngs end-->
											@endif
										</form>
									</div><!--acc-setting end-->
								</div>
							  	<div class="tab-pane fade" id="nav-messages" role="tabpanel" aria-labelledby="nav-messages-tab">
							  		<div class="acc-setting">
							  			<h3>
											{{config('lang.lbl_mes_messages')[empty(session('lang'))?0:session('lang')]}}
											<a href="" class='dv_btn dv_btn_new_msg' ><i class='fa fa-envelope' ></i> {{config('lang.lbl_envoyermessage')[empty(session('lang'))?0:session('lang')]}}</a>
										</h3>
							  			<div class="notifications-list row">
							  			    @if(count($messages)==0)
							  			    <div class="notfication-details">
												<div style="text-align:center;padding:20px;" >
													{{config('lang.lbl_nomsg')[empty(session('lang'))?0:session('lang')]}}
												</div>
											</div>
							  			    @endif
							  			    @foreach($messagesAu as $message)
							  			      <div id='dv_msgdetail_0' style='padding:20px;background:#f5f5f5;min-height:100%;display:none;' >
							  			          <div style='color:#fff;max-width:80%;border-radius:3px;margin-bottom:10px;padding:10px;background:#ff7f27;float:left;' >

    													<span style='font-size:8pt;' >{{\Carbon\Carbon::createFromTimeStamp(strtotime($message['date_ajout']))->diffForHumans()}}</span>
    													<br />
    													<b>{{$message["message"]}}</b>
    											  </div>
    										      <div class='clearfix' ></div>
							  			    @endforeach
											<?php
											/*$req = "SELECT DISTINCT m.msg_du AS IDLINE, u.nom, u.prenom, u.image AS IMGUSER, u.id AS USERID
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
											{*/
											?>
											<!--<div class="notfication-details">
												<div style="text-align:center;padding:20px;" >
													<?php //echo get_label("lbl_nomsg"); ?>
												</div>
											</div>-->
											<?php //} ?>

										  @foreach($messages as $key => $message)
													  <a href="{{route('getProfil',['user_id'=>$message->user->id])}}?element=newmsg">
										  <div class='col-md-3' style="padding:0px;" >
												  <div id='dv_msgprofile_aaa'
													   class='notfication-details' style='cursor:pointer;' onclick='' >
													  <div class='usr-pic-profil' style="float:none;margin:auto;background-image: url({{asset(!empty($message->user->image)?$message->user->image:'/images/deaultuser.jpg')}});" ></div>
													  <div class='notification-info' style='position:relative;float: none;text-align: center;' >
														  <h3>{{$message->user->prenom }} {{$message->user->nom }}</h3>
														  <a href="{{route('getProfil',['user_id'=>$message->user->id])}}?element=newmsg" class='dv_btn dv_btn_profil_msg' ><i class='fa fa-envelope' ></i> Reply</a>

													  </div>
												  </div>

											  <div class='clearfix' ></div>
										  </div>
													  </a>
											<div class='col-md-9' id="messages-box" style="padding:0px;" >

											      <div  style="max-width:80%;border-radius:3px;margin-bottom:10px;padding:10px;@if(Auth::user()->id==$message['msg_du'])@endif" >
													<span style="font-size:8pt;" >{{\Carbon\Carbon::createFromTimeStamp(strtotime($message['date_ajout']))->diffForHumans()}}</span>
													<br />
													<div dir="rtl">{{$message["message"]}}</div>
												  </div>
											</div>
										  @endforeach
							  			</div><!--notifications-list end-->
							  		</div><!--acc-setting end-->
							  	</div>
							  	<div class="tab-pane fade" id="nav-deactivate" role="tabpanel" aria-labelledby="nav-deactivate-tab">
							  		<div class="acc-setting">
										<h3>Desactivate</h3>
										<form action="{{route('deactivateUser')}}" method="POST" >
										    @csrf
											<?php //if($str_msg_err!=""){echo "<p class='p_msg_erreur' >$str_msg_err</p>";} ?>
											@if(Auth::user()->id==$user['id'])
												<div class="cp-field">
													<h5>Password</h5>
													<div class="cpp-fiel">
														<input type="password" name="txt_pass_out" placeholder="******************" required />
														<i class="fa fa-lock"></i>
													</div>
												</div>
											@endif
											<div class="cp-field">
												<h5><?php //echo get_label('lbl_aprfexplicvoplai'); ?></h5>
												<textarea name="txt_desc_out" ></textarea>
												<input type='hidden' name="txt_isdesactive" value="1" />
												<input type='hidden' name="id" value="{{$user['id']}}" />
											</div>
											<div class="save-stngs pd3">
												<ul>
													<li><button type="submit">Desactivate</button></li>
												</ul>
											</div><!--save-stngs end-->
										</form>
									</div><!--acc-setting end-->
							  	</div>
								<div class="tab-pane fade" id="nav-newmsg" role="tabpanel" aria-labelledby="nav-newmsg-tab">
							  		<div class="acc-setting">
										<h3>Envoyer message</h3>
										<form action="{{route('sendMessage')}}" method="POST" >
										    @csrf
											<!--<div class="cp-field">
												<h5>A</h5>
												<div class="cpp-fiel">
													<input type="text" name="user_message" id="txtajax_userid" onkeyup="search_ajax(this.value, 'userid', '');" required autocomplete="off" />
													<i class="la la-user"></i>
													<input type='hidden' id="idajax_userid" name="idajax_userid" />
													<input type='hidden' id="infajax_userid" name="infajax_userid" />
													<div id="dv_cntnt_userid" class="dv_autocmplt hide-out"></div>
												</div>
											</div>-->
											<input type='hidden' id="user_message" name="user_message" value="{{$user->id}}" required/>
											<div class="cp-field">
												<h5>Message</h5>
												<textarea name="txt_message" required></textarea>
											</div>
											<div class="save-stngs pd3">
												<ul>
													<li><button type="submit">{{config('lang.lbl_envoyermessage')[empty(session('lang'))?0:session('lang')]}}</button></li>
												</ul>
											</div><!--save-stngs end-->
										</form>
									</div><!--acc-setting end-->
							  	</div>
								<div class="tab-pane fade active show" id="nav-mespst" role="tabpanel" aria-labelledby="nav-mespst-tab">
							  		<div class="acc-setting">
										<h3>
										    @if(Auth::user()->id!=$user['id'])
        									{{config('lang.lbl_les_posts')[empty(session('lang'))?0:session('lang')]}}
        									@else
        									{{config('lang.lbl_mes_posts')[empty(session('lang'))?0:session('lang')]}}
        									@endif
                                        </h3>
										<div class='col-md-6 no-padding-colmd posts-div no-padding-left'>
                                                @foreach($posts_even as $key=>$post)
                                                    @include('templatePost')
                                                @endforeach
                                        </div>
                                        <div class='col-md-6 no-padding-colmd posts-div no-padding-right'>
                                                @foreach($posts_odd as $key=>$post)
                                                    @include('templatePost')
                                                @endforeach
                                        </div>
									</div><!--acc-setting end-->
							  	</div>
							</div>
						</div>
					</div>
				</div><!--account-tabs-setting end-->
			</div>
		</section>
    <script>
        $( document ).ready(function() {

			var getUrlParameter = function getUrlParameter(sParam) {
				var sPageURL = window.location.search.substring(1),
						sURLVariables = sPageURL.split('&'),
						sParameterName,
						i;

				for (i = 0; i < sURLVariables.length; i++) {
					sParameterName = sURLVariables[i].split('=');

					if (sParameterName[0] === sParam) {
						return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
					}
				}
				return false;
			};

			var element = getUrlParameter('element');

			if(element==="messages"){
				$('#nav-messages-tab').trigger('click');
			}else if(element==="edit"){
				$('#nav-acc-tab').trigger('click');
			}else if(element==="newmsg"){
				$('#nav-newmsg-tab').trigger('click');
			}

            $('.nav-messages-action').on('click',function(){
                document.getElementById("lef-side").scrollIntoView();
				var data = {
					"_token": "{{ csrf_token() }}",
				};
				$.ajax({
					url : "{{route('readMessages')}}",
					data:data,
					type : 'POST',
					success : function(code_html, statut){ // success est toujours en place, bien sûr !
					},
					error : function(resultat, statut, erreur){
					}

				});
            });
        });
    </script>
	@include('includes.modalUpdatePost');
@endsection
