<div class="main-left-sidebar no-margin">

	<div class="user-data full-width">

		<div class="user-profile">

			<div class="username-dt">

				<div class="usr-pic" style="background-image:url({{asset(!empty(Auth::user()->image)?Auth::user()->image:'/images/deaultuser.jpg')}});" ></div>

			</div><!--username-dt end-->

			<div class="user-specs">

				<h3>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h3>
                
				<span>
                  <hr>
                  {{config('lang.lbl_nbrvisit_page')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ Auth::user()->userVue()->count() }}</b>
                  <br>{{config('lang.lbl_abonne_fidele')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ App\Models\User::countAbonnes(Auth::user()->id) }}</b>
                  <br>{{config('lang.lbl_les_posts')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ App\Models\User::posts(Auth::user()->id)->count() }}</b>
                  <br>{{config('lang.lbl_nbrvueposts')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ App\Models\User::posts(Auth::user()->id)->sum('postsVue')}}</b>
                  <br>{{config('lang.lbl_income')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ App\Models\Post::sumTrophy(Auth::user())}} $</b>
				</span>

			</div>

		</div><!--user-profile end-->

		<ul class="user-fw-status">

			<li>

				<a href="{{route('getProfil',['user_id'=>Auth::user()->id])}}" title="">{{config('lang.lbl_mon_profil')[empty(session('lang'))?0:session('lang')]}}</a>

			</li>

		</ul>

	</div>

</div>