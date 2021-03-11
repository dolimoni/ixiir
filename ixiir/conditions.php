<?php $str_page="conditions"; require("header-meta.php"); ?>
	<div class="wrapper">
		<?php require("header-menu-logout.php"); ?>
		<section class="companies-info">
			<div class="container">
				<div class="company-title" style="background:#fff;padding:20px;">
					<h3><?php echo get_label('lbl_condition_utilisation'); ?></h3>
				</div>
				<div class="companies-list">
					<div class="row">
						<div class="col-lg-12" style="background:#fff;padding:20px;">
							<iframe src="<?php echo $strurlsite."upload/conditions.pdf"; ?>" style="width:100%;height:3500px;" ></iframe>
						</div>
					</div>
				</div><!--companies-list end-->
				
			</div>
		</section><!--companies-info end-->


	</div><!--theme-layout end-->

<?php require("footer.php"); ?>