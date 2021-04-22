<div class='col-md-12'>
	<div class='posty' style="margin-bottom: 2px;">
		<div class='post-bar no-margin'>
			<div class='post_topbar'>
				<div class='usy-dt'>
					@if(Auth::check())
						<a href="{{route('getProfil',['user_id'=>$user['id']])}}">
							@else
								<a href="" data-toggle="modal" data-target="#modalLogin">
									@endif
									<div class='usr-pic-profil' style="background-image: url({{asset(!empty($user['image'])?$user['image']:'/images/deaultuser.jpg')}});" >
									</div>
								</a>
								<div class='usy-name'>
									<h3 style='font-size:11pt;padding:0px;' >
										@if(Auth::check())
											<a href="{{route('getProfil',['user_id'=>$user['id']])}}">{{$user->prenom}} {{$user->nom}}</a>
										@else
											<a href="" data-toggle="modal" data-target="#modalLogin">
												<a href="{{route('getProfil',['user_id'=>$user['id']])}}">{{$user->prenom}} {{$user->nom}}</a>
											</a>
										@endif
									</h3>

									<div>
										@if(!empty($user['city']))
											<?php
											$city = $user['city'][empty(session('lang')) || session('lang')==0?'nom_en':(session('lang')==1?'nom_ar':'nom_fr')];
											?>
											<b title="{{$city}}" style='color:#A3A3A3;font-size: 14px;'>
												{{\Illuminate\Support\Str::limit($city , $limit = 13, $end = '..')}}
											</b>
										@endif
										@if(!empty($user['country']) && !empty($user['city']))
											<span>
                         <b style='color:#A3A3A3;font-size: 14px;' > - {{$user['country'][empty(session('lang')) || session('lang')==0?'nom_en':(session('lang')==1?'nom_ar':'nom_fr')]}}</b>
                      </span>
										@endif
									</div>
								</div>
				</div>
			</div>
		</div>
	</div>
</div>



