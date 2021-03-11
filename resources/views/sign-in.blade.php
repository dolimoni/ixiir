@extends('header-meta')
@section('body')
<div class="wrapper">
  <div class="sign-in-page" style="padding:0px;" >

   <div class="signin-popup" style="width:100%;" >

	<div class="signin-pop">

		<div class="row">

			<div class="col-lg-8 bg-light" id="dv_postlogin" >

				<div class="pt-3">

					<div class="text-right" style='margin-bottom:0px;' >

						<div>
						    @if(empty(session('lang')) || session('lang')==0)
						      <img src="{{asset('images/ixiir_en.jpeg')}}" alt="" style='margin-bottom:20px;max-height:64px;' />
						    @elseif(session('lang')==2)
						      <img src="{{asset('images/ixiir_fr.jpeg')}}" alt="" style='margin-bottom:20px;max-height:64px;' />
						    @else
						      <img src="{{asset('images/ixiir_ar.jpeg')}}" alt="" style='margin-bottom:20px;max-height:64px;' />
						    @endif
						</div>
					</div>
				</div>
				<div class="clearfix"></div>	
				<div class='mb-4 text-center' style='background:#a349a4;'>
                     <div class='text-white p-3' >{!!config('lang.lbl_word_world')[empty(session('lang'))?0:session('lang')]!!}</div>
				</div>
				@include('hotTopicsTemplate')
				<div class='company-title row p-0' >
				    <div class='col-md-6 no-padding-colmd posts-div no-padding-left'>
					   @foreach($postsTopFive_even as $key=>$post)
					     @include('templatePost')
					   @endforeach
					</div>
					<div class='col-md-6 no-padding-colmd posts-div no-padding-right'>
					   @foreach($postsTopFive_odd as $key=>$post)
					     @include('templatePost')
					   @endforeach
					</div>
					
				</div>
				<div class="clearfix"></div>
				<div class='mb-4 p-2' style='font-size:18pt;background:#eee;' ><i class="la la-clock-o"></i>{{config('lang.lbl_lastpost')[empty(session('lang'))?0:session('lang')]}}</div>
				<div class="pd-right-none no-pd">
				   <div class="main-ws-sec">
                       <div class="posts-section">
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
                       </div>
					</div>
				</div> 
                <div class='clearfix' ></div>
                <div class='mb-4 p-2 text-center' style='font-size:15pt;background:#fd8222;color:#fff;' >{{config('lang.lbl_connectToView')[empty(session('lang'))?0:session('lang')]}}</div>
			</div>
			<div class="col-lg-4" id="dv_formlogin" >
	          <div class="login-sec">
			  	<ul class="sign-control">

				  <li data-tab="tab-1" class="current"><a href="#" title="">{{config('lang.lbl_login')[empty(session('lang'))?0:session('lang')]}}</a></li>				

				  <li data-tab="tab-2"><a href="#" title="">{{config('lang.lbl_sinscrit')[empty(session('lang'))?0:session('lang')]}}</a></li>				

				</ul>
				<div class="sign_in_sec current" id="tab-1">
					<h3>{{config('lang.lbl_login')[empty(session('lang'))?0:session('lang')]}}</h3>
                    @include('sign-inForm')
					<div class="login-resources">

						<h3 style="text-align:left;" >{{config('lang.lbl_connexion_via_reseau_soc')[empty(session('lang'))?0:session('lang')]}}</h3>

						<ul>

							<li><a href="{{ url('/login/facebook') }}" title="" class="fb"><i class="fa fa-facebook"></i>{{config('lang.lbl_connexion_facebook')[empty(session('lang'))?0:session('lang')]}}</a></li>

						

							<li><a href="{{ url('/login/google') }}" title="" class="gp"><i class="fa fa-google-plus"></i>{{config('lang.lbl_connexion_googleplus')[empty(session('lang'))?0:session('lang')]}}</a></li> 

							

						</ul>

					</div><!--login-resources end-->

				</div><!--sign_in_sec end-->
				<div class="sign_in_sec" id="tab-2">
				   <h3 style="text-align:left;" >{{config('lang.lbl_sinscrit')[empty(session('lang'))?0:session('lang')]}}</h3>
				   <div class="dff-tab current" id="tab-3">
				       @include('formInscription')
				   </div>
				</div>
			  </div>
			</div>
		</div>
	 </div>
	 </div>
	</div>					
</div>	
@endsection