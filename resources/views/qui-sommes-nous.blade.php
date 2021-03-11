@extends('header-meta')    
@section('body')
	<div class="wrapper">
		@include("header-menu-logout")
		<section class="companies-info">
			<div class="container">
				<div class="company-title" style="background:#fff;padding:20px;">
					<h3>{{config('lang.lbl_quisomenous')[empty(session('lang'))?0:session('lang')]}}</h3>
				</div>
				<div class="companies-list">
					<div class="row">
						<div class="col-md-12" style="background:#fff;padding:20px;">
							<p>{{config('lang.lbl_quisomenoudesc_p1')[empty(session('lang'))?0:session('lang')]}}</p>
							<p>{{config('lang.lbl_quisomenoudesc_p2')[empty(session('lang'))?0:session('lang')]}}</p>
							<p>{{config('lang.lbl_quisomenoudesc_p3')[empty(session('lang'))?0:session('lang')]}}</p>
							<p>{{config('lang.lbl_quisomenoudesc_p4')[empty(session('lang'))?0:session('lang')]}}</p>
						</div>
					</div>
				</div><!--companies-list end-->
				
			</div>
		</section><!--companies-info end-->


	</div><!--theme-layout end-->
@endsection