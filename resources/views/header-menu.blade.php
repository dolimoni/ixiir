<header>
	<div class="container">
		<div class="header-data">
			<div class="logo">
				{{--<a href="{{route('home')}}" title=""><img src="{{asset('images/logo.png')}}" style="height:32px;"></a>--}}
				<a href="{{route('home')}}" title=""><img src="{{asset('images/logoV1.png')}}" style="height:32px;"></a>
			</div><!--logo end-->
			<div class="search-bar">
				<form action="" method="post" >
					<input type="text" name="txt_search" placeholder="Research">
					<button type="submit"><i class="la la-search"></i></button>
				</form>
			</div><!--search-bar end-->
			<!--menu-btn end-->
			@if(Auth::check())
			<div class="user-account">
				<div class="user-info">
					<a href="#" title="" class="a_imgprofil" style="background-image:url({{asset(!empty(Auth::user()->image)?Auth::user()->image:'/images/deaultuser.jpg')}});" ></a>
					<i class="fa fa-caret-down" style="right: 5px;"></i>
				</div>
				<div class="user-account-settingss">
					<ul class="us-links">
						<li><a href="{{route('getProfil',['user_id'=>Auth::user()->id])}}" title="">{{config('lang.lbl_maPage')[empty(session('lang'))?0:session('lang')]}}</a></li>
						<li>
							<a href="{{route('getProfil',['user_id'=>Auth::user()->id])}}" title="">{{config('lang.lbl_mes_messages')[empty(session('lang'))?0:session('lang')]}}</a></li>
						<li><a href="{{route('getProfil',['user_id'=>Auth::user()->id])}}" title="">{{config('lang.lbl_modifier_mon_profil')[empty(session('lang'))?0:session('lang')]}}</a></li>
					</ul>
					<h3 class="tc">
                        <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();" title="">{{config('lang.lbl_logout')[empty(session('lang'))?0:session('lang')]}}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                       </form>                             
                    </h3>
				</div><!--user-account-settingss end-->
			</div>

			<nav class='nav_menu' >
			    <?php
			      $li_active=$_SERVER['REQUEST_URI']== '/'?'li_active':'';
			      $li_active_country=str_contains($_SERVER['REQUEST_URI'],'/country/')?'li_active':'';
			      $li_active_city=str_contains($_SERVER['REQUEST_URI'],'/city/')?'li_active':'';
			      $li_active_metier=str_contains($_SERVER['REQUEST_URI'],'/metier/')?'li_active':'';
			    ?>
				<ul>
				    <li class='header-link {{$li_active_metier}}'>    
						<a href="{{route('postsMetier',!empty(Auth::user()->metierSpecialite['id'])?Auth::user()->metierSpecialite['id']:0)}}">
							<span><i class='la la-tags' ></i></span>

							<?php
    							$metierSpecialite = !empty(Auth::user()->metierSpecialite)?
    								(empty(session('lang'))?
    									0:
    									session('lang')==0?
    										Auth::user()->metierSpecialite->nom_en:
    										(empty(session('lang'))?
    										0:
    										session('lang')==1?
												Auth::user()->metierSpecialite->nom_ar:
												Auth::user()->metierSpecialite->nom_fr)):
    								config('lang.lbl_mon_domaine')[empty(session('lang'))?0:session('lang')];

							if(strlen($metierSpecialite)>13){
								$str_pour_special="<span title='".$metierSpecialite."' >".substr($metierSpecialite, 0, 13)."..</span>";
							}else{
								$str_pour_special = $metierSpecialite;
							}
							echo $str_pour_special;
							?>
						</a>
					</li>
					<li class='header-link {{$li_active_city}}'>
						<a href="{{route('postsCity',!empty(Auth::user()->city['id'])?Auth::user()->city['id']:0)}}">
							<span><i class='la la-map-marker' ></i></span>
							<span title="{{!empty(Auth::user()->city)?Auth::user()->city->nom_en:''}}">
								{{ !empty(Auth::user()->city)?\Illuminate\Support\Str::limit(Auth::user()->city->nom_en , $limit = 13, $end = '..'):config('lang.lbl_ma_ville')[empty(session('lang'))?0:session('lang')] }}
							</span>
						</a>
					</li>
					<li class='header-link {{$li_active_country}}'>
						<a href="{{route('postsCountry',!empty(Auth::user()->country->id)?Auth::user()->country->id:0)}}">
							<span><i class='la la-flag' ></i></span>
							<span title="{{!empty(Auth::user()->country)?Auth::user()->country->nom_en:''}}">
								{{ !empty(Auth::user()->country)?\Illuminate\Support\Str::limit(Auth::user()->country->nom_en , $limit = 13, $end = '..'):config('lang.lbl_mon_pays')[empty(session('lang'))?0:session('lang')] }}
							</span>
						</a>
					</li>
					<li class='header-link world-link {{$li_active}}'>
						<a href="{{route('home')}}" >
							<span><i class='la la-globe' ></i></span> {{config('lang.lbl_monde')[empty(session('lang'))?0:session('lang')]}}
						</a>
					</li>
				</ul>
			</nav><!--nav end-->

			@endif
			<div class="menu-btn">
				<a href="#" title=""><i class="fa fa-bars"></i></a>
			</div>
		</div><!--header-data end-->
	</div>
</header><!--header end-->
