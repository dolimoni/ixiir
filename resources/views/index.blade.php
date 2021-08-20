@extends('header-meta2')
@section('body')

	<div class="wrapper">
        @include('header-menu')

		<main>

			<div class="main-section" id="dv_mainlistpost" >

				<div style="width:96%;margin: auto;">

					<div class="main-section-data">

						<div class="row">

							<div class="col-lg-3 col-md-8 no-pd" id="dv_leftpartpost" >

								@include('left-sidebar')

								<div class="right-sidebar">

									<div>
										<div style="color: #a349a4;margin-bottom: 10px;">
											{{config('lang.lbl_most_read_writers_10')[empty(session('lang'))?0:session('lang')]}}
										</div>
										@foreach($bestAuthors as $key => $author)
											@if ($key===10)
												@break
											@endif
											@include('author_min')

										@endforeach

									</div>

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
									@if(count($postsTopFive_even))
									<div class='col-md-6 no-padding-colmd posts-div no-padding-left'>
                                    @foreach($postsTopFive_even as $key=>$post)
                                        @include('templatePost')
                                    @endforeach
                                    </div>
									@endif
									@if(count($postsTopFive_odd))
                                    <div class='col-md-6 no-padding-colmd posts-div no-padding-right'>
                                    @foreach($postsTopFive_odd as $key=>$post)
                                        @include('templatePost')
                                    @endforeach
                                    </div>
									@endif

									<div class="posts-section">

										<div class='company-title row' style='background:#fff;padding:0px; margin-bottom: 0; margin-top: 10px;' >

											<div class='col-4 col-md-4 dv_btnfilter btn_latest dv_filteractive' onclick="show('latest');hide('interactive');hide('authors');activePosts('btn_latest');"><i class="la la-clock-o"></i> {{config('lang.lbl_lastpost')[empty(session('lang'))?0:session('lang')]}}</div>

											<div class='col-4 col-md-4 dv_btnfilter btn_interactive' onclick="hide('latest');show('interactive');hide('authors');activePosts('btn_interactive');"><i class="fa fa-fire"></i> {{config('lang.lbl_mostineractive')[empty(session('lang'))?0:session('lang')]}}</div>

											<div class='col-4 col-md-4 dv_btnfilter btn_latest dv_filteractive' onclick="show('authors');hide('interactive');hide('latest');activePosts('btn_latest');"><i class="la la-clock-o"></i> {{config('lang.lbl_best_authors')[empty(session('lang'))?0:session('lang')]}}</div>

											<div class='clearfix' ></div>

									    </div>
                                        <div id="latest">
											@if(count($posts_even))
                                             <div class='col-md-6 no-padding-colmd posts-div no-padding-left'>
                                                @foreach($posts_even as $key=>$post)
																@include('templatePost')
                                                @endforeach
												<div class="hidden morePosts">
												@foreach($posts_even_plus as $key=>$post)
                                                    @include('templatePost')
                                                @endforeach
												</div>
												<div class="hidden morePosts2">
												@foreach($posts_even_plus2 as $key=>$post)
                                                    @include('templatePost')
                                                @endforeach
															</div>
														</div>
											@endif
											@if(count($posts_odd))
                                            <div class='col-md-6 no-padding-colmd posts-div no-padding-right'>
                                                    @foreach($posts_odd as $key=>$post)
                                                        @include('templatePost')
													@endforeach
												<div class="hidden morePosts">
													@foreach($posts_odd_plus as $key=>$post)
																@include('templatePost')
                                                    @endforeach
														</div>
												<div class="hidden morePosts2">
													@foreach($posts_odd_plus2 as $key=>$post)
																@include('templatePost')
                                                    @endforeach
															</div>
														</div>
												@endif
                                        </div>

										<div id="authors" style="display: none;">

											<div class="top-writers-bloc">
												{{config('lang.lbl_most_read_writers')[empty(session('lang'))?0:session('lang')]}}
											</div>
											@foreach($bestAuthors as $key => $author)
												@include('author')<span style="visibility: hidden">;</span>

											@endforeach

                                        </div>
                                        <div id="interactive" style="display:none;">
											@if(count($postsInteractive_even))
                                             <div class='col-md-6 no-padding-colmd posts-div no-padding-left'>
                                                @foreach($postsInteractive_even as $key=>$post)
                                                    @include('templatePostInteract')
                                                @endforeach
                                            </div>
											@endif
											@if(count($postsInteractive_odd))
                                            <div class='col-md-6 no-padding-colmd posts-div no-padding-right'>
                                                    @foreach($postsInteractive_odd as $key=>$post)
                                                        @include('templatePostInteract')
                                                    @endforeach
                                            </div>
											@endif
                                        </div>
										<div id="btn_loadplus" >

                        					<div id="loadMore" class='dv_cntnbtnplus' onclick="loadPosts(2)">{{config('lang.lbl_chargerplus')[empty(session('lang'))?0:session('lang')]}}</div>

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


	<script>
		$( document ).ready(function() {

			var timer2 = $('.countdown').attr('data-time-left');

				//intercal for seconds
				var interval = setInterval(function() {
					//timer will be [hour, minute, second]
					var timer = timer2.split(':');
					var hours = parseInt(timer[0], 10);
					var minutes = parseInt(timer[1], 10);
					var seconds = parseInt(timer[2], 10);
					//reduce second by one
					--seconds;
					//calculate new minute and hours
					minutes = (seconds < 0) ? --minutes : minutes;
					hours = minutes < 0 ? --hours : hours;

					if (hours < 0) {
						clearInterval(interval);
						return;
					}

					seconds = (seconds < 0) ? 59 : seconds;
					seconds = (seconds < 10) ? '0' + seconds : seconds;
					minutes = (minutes < 0) ? 59 : minutes;
					minutes = (minutes < 10) ? '0' + minutes : minutes;

					timer2 = hours + ':' + minutes + ':' + seconds;
					$('.countdown').html(timer2);

				}, 1000);

			$('.dislike').on('click',function (){
				jQuery(this).find('.la-thumbs-down').toggleClass('active-picto');
				var dislikeCountElement = jQuery(this).find('b');
				var values = {
					'id':$(this).attr('data-post-id'),
					"_token": "{{ csrf_token() }}"
				};
				$.ajax({
					url : "{{route('dislikePost')}}",
					type : 'POST',
					dataType:'json',
					data:values,
					success : function(response){ // success est toujours en place, bien sûr !
						dislikeCountElement.text(response.disliksCount);
					},

					error : function(resultat, statut, erreur){
						alert('Erreur de traitement');
					}

				});
			})

		});
	</script>

	@include('includes.modalUpdatePost');
    @endsection




