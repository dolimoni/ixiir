<div class='col-md-12'>
    <div class='posty' id="dv_post_{{$post['post_id']}}">
        <div class='post-bar no-margin'>
        <div class='post_topbar'>
            <div class='usy-dt'>
                @if(Auth::check())
                    <a href="{{route('getProfil',['user_id'=>$post['par']])}}">
                @else
                    <a href="" data-toggle="modal" data-target="#modalLogin">
                @endif
                    <div class='usr-pic-profil' style="background-image: url({{asset(!empty($post['userDetails']['image'])?$post['userDetails']['image']:'/images/deaultuser.jpg')}});" >
                       @if((in_array($key,array(0,1,2,3,4)) && (isset($post['all']) && !$post['all']) && !isset($post['profil'])) || (isset($post['profil']) && !empty($post['trophy'])))
                        <img src="{{asset('images/trone.png')}}" height='70' width='70' style='float: right;position: relative;left: 10px;top:-5px;'>
                       @endif
                    </div>
                </a>
                <div class='usy-name'>
                    <div style='font-size:11pt;padding:0px; font-weight: bold;' >
                        @if(Auth::check())
                            <a href="{{route('getProfil',['user_id'=>$post['par']])}}">{{isset($post['userDetails'])?$post['userDetails']['prenom']:''}} {{isset($post['userDetails'])?$post['userDetails']['nom']:''}}</a>
                        @else
                            <a href="" data-toggle="modal" data-target="#modalLogin">
                                {{isset($post['userDetails'])?$post['userDetails']['prenom']:''}} {{isset($post['userDetails'])?$post['userDetails']['nom']:''}}
                            </a>
                        @endif
                    </div>

                    <div style="margin-top: 4px;">
                      @if(!empty($post['userDetails']['city']))
                            <?php
                            $city = $post['userDetails']['city'][empty(session('lang')) || session('lang')==0?'nom_en':(session('lang')==1?'nom_ar':'nom_fr')];
                            ?>
                      <b title="{{$city}}" style='color:#A3A3A3;font-size: 14px;'>
                          {{\Illuminate\Support\Str::limit($city , $limit = 13, $end = '..')}}
                      </b>
                      @endif
                      @if(!empty($post['userDetails']['country']) && !empty($post['userDetails']['city']))
                      <span>
                         <b style='color:#A3A3A3;font-size: 14px;' > - {{$post['userDetails']['country'][empty(session('lang')) || session('lang')==0?'nom_en':(session('lang')==1?'nom_ar':'nom_fr')]}}</b>
                      </span>
                      @endif
					</div>

                    <span style="margin-top: 4px; display: block;">
                            <?php
                        $lang = 'en';
                        if(isset(Config::get('constants.LANG')[session('lang')])){
                            $lang = \Carbon\Carbon::setLocale(Config::get('constants.LANG')[session('lang')]);
                        }
                        echo \Carbon\Carbon::createFromTimeStamp(strtotime($post['date_ajout']))->diffForHumans();
                        ?>
                    </span>
                </div>
            </div>
            @if(Auth::check())
            <div class='ed-opts'>
                 @if($post['par']==Auth::user()->id || Auth::user()->user_type==0)
                 	<a href='javascript:void(0)' title='' class='ed-opts-open' onclick='show_pst(this);' ><i class='la la-ellipsis-v'></i></a>
    				<ul class='ed-options'>
    					<li>

    						<input type='hidden' id='txt_youtube_{{$post['post_id']}}' value='{{$post['youtube']}}' />

                            @if($params['isHotTopic'])
                                <b  data-tag-name="{{$topicEntity['tag']}}" data-tag-id="{{$topicEntity['id']}}" data-content="{{$post['detail']}}"  data-post="{{$post['post_id']}}" data-toggle="modal" data-target="#modalUpdatePost" >{{config('lang.lbl_modifier')[empty(session('lang'))?0:session('lang')]}}</b>
                            @else
    						    <b  @if(!empty($post['tag'])) data-tag-name="{{$post['tag']['tag']}}" data-tag-id="{{$post['tag']['id']}}" @endif data-content="{{$post['detail']}}"  data-post="{{$post['post_id']}}" data-toggle="modal" data-target="#modalUpdatePost" >{{config('lang.lbl_modifier')[empty(session('lang'))?0:session('lang')]}}</b>
                            @endif
    					</li>

    					<li><a style='color:red;'  href="{{route('deletePost',['id'=>$post['post_id']])}}" >{{config('lang.lbl_supprimer')[empty(session('lang'))?0:session('lang')]}}</a></li>

    				</ul>
                @endif
			</div>
			@endif
            @if($post['winner']==="true")
            <a href='https://www.ixiir.com/concurrence' target="_blank"><img src="{{asset('images/best_word_award.png')}}" width='35' height='45' style='float: right;'></a>
            @endif
        </div>
        <div dir="rtl" lang="ar" class='job_descp' style="text-align: right;">
            @if(!empty($post['tag']))
                @if(Auth::check())
                    <a href="{{route('hottopicDetail',['topic'=>$post['tag']['tag']])}}"><i class="fa fa-fire"></i>{{$post['tag']['tag']}}</a>
                @else
                    <a href="#" data-toggle="modal" data-target="#modalLogin"><i class="fa fa-fire"></i>{{$post['tag']['tag']}}</a>
                @endif

            @endif
            @if(strlen(htmlspecialchars($post['detail']))>250)
            <p  id="p_resumer_{{$post['post_id']}}" onclick="show('p_detail_{{$post['post_id']}}');hide('p_resumer_{{$post['post_id']}}');@if(Auth::check() && $post['userDetails']['id']!=Auth::user()->id && App\Models\Post::postsVueUser($post['post_id'],Auth::user()->id)<=0)set_vue({{$post['post_id']}})@endif">{{substr(htmlspecialchars($post['detail']), 0, strlen($post['detail'])>300?strpos($post['detail'], ' ', 300):-1)}}... <span data-post-id="{{$post['post_id']}}" class='pl showMore' style='color: #fd8222;' onclick="@if(Auth::check() && $post['userDetails']['id']!=Auth::user()->id)set_vue({{$post['post_id']}})@endif">{{config('lang.plus')[empty(session('lang'))?0:session('lang')]}}</span></p>
            <p dir="rtl" lang="ar" id="p_detail_{{$post['post_id']}}" style='display:none;'>
                {!! html_entity_decode(nl2br(e($post['detail']))) !!}
            </p>
            @else
            <p dir="rtl" lang="ar" id="p_detail_{{$post['post_id']}}">
                {!! html_entity_decode(nl2br(e($post['detail']))) !!}
            </p>
            @endif
            @if(!empty($post['image']))
            <img src="{{asset($post['image'])}}" style="max-width:100%;margin-bottom:20px;" alt="">
            @endif
            @if(!empty($post['youtube']))
            <iframe style='width:100%;height:400px;border:none;' src="{{$post['youtube']}}" name='iframe1' frameborder='0'  allow='autoplay; encrypted-media' allowfullscreen></iframe>
            @endif
            <div data-post-id="{{$post['post_id']}}" id="cacher_share_{{$post['post_id']}}" class="pull-right margin_top_30 social-media-share hidden">

                <?php $shareLink = "https://www.facebook.com/sharer/sharer.php?u=".route('showPost',['id'=>$post['post_id']]) ?>
                <button data-link= "{{$shareLink}}"
                        data-post= "{{route('showPost',['id'=>$post['post_id']])}}"
                        data-content="{{$post['detail']}}"
                        data-img="{{asset(!empty(Auth::user()->image)?Auth::user()->image:'/images/deaultuser.jpg')}}"
                        class="btnShare btn_share btn_facebook shareFb" >

                    <i class='fa fa-facebook' ></i> {{config('lang.lbl_partager')[empty(session('lang'))?0:session('lang')]}}

                </button>
                    <a
                       target="_blank"
                       href="https://twitter.com/share?url={{route('showPost',['id'=>$post['post_id']])}}&text={{\Illuminate\Support\Str::limit($post['detail'] , $limit = 280-2-strlen(route('showPost',['id'=>$post['post_id']]))-1, $end = '..')}}"
                       class="twitter-share-button btnShare btn_share btn_twitter"
                       data-show-count="false">
                        <i class='la la-twitter' ></i> {{config('lang.lbl_teweet')[empty(session('lang'))?0:session('lang')]}}
                    </a>

            </div>
        </div>
        <div class='job-status-bar'>

			<ul class='like-com'>

				<li class='sp_cmntlik' onclick="@if(Auth::check() && $post['userDetails']['id']!=Auth::user()->id)set_jaime({{$post['post_id']}}, 0);@endif" >
					<i class='la la-thumbs-up' id="i_icojaime_{{$post['post_id']}}" style="cursor:pointer;@if(App\Models\Post::postsJaimeUser($post['post_id'],Auth::user()['id'])>0)color:orange;@endif"></i>
                    <b id="b_nbrjaime_{{$post['post_id']}}" >{{App\Models\Post::countPostJaime($post['post_id'])}}</b>
                    <input type='hidden' id="txt_isuserjaime_{{$post['post_id']}}" value="{{App\Models\Post::postsJaimeUser($post['post_id'],Auth::user()['id'])>0?1:0}}" />
				</li>

                <li class='sp_cmntlik dislike' data-post-id="{{$post['post_id']}}" >
					<i class='la la-thumbs-down @if($post['alreadyDisliked'])active-picto @endif' style="cursor:pointer;"></i>
                    <b>{{$post['dislikeCount']}}</b>
				</li>

                <li class='sp_cmntlik comment-link' onclick="show('cacher_comment_{{$post['post_id']}}');show('comments_label_{{$post['post_id']}}');" style="cursor:pointer;@if(Auth::check() && App\Models\Post::countPostComment($post['post_id'])>0)color:orange;@endif">

                    <i class='la la-comment'></i>

                    <b id="b_nbrcmntr_{{$post['post_id']}}" >{{App\Models\Post::countPostComment($post['post_id'])}}</b>

                </li>

                <li class='sp_cmntlik' id="i_icovue_{{$post['post_id']}}" onclick="@if(Auth::check() && $post['userDetails']['id']!=Auth::user()->id && App\Models\Post::postsVueUser($post['post_id'],Auth::user()->id)<=0)set_vue({{$post['post_id']}})@endif"  style="cursor:pointer;@if(Auth::check() && App\Models\Post::postsVueUser($post['post_id'],Auth::user()->id)>0)color:orange;@endif">

                    <i class='la la-eye'></i>

                    <b id="b_nbrvue_{{$post['post_id']}}" >{{App\Models\Post::countPostVues($post['post_id'])}}</b>
                    <input type='hidden' id="txt_isuservue_{{$post['post_id']}}" value="{{App\Models\Post::postsVueUser($post['post_id'],Auth::user()['id'])>0?1:0}}" />
                </li>

                <li class='sp_cmntlik' id="li_abonne_{{$post['post_id']}}" onclick="@if(Auth::check() && $post['userDetails']['id']!=Auth::user()->id)init_abonne({{$post['post_id']}}, {{$post['par']}}, {{Auth::user()['id']}})@endif"  style="cursor:pointer;@if(App\Models\User::abonnesUser($post['userDetails']['id'],Auth::user()['id'])>0)color:orange;@endif">
                    @if(count($post['userDetails']['abonnes'])<=0)
                       <i class='la la-hand-rock-o' id="i_icoabone_{{$post['post_id']}}" ></i>
                    @else
                       <i class='la la-hand-pointer-o' id="i_icoabone_{{$post['post_id']}}" ></i>
                    @endif
                    <b id="sp_nbrabone_{{$post['post_id']}}" >{{App\Models\User::countAbonnes($post['userDetails']['id'])}}</b>
                    @if(App\Models\User::countAbonnes($post['userDetails']['id'])>1)
                       {{config('lang.lbl_suivis')[empty(session('lang'))?0:session('lang')]}}
                    @else
                       {{config('lang.lbl_suivi')[empty(session('lang'))?0:session('lang')]}}
                    @endif
                    <input type='hidden' id="txt_isabonne_{{$post['post_id']}}" value="{{App\Models\User::abonnesUser($post['userDetails']['id'],Auth::user()['id'])>0?1:0}}" />
                </li>

            </ul>

		</div>
      </div>
      <div class="job-status-bar comments-label" id="comments_label_{{$post['post_id']}}">

						<ul class="like-com">

							<li class="sp_cmntlik">

								<b id="com_title">{{config('lang.lbl_commentaires')[empty(session('lang'))?0:session('lang')]}}</b>

							</li>

						</ul>

					</div>
					<div  class='comment-section' style="{{$params['showComments']? 'display:block;':''}}" id="cacher_comment_{{$post['post_id']}}">

						<div class='comment-sec'>

							<ul  dir="{{session('lang') !='1' ? 'ltr':'rtl' }}" lang="{{session('lang') !='1' ? 'ar':'fr' }}" id="ul_cmentaire_{{$post['post_id']}}" >



								@if(App\Models\Post::countPostComment($post['post_id'])>0)

								   @foreach(App\Models\Post::postComment($post['post_id']) as $comment)


										<li id="li_cmentaire_{{$post['post_id']}}_{{$comment['id']}}" >

											<div class='comment-list'>

												<div class='bg-img'>

													<a>

														<div class='usr-pic-profil' style="background-image:url({{asset(!empty($comment['user']['image'])?$comment['user']['image']:'/images/deaultuser.jpg')}});" ></div>

													</a>

												</div>

												<div class='comment'>

													<h3>

														<a href="{{route('getProfil',['user_id'=>$comment['user']['id']])}}">{{$comment['user']['prenom'].' '.$comment['user']['nom']}}</a>

													</h3>

													<span><img src='images/clock.png' alt=''>

                                                       <?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($comment['date_ajout']))->diffForHumans();?>
                                                    </span>

													<p>{{$comment['detail']}}</p>

													@if(Auth::check() && ($comment['user']['id']==Auth::user()->id || $post['par']==Auth::user()->id || Auth::user()->user_type==0))

														<b class='btn_delcmnt' onclick="deleteComment({{$post['post_id']}}, {{$comment['id']}});" >{{config('lang.lbl_delete')[empty(session('lang'))?0:session('lang')]}}</b>

													@endif

												</div>

											</div>

										</li>

									@endforeach

								@endif

							</ul>

						</div>

						<div class='post-comment'>

							<div class='comment_box'>

                               @if(Auth::check())

								<input type='text' id="txt_comentaire_{{$post['post_id']}}" placeholder="{{config('lang.lbl_yourcmnt')[empty(session('lang'))?0:session('lang')]}}" required />

								<button class='btncmnt' onclick="set_comnt({{$post['post_id']}});" >{{config('lang.lbl_commenter')[empty(session('lang'))?0:session('lang')]}}</button>

								@else

								<button class='btncmnt'>{{config('lang.lbl_commenter')[empty(session('lang'))?0:session('lang')]}}</button>

								@endif

							</div>

						</div>

					</div>
    </div>
</div>


