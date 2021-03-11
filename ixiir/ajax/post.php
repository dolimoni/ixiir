<?php
	require_once('../global.php');
	if(rqstprm("operation")=="getpost" && rqstprm("page")!="" && rqstprm("pour")!="")
	{
		$nbr=get_htmlpost(intval(rqstprm("page")), intval(rqstprm("pour")),$pdo);
	}
	else if(rqstprm("operation")=="trophy")
	{
		updatePosition($pdo);
	}
	else
	{
		if(rqstprm("txt_comentaire")!="" && rqstprm("txt_idpost")!="")
		{
			$req = "INSERT INTO posts_comment(detail, user_id, post)
					VALUES(".injsql(htmlspecialchars(rqstprm("txt_comentaire")),$pdo).", ".injsql(htmlspecialchars($_SESSION["userpk"]),$pdo).", ".injsql(htmlspecialchars(rqstprm("txt_idpost")),$pdo).");";
			$strid=bddadgetid($req,$pdo);
			?>
				<li id="li_cmentaire_<?php echo rqstprm("txt_idpost"); ?>_<?php echo $strid; ?>" >
					<div class="comment-list">
						<div class="bg-img">
							<div class="usr-pic-profil" style="background-image:url(<?php echo img_userdef($_SESSION["user_image"]); ?>);" ></div>
						</div>
						<div class="comment">
							<h3><?php echo htmlspecialchars($_SESSION["prenom"])." ".htmlspecialchars($_SESSION["nom"]); ?></h3>
							<span><img src="<?php echo $strurlsite; ?>images/clock.png" alt=""> <?php echo date("d/m/Y H:i"); ?></span>
							<p><?php echo htmlspecialchars(rqstprm("txt_comentaire")) ?></p>
							<b class='btn_delcmnt' onclick="deletecmntr('<?php echo trim(rqstprm("txt_idpost")); ?>', '<?php echo $strid; ?>')" >Supprimer</b>
						</div>
					</div>
				</li>
			<?php
			updatePosition($pdo);
		}
		elseif(rqstprm("txt_idpostdelete")!="" && rqstprm("opeartion")=="0")
		{
			$str_whre="";
			if($_SESSION["user_type"]!=0){$str_whre.=" AND par=".injsql($_SESSION["userpk"],$pdo);}
			$req="SELECT image FROM posts WHERE id=".injsql(rqstprm("txt_idpostdelete"),$pdo)." $str_whre";
			$dt_rsult=bddfetch($req,$pdo);
			foreach($dt_rsult as $line)
			{
				@unlink($_SESSION["DIRNAME"]."/".$line["image"]);
			}
			$req = "DELETE FROM posts WHERE id=".injsql(rqstprm("txt_idpostdelete"),$pdo)." $str_whre";
			bddmaj($req,$pdo);
			updatePosition($pdo);
		}
		elseif(rqstprm("txt_idpostdelete")!="" && rqstprm("opeartion")=="1")
		{
			$req = "INSERT INTO posts_masquer(user_id, post) VALUES(".injsql(htmlspecialchars($_SESSION["userpk"]),$pdo).", ".injsql(htmlspecialchars(rqstprm("txt_idpostdelete")),$pdo).");";
			bddmaj($req,$pdo);
			updatePosition($pdo);
		}
		elseif(rqstprm("txt_idcomntdelete")!="")
		{
			$req = "DELETE FROM posts_comment WHERE id=".injsql(rqstprm("txt_idcomntdelete"),$pdo).";";/*AND user_id=".injsql($_SESSION["userpk"])."*/
			bddmaj($req,$pdo);
			updatePosition($pdo);
		}
		elseif(rqstprm("txt_idposjaime")!="" && rqstprm("txt_jaimeornot")!="")
		{
			$req = "INSERT INTO posts_jaime(user_id, post) VALUES(".injsql(htmlspecialchars($_SESSION["userpk"]),$pdo).", ".injsql(htmlspecialchars(rqstprm("txt_idposjaime")),$pdo).");";
			if(intval(rqstprm("txt_jaimeornot"))>0){$req = "DELETE FROM posts_jaime WHERE user_id=".injsql($_SESSION["userpk"],$pdo)." AND post=".injsql(rqstprm("txt_idposjaime"),$pdo).";";}
			bddmaj($req,$pdo);

			
			return updatePosition($pdo);
		}
		elseif(rqstprm("user_vue")!="" && rqstprm("user_id")!="" && (rqstprm("oper")=="delflw" || rqstprm("oper")=="flw"))
		{
			if(rqstprm("oper")=="delflw")
			{
				$req = "UPDATE user_abonne SET abonne_del=1 WHERE user_vue=".injsql(rqstprm("user_vue"),$pdo)." AND user_id=".injsql(rqstprm("user_id"),$pdo).";";
				bddmaj($req,$pdo);
			}
			else
			{
				$nbr_abon=get_btn_suivi(rqstprm("user_id"), $pdo, rqstprm("user_vue"), true);
				if($nbr_abon>0)
				{
					$req = "UPDATE user_abonne SET abonne_del=0 WHERE user_vue=".injsql(rqstprm("user_vue"),$pdo)." AND user_id=".injsql(rqstprm("user_id"),$pdo).";";
					bddmaj($req,$pdo);
				}
				else
				{
					$req = "INSERT INTO user_abonne(user_vue, user_id, abonne_del, add_auto) VALUES(".injsql(htmlspecialchars(rqstprm("user_vue")),$pdo).", ".injsql(htmlspecialchars(rqstprm("user_id")),$pdo).", 0, 0);";
					bddmaj($req,$pdo);
				}
			}
			updatePosition($pdo);
		}
		elseif(rqstprm("txt_idposvue")!="")
		{
			$req = "INSERT INTO posts_vue(user_id, post) VALUES(".injsql(htmlspecialchars($_SESSION["userpk"]), $pdo).", ".injsql(htmlspecialchars(rqstprm("txt_idposvue")),$pdo).");";
            bddmaj($req, $pdo);
			updatePosition($pdo);
		}
	}
?>