@extends('header-meta')    
@section('body')
	<div class="wrapper">
		@include("header-menu-logout")
		<section class="companies-info">
			<div class="container">
				<div class="company-title" style="background:#fff;padding:20px;">
					<h3>{{config('lang.lbl_condition_utilisation')[empty(session('lang'))?0:session('lang')]}}</h3>
				</div>
				<div class="companies-list">
					<div class="row">
						<div class="col-md-12" style="background:#fff;padding:20px;">
							<iframe src="/upload/conditions.pdf" style="width:100%;height:3500px;" ></iframe>
						</div>
					</div>
				</div><!--companies-list end-->
				
			</div>
		</section><!--companies-info end-->


	</div><!--theme-layout end-->
@endsection