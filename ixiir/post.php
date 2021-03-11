<?php $str_page="conditions"; require("header-meta.php"); ?>
	<div class="wrapper">
		<?php if(!is_user_login()){require("header-menu-logout.php");}else{require("header-menu.php");} ?>
		<section class="companies-info">
			<div class="container">
				<div class="posts-section">
					<?php 
						if(rqstprm("pid")!=""){get_post_pop(rqstprm("pid"),$pdo);}
						else{redirect($strurlsite);}
					?>
				</div>
			</div>
		</section><!--companies-info end-->


	</div><!--theme-layout end-->

<?php require("footer.php"); ?>