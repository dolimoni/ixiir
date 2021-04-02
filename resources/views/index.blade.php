@extends('header-meta2')
@section('body')

	<div class="wrapper">
        @include('header-menu')

		<main>

			<div class="main-section" id="dv_mainlistpost" >

				<div class="container">

					<div class="main-section-data">

						<div class="row">

							<div class="col-lg-3 col-md-8 no-pd" id="dv_leftpartpost" >

								@include('left-sidebar')

								<div class="right-sidebar">

									<div class="widget widget-about">

										<img src="images/cm-logo.png" alt="" style='margin:20px 0px;' />

										<h3>{{config('lang.lbl_comutilefficace')[empty(session('lang'))?0:session('lang')]}}</h3>

										<span style="padding:10px 20px;" >{{config('lang.lbl_restconnectenvr')[empty(session('lang'))?0:session('lang')]}}</span>

									</div>

									<div class="tags-sec full-width">
                                        	<ul>

                    						<li><a href="{{route('qui-sommes-nous')}}">{{config('lang.lbl_quisomenous')[empty(session('lang'))?0:session('lang')]}}</a></li>

						                    <li><a href="{{route('conditions')}}">{{config('lang.lbl_condition_utilisation')[empty(session('lang'))?0:session('lang')]}}</a></li>

                    						<li><a href="mailto:ixiirpress@gmail.com" >ixiirpress@gmail.com</a></li>

                    						<li><a href="{{route('setLang','fr')}}" >Français</a></li>

                    						<li><a href="{{route('setLang','ar')}}" >العربية</a></li>

                    						<li><a href="{{route('setLang','en')}}" >English</a></li>

                    			        </ul>
										<div class="cp-sec">
                                            {{str_replace("[[PARAM2]]",'IXIIR',str_replace("[[PARAM1]]", Carbon\Carbon::now()->year,config('lang.lbl_copyright')[empty(session('lang'))?0:session('lang')]))}}
										</div>

									</div>

								</div>

							</div>

							<div class="col-lg-9 pd-right-none no-pd">

								<div class="main-ws-sec">

								   @include('addPostForm')
                                   @include('hotTopicsTemplate')
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

									<div class="posts-section">

										<div class='company-title row' style='background:#fff;padding:0px;' >

											<div class='col-md-6 dv_btnfilter btn_latest dv_filteractive' onclick="show('latest');hide('interactive');activePosts('btn_latest');"><i class="la la-clock-o"></i> {{config('lang.lbl_lastpost')[empty(session('lang'))?0:session('lang')]}}</div>

											<div class='col-md-6 dv_btnfilter btn_interactive' onclick="hide('latest');show('interactive');activePosts('btn_interactive');"><i class="fa fa-fire"></i> {{config('lang.lbl_mostineractive')[empty(session('lang'))?0:session('lang')]}}</div>

											<div class='clearfix' ></div>

									    </div>
                                        <div id="latest">
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
                                        <div id="interactive" style="display:none;">
                                             <div class='col-md-6 no-padding-colmd posts-div no-padding-left'>
                                                @foreach($postsInteractive_even as $key=>$post)
                                                    @include('templatePost')
                                                @endforeach
                                            </div>
                                            <div class='col-md-6 no-padding-colmd posts-div no-padding-right'>
                                                    @foreach($postsInteractive_odd as $key=>$post)
                                                        @include('templatePost')
                                                    @endforeach
                                            </div>
                                        </div>
										<div id="btn_loadplus" >

                        					<div class='dv_cntnbtnplus' onclick="loadPosts(2)">{{config('lang.lbl_chargerplus')[empty(session('lang'))?0:session('lang')]}}</div>

                        				</div>


									</div>

								</div><!--main-ws-sec end-->

							</div>

						</div>

					</div>

				</div>

			</div>

		</main>



	</div><!--theme-layout end-->
	@include('includes.modalUpdatePost');
    @endsection

