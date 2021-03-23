@extends('header-meta')    
@section('body')
	<div class="wrapper">
		@include("header-menu-logout")
		<section class="companies-info">
			<div class="container">
				<div class="company-title" style="background:#fff;padding:20px;">
					<h3>{{config('lang.lbl_quisomenous')[empty(session('lang'))?0:session('lang')]}}</h3>
				</div>
				<div  class="companies-list">
					<div class="row">
						<div dir="rtl" lang="ar"  class="col-md-12" style="background:#fff;padding:20px;">

							<p class="who-we-are-content-ar">{!! html_entity_decode(nl2br(e(ARABIC_WHO_WE_ARE))) !!}</p>
						</div>
					</div>
				</div><!--companies-list end-->
				
			</div>
		</section><!--companies-info end-->


	</div><!--theme-layout end-->
@endsection
