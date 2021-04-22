<header>
	<div class="container">
		<div class="header-data">
			<div class="logo">
				{{--<a href="{{route('home')}}" title=""><img src="{{asset('images/logo.png')}}" style="height:32px;"></a>--}}
				<a href="{{route('home')}}" title=""><img src="{{asset('images/logoV1.png')}}" style="height:32px;"></a>
			</div><!--logo end-->
			<div class="search-bar">
				<form action="{{route('search')}}" method="get" >
					<input type="text" name="txt_search" placeholder="{{config('lang.lbl_search')[empty(session('lang'))?0:session('lang')]}}">
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
				<div class="show-in-large">
					@include('includes.nav_menu')
				</div>
			@endif
			<div class="menu-btn">
				<a href="#" title=""><i class="fa fa-bars"></i></a>
			</div>
		</div><!--header-data end-->
	</div>
	<div class="hide-in-large">
		@include('includes.nav_menu')
	</div>
</header><!--header end-->
