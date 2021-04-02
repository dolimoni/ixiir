@extends('header-meta')
@section('body')
<div class="wrapper">



  <div class="sign-in-page" style="padding:0px;" >

   <div class="signin-popup" style="width:100%;" >

	<div class="signin-pop">

		<div class="">
			<div class="row hide-in-large" style="background: #f5f5f5">
				<div class="pt-3">

					<div class="text-right" style='margin-bottom:0px;' >



						<div>
							@if(empty(session('lang')) || session('lang')==0)
								{{--<img src="{{asset('images/ixiir_en.jpeg')}}" alt="" style='margin-bottom:20px;max-height:64px;' />--}}
								<img src="{{asset('images/ixiir_logo_1.png')}}" alt="" style='margin-bottom:20px;max-height:64px;' />
							@elseif(session('lang')==2)
								{{--<img src="{{asset('images/ixiir_fr.jpeg')}}" alt="" style='margin-bottom:20px;max-height:64px;' />--}}
								<img src="{{asset('images/ixiir_logo_1.png')}}" alt="" style='margin-bottom:20px;max-height:64px;' />
							@else
								{{--<img src="{{asset('images/ixiir_ar.jpeg')}}" alt="" style='margin-bottom:20px;max-height:64px;' />--}}
								<img src="{{asset('images/ixiir_logo_1.png')}}" alt="" style='margin-bottom:20px;max-height:64px;' />
							@endif
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class='mb-4 text-center' style='background:#a349a4;width: 100%;'>
					<div class='text-white p-3' >{!!config('lang.lbl_word_world')[empty(session('lang'))?0:session('lang')]!!}</div>
				</div>
			</div>
		</div>


		<div class="row">


			<div class="col-lg-8 order-lg-first order-md-last order-last bg-light" id="dv_postlogin" >

				<div class="show-in-large">
					<div class="pt-3">

						<div class="text-right" style='margin-bottom:0px;margin-left: 15px;' >



							<div>
								@if(empty(session('lang')) || session('lang')==0)
									<img src="{{asset('images/ixiir_logo_1.png')}}" alt="" style='margin-bottom:20px;max-height:64px;' />
									{{--<img src="{{asset('images/ixiir_en.jpeg')}}" alt="" style='margin-bottom:20px;max-height:64px;' />--}}
								@elseif(session('lang')==2)
									<img src="{{asset('images/ixiir_logo_1.png')}}" alt="" style='margin-bottom:20px;max-height:64px;' />
									{{--<img src="{{asset('images/ixiir_fr.jpeg')}}" alt="" style='margin-bottom:20px;max-height:64px;' />--}}
								@else
									<img src="{{asset('images/ixiir_logo_1.png')}}" alt="" style='margin-bottom:20px;max-height:64px;' />
									{{--<img src="{{asset('images/ixiir_ar.jpeg')}}" alt="" style='margin-bottom:20px;max-height:64px;' />--}}
								@endif
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class='mb-4 text-center' style='background:#a349a4;'>
						<div class='text-white p-3' >{!!config('lang.lbl_word_world')[empty(session('lang'))?0:session('lang')]!!}</div>
					</div>
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
			<div class="col-lg-4 order-lg-last order-md-first order-first"  id="dv_formlogin" >
	          @include('includes.login');
			</div>
		</div>
	 </div>
	 </div>
	</div>					
</div>
@include('includes.modalLogin');
@endsection
