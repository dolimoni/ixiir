<?php
	
?>
<header>
	<div class="container">
		<div class="header-data">
			<div class="logo">
				<a href="<?php echo $strurlsite; ?>" title=""><img src="<?php echo $strurlsite; ?>images/logo.png" style="height:32px;"></a>
			</div><!--logo end-->
			<div class="search-bar">
				<form action="" method="post" >
					<input type="text" name="txt_search" placeholder="<?php echo get_label("lbl_rechercher"); ?>">
					<button type="submit"><i class="la la-search"></i></button>
				</form>
			</div><!--search-bar end-->
			<!--menu-btn end-->
			<div class="user-account">
				<div class="user-info">
					<a href="#" title="" class="a_imgprofil" style="background-image:url(<?php echo img_userdef($_SESSION["user_image"]); ?>);" ></a>
					<i class="fa fa-caret-down" style="right: 5px;"></i>
					<?php
					$req = "SELECT count(*) AS NBRLIN FROM message m WHERE m.msg_au=".injsql($_SESSION["userpk"],$pdo)." AND m.lu=0";
					$dt_nbrnolu=bddfetch($req,$pdo);
					$nbrnovue=$dt_nbrnolu[0]["NBRLIN"];
					if($nbrnovue>0)
					{
						if($nbrnovue<=9){$nbrnovue="0$nbrnovue";}
						echo "<div class='dv_infonum' style='top:5px;right:5px;' >$nbrnovue</div>";
					}
					?>
					<!--<i class="la la-sort-down"></i>-->
				</div>
				<div class="user-account-settingss">
					<ul class="us-links">
						<li><a href="<?php echo $strurlsite; ?>?f=me" title=""><?php echo get_label("lbl_maPage"); ?></a></li>
						<li>
							<a href="<?php echo get_url("profil"); ?>?s=message" title="">
								<?php
									echo get_label("lbl_mes_messages");
									if($nbrnovue>0)
									{
										echo "<div class='dv_infonum' style='position:relative;top:0px;right:0px;' >$nbrnovue</div>";
									}
								?>
							</a></li>
						<li><a href="<?php echo get_url("profil"); ?>" title=""><?php echo get_label("lbl_modifier_mon_profil"); ?></a></li>
					</ul>
					<h3 class="tc"><a href="<?php echo $strurlsite; ?>sign-in.php?acttion=logout" title=""><?php echo get_label("lbl_logout"); ?></a></h3>
				</div><!--user-account-settingss end-->
			</div>
			<nav class='nav_menu' >
				<ul>
					<!--
					<li class='<?php if($str_page=="accueil" && $str_postpour==5){echo "li_active";} ?>' >
						<a href="<?php echo $strurlsite; ?>?f=f" >
							<span><i class='la la-group' ></i></span>
							<?php
							if($str_pour_famille!="")
							{
								if(strlen($str_pour_famille)>13)
								{$str_pour_famille="<span title=\"".Replace($str_pour_famille, '"', "'")."\" >".substr($str_pour_famille, 0, 13)."...</span>";}
								if($_SESSION["lang"]=="ar"){echo "<b>".get_label("lbl_famille")."</b> <b>".$str_pour_famille."</b>";}
								elseif($_SESSION["lang"]=="en"){echo $str_pour_famille." ".get_label("lbl_famille");}
								else{echo get_label("lbl_famille")." ".$str_pour_famille;}
							}
							else{echo get_label("lbl_ma_famille");}
							?>
						</a>
					</li>-->
					<li class='<?php if($str_page=="accueil" && $str_postpour==4){echo "li_active";} ?>' >
						<a href="<?php echo $strurlsite; ?>?f=d" >
							<span><i class='la la-tags' ></i></span>
							<?php
							if($str_pour_special!="")
							{
								if(strlen($str_pour_special)>13)
								{$str_pour_special="<span title=\"".Replace($str_pour_special, '"', "'")."\" >".substr($str_pour_special, 0, 13)."...</span>";}
								echo $str_pour_special;
							}
							else{echo get_label("lbl_mon_domaine");}
							?>
						</a>
					</li>
					<!--<li class='<?php if($str_page=="accueil" && $str_postpour==3){echo "li_active";} ?>' >
						<a href="<?php echo $strurlsite; ?>?f=m" >
							<span><i class='la la-briefcase' ></i></span>
							<?php
							if($str_pour_metier!="")
							{
								if(strlen($str_pour_metier)>13)
								{$str_pour_metier="<span title=\"".Replace($str_pour_metier, '"', "'")."\" >".substr($str_pour_metier, 0, 13)."...</span>";}
								echo $str_pour_metier;
							}
							else{echo get_label("lbl_mon_metier");}
							?>
						</a>
					</li>
					-->
					<li class='<?php if($str_page=="accueil" && $str_postpour==2){echo "li_active";} ?>' >
						<a href="<?php echo $strurlsite; ?>?f=v" >
							<span><i class='la la-map-marker' ></i></span>
							<?php
							if($str_pour_ville!="")
							{
								if(strlen($str_pour_ville)>13)
								{$str_pour_ville="<span title=\"".Replace($str_pour_ville, '"', "'")."\" >".substr($str_pour_ville, 0, 13)."...</span>";}
								echo $str_pour_ville;
							}
							else{echo get_label("lbl_ma_ville");}
							?>
						</a>
					</li>
					<li class='<?php if($str_page=="accueil" && $str_postpour==1){echo "li_active";} ?>' >
						<a href="<?php echo $strurlsite; ?>?f=p" >
							<span><i class='la la-flag' ></i></span>
							<?php
							if($str_pour_pay!="")
							{
								if(strlen($str_pour_pay)>13)
								{$str_pour_pay="<span title=\"".Replace($str_pour_pay, '"', "'")."\" >".substr($str_pour_pay, 0, 13)."...</span>";}
								echo $str_pour_pay;
							}
							else{echo get_label("lbl_mon_pays");}
							?>
						</a>
					</li>
					<li class='<?php if($str_page=="accueil" && $str_postpour==0){echo "li_active";} ?>' >
						<a href="<?php echo $strurlsite; ?>?f=i" >
							<span><i class='la la-globe' ></i></span> <?php echo get_label("lbl_monde"); ?>
						</a>
					</li>
					<!--
					<li class='<?php if($str_page=="message"){echo "li_active";} ?>' >
						<a href="<?php echo $strurlsite; ?>#" title="" class="not-box-open">
							<span><i class='la la-envelope' ></i></span>
							Messages
						</a>
						<div class="notification-box msg">
							<div class="nott-list">
								<div class="notfication-details">
									<div class="noty-user-img">
										<img src="<?php echo $strurlsite; ?>images/resources/ny-img1.png" alt="">
									</div>
									<div class="notification-info">
										<h3><a href="<?php echo $strurlsite; ?>messages.php" title="">Brahime khalidi</a> </h3>
										<p>Salam cv?</p>
										<span>Il y a 2 min</span>
									</div>
								</div>
								<div class="notfication-details">
									<div class="noty-user-img">
										<img src="<?php echo $strurlsite; ?>images/resources/ny-img2.png" alt="">
									</div>
									<div class="notification-info">
										<h3><a href="<?php echo $strurlsite; ?>messages.php" title="">Hassan oufalla</a></h3>
										<p>Lorem ipsum dolor sit amet.</p>
										<span>Il y a 2 min</span>
									</div>
								</div>
								<div class="notfication-details">
									<div class="noty-user-img">
										<img src="<?php echo $strurlsite; ?>images/resources/ny-img3.png" alt="">
									</div>
									<div class="notification-info">
										<h3><a href="<?php echo $strurlsite; ?>messages.php" title="">Ahlam nouri</a></h3>
										<p>Anjhj jhbcfty ytfghfghf fcvbcvbc balal blala</p>
										<span>Il y a 5 min</span>
									</div>
								</div>
								<div class="view-all-nots">
									<a href="<?php echo $strurlsite; ?>messages.php" title="">Voir tous les messages</a>
								</div>
							</div>
						</div>
					</li>
					-->
				</ul>
			</nav><!--nav end-->
			<div class="menu-btn">
				<a href="<?php echo $strurlsite; ?>#" title=""><i class="fa fa-bars"></i></a>
			</div>
		</div><!--header-data end-->
	</div>
</header><!--header end-->