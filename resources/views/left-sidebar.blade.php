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
                  <hr style="margin-top: 5px;margin-bottom: 5px;">
				  {{config('lang.lbl_best_word')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ $user['best_word_wins']}}</b>
                  <br>{{config('lang.lbl_writer_of_month')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ $user['best_author_wins']}}</b>
                  <hr style="margin-top: 5px;margin-bottom: 5px;">
				  {{config('lang.lbl_ratepagecity')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{$user['cityRanking']}}</b>
                  <br>{{config('lang.lbl_ratepagepays')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{$user['countryRanking']}}</b>
                  <br>{{config('lang.lbl_ratepageworld')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{$user['wordRanking']}}</b>
				  <hr style="margin-top: 5px;margin-bottom: 5px;">
				  {{config('lang.lbl_income')[empty(session('lang'))?0:session('lang')]}}<br><b style='font-size:15pt;' >{{ App\Models\Post::sumTrophy(Auth::user()) + $user['income']}} $</b>
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
