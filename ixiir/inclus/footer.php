		<footer>
			<div class="footy-sec mn no-margin">
				<div class="container">
					<?php get_lienfooter(); ?>
					<p><?php get_copieright(); ?></p>
				</div>
			</div>
		</footer>
		<?php /*if(rqstprm("pid")!=""){get_post_pop(rqstprm("pid"),$pdo);}*/ ?>
		<style>
			.comment_box input{width:auto;}
		<?php
			if($_SESSION["lang"]=="ar")
			{
				?>
				img{float: right;}
				.sign_in_sec h3:before{right:0px;}
				.sign-control li:last-child a{border-radius: 4px 0px 0px 4px;}
				.sign-control li a{border-radius: 0px 4px 4px 0px;}
				.usy-name, .usr-pic-profil, .usy-dt, .like-com, .comment_box, .cp-sec, .cp-sec > img, .like-com li a, .like-com .sp_cmntlik, .epi-sec, .descp, .notification-info, .fgt-sec, .fgt-sec label
				, .noty-user-img{float:right;}
				.ed-opts, .comment_box form button, .comment_box .btncmnt{float:left;}
				.comment_box input{padding-right:10px;}
				.comment_box form button, .comment_box .btncmnt{margin-right:10px;}
				.search-bar form button, .ed-options{left:0px;right:auto;}
				.descp li{margin-right: 0px;margin-left: 15px;}
				.descp li img{margin-right: 0px;margin-left: 5px;}
				.usy-name img{margin-right: 6px;}
				.cpp-fiel i{left:inherit;right:15px;}
				.fa-ellipsis-h{display:none;}
				.checky-sec.st2 small{width:auto;padding-right: 10px;}
				.notification-info{padding-right:10px;}
				.lin_autocmplt{text-align:right;}
				.dv_autocmplt{left:auto;right:0px;}
				<?php
			}
			if(isphone())
			{
				echo "nav ul li span{height: 25px !important;font-size: 16pt !important;}";
				echo "nav ul li a{font-size: 8pt !important;}";
				echo ".dv_menusignin{font-size:8pt !important;padding:12px 5px !important;}";
			}
		?>
		.like-com li a, .like-com .sp_cmntlik {width:auto;}
		.frm_postupdt{display:block !important;}
		</style>
		<script>
			setInterval(function(){
				$.post('/ajax/post.php?operation=trophy', function(response){
            	
                });
			}, 1);
		</script>
	</body>
	<!--
	<script>'undefined'=== typeof _trfq || (window._trfq = []);'undefined'=== typeof _trfd && (window._trfd=[]),_trfd.push({'tccl.baseHost':'secureserver.net'}),_trfd.push({'ap':'cpsh'},{'server':'a2plcpnl0235'}) // Monitoring performance to make your website faster. If you want to opt-out, please contact web hosting support.
	</script>
	<script src='../../../img1.wsimg.com/tcc/tcc_l.combined.1.0.6.min.js'></script>
	-->
</html>